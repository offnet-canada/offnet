<?php
namespace Apps;

class Rss {
	/*
	 * Raw function
	 * List Sources
	 * rss:
	 * List Feeds
	 * rss:<SOURCE>
	 * List Titles
	 * rss:<SOURCE>:<FEED>
	 * Item Details
	 * rss:<SOURCE>:<FEED>:#
	 */
	public function raw($msg) {
        //Source
		return self::start($msg[1], $msg[2], $msg[3])["text"];
	}

	/*
	 * JSON decoding
	 * "source" => ""
	 * "feed" => ""
	 * "item" => ""
	 */
	public function json($json) {
		//Source
		return \Response::genericBuilder(self::start($json->source, $json->feed, $json->item)["json"]);
	}

	//Calls correct database call
    private function start($source = "", $feed = "", $item = "") {
        //Catch all options
        if ($source == "") {
            return self::getSources();
        } else if ($feed == "") {
            return self::getFeeds(strtolower($source));
        } else if ($item == "") {
            return self::getTitles(strtolower($source), strtolower($feed));
        } else {
            return self::getItem(strtolower($source), strtolower($feed), strtolower($item));
        }
	}

	//Get Data from database
    private function getSources() {
        $mysql = db("rss");
        $query = "SELECT DISTINCT source FROM feed WHERE user_id IS NULL;";
        $results = $mysql->query($query);
        $text = "rss:<SOURCE>n\nSources:";
        $i = 0;
        $json = array();
        while ($row = $results->fetch_assoc()) {
            $text .= "\n" . $row['source'];
            $json[$i] = $row['source'];
            $i++;
        }
        return array("text" => $text, "json" => $json);
    }

    private function getFeeds($source) {
        $mysql = db("rss");
        $source = $mysql->real_escape_string($source);
        $query = "SELECT DISTINCT feed FROM feed WHERE user_id IS NULL AND source LIKE '$source';";
        $results = $mysql->query($query);
        $text = "rss:" . $source . ":<FEED>\n\nFeeds:";
        $i = 0;
        $json = array();
        while ($row = $results->fetch_assoc()) {
            $text .= "\n" . $row['feed'];
            $json[$i] = $row['feed'];
            $i++;
        }
        return array("text" => $text, "json" => $json);
    }

    private function getTitles($source, $feed) {
        $mysql = db("rss");
        $source = $mysql->real_escape_string($source);
        $feed = $mysql->real_escape_string($feed);
        $query = "SELECT item_id, title FROM feed_data WHERE feed_id = (SELECT id FROM feed WHERE source = '$source' AND feed = '$feed')";
        $results = $mysql->query($query);
        $text = "rss:" . $source . ":" . $feed . ":<STORY#>";
        $json = array();
        //Adding upper limit of 10
        $i = 0;
        while (($row = $results->fetch_assoc()) && $i < 10) {
            $text .= "\n" . $row['item_id'] . ": " . $row['title'];
            $json[$row['item_id']] = $row['title'];
            $i++;
        }
        return array("text" => $text, "json" => $json);
    }

    private function getItem($source, $feed, $id) {
        $mysql = db("rss");
        $source = $mysql->real_escape_string($source);
        $feed = $mysql->real_escape_string($feed);
        $id = $mysql->real_escape_string($id);
        $query = "SELECT description FROM feed_data WHERE feed_id = (SELECT id FROM feed WHERE source = '$source' AND feed = '$feed') AND item_id = '$id'";
        $results = $mysql->query($query);
        $text = strtoupper($source) . " " . strtoupper($feed) . " " . strtoupper($id) . ":\n";
        $json = array();
        while ($row = $results->fetch_assoc()) {
            $text .= $row['description'];
            $json[$id] = $row['description'];
        }
        return array("text" => $text, "json" => $json);
	}

	//Create new feed
	public static function createFeed($url, $source, $feed = "main", $user_id = null) {
		$mysql = db("rss");
		$url = $mysql->real_escape_string($url);
		$source = $mysql->real_escape_string($source);
		$feed = $mysql->real_escape_string($feed);
		$query = "INSERT into `feed` (`id`, `url`, `source`, `feed`, `user_id`) VALUES (NULL, '$url', '$source', '$feed'";
		if ($user_id != null) {
			$user_id = $mysqli->real_escape_string($feed);
			$query .= ", '$user_id');";
		} else {
			$query .= ", NULL);";
		}
		$mysql->query($query);
		$mysql->close();
	}

	//Updates all feeds
	//Creates a temp table
	//Replaces current table with temp
	public static function updateAll() {
		require "/home/offnet/public_html/offnet/thirdparty/rss-php/src/Feed.php";
		$mysql = db("rss");
		$key = $mysql->real_escape_string(md5(microtime().rand()));
        //Create Temp Table
        echo "Creating table temp_$key\n";
		$query = "CREATE TABLE temp_$key LIKE feed_data;";
        $mysql->query($query);
        //Pull list of all feeds
        echo "Getting list of feeds\n";
		$query = "SELECT id, url, atom FROM `feed`;";
        $results = $mysql->query($query);
        echo "Getting feed information\n";
		//Pull latest info for each feed
        while ($row = $results->fetch_assoc()) {
                if ($row['atom'] == 0) {
                    try {
                        $rss = \Feed::loadRss($row['url']);
                    } catch (\FeedException $e) {
                        try {
                            $rss = \Feed::loadAtom($row['url']);
                            $query = "UPDATE `feed` SET `atom` = '1' WHERE `feed`.`id` = '" . $row['id'] . "';";
                            $mysql->query($query);
                        } catch (\FeedException $e) {
                            echo $e->getMessage() . "\n";
                            $query = "UPDATE `feed` SET `invalid` = '1' WHERE `feed`.`id` = '" . $row['id'] . "';";
                            $mysql->query($query);
                            $rss = null;
                        }
                    }
                } else {
                    try {
                        $rss = \Feed::loadAtom($row['url']);
                    } catch (\FeedException $e) {
                        echo $e->getMessage() . "\n";
                        $query = "UPDATE `feed` SET `invalid` = '1' WHERE `feed`.`id` = '" . $row['id'] . "';";
                        $mysql->query($query);
                        continue;
                    }
                }
                $a = 0;
                foreach ($rss->item?$rss->item:$rss->entry as $item) {
                    $a++;
                    $title = $mysql->real_escape_string($item->title);
                    $link = $mysql->real_escape_string($item->link);
                    if (!isset($item->timestamp)) {
                        $time = 0;
                    } else {
                        $time = $mysql->real_escape_string($item->timestamp);
                    }
                    $description = trim(strip_tags($item->description?$item->description:$item->summary));
                    $description = $mysql->real_escape_string($description);
                    $feed_id = $mysql->real_escape_string($row["id"]);
                    echo "$feed_id, $a, $link, $time, $title\n";
                    $query = "INSERT INTO `temp_$key` 
                        (`feed_id`, `item_id`, `title`, `link`, `description`, `date`) 
                        VALUES ('$feed_id', '$a', '$title', '$link', '$description', '$time');";
                    $mysql->query($query) or die(mysqli_error($mysql));;
                }
        }
        echo "Droping old table\n";
		//Replace exsiting table
        $query = "DROP TABLE IF EXISTS `feed_data`;";
        $mysql->query($query);
        echo "Ranaming new table\n";
        $query = "RENAME TABLE `temp_$key` TO `feed_data`;";
		$mysql->query($query);
		$mysql->close();
	}

	//Updates a single feed
	//Deletes exsiting items if found
    public function update($id) {
        //TODO lots of lettuce
	}

}
