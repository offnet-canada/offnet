<?xml version="1.0" encoding="utf-8"?>
<resources>
<?php

//The android application uses the xml generated from this script
//to display all RSS sources and feeds

//This script outputs all sources and feeds as xml arrays

require_once "init.php";

//Sources
echo "<array name=\"sources\">\n";
$mysql = db("rss");
$query = "SELECT DISTINCT source FROM feed WHERE user_id IS NULL;";
$results = $mysql->query($query);
while ($row = $results->fetch_assoc()) {
    echo "  <item name=\"" . strtoupper($row['source']) . "\">" . strtoupper($row['source']) . "</item>\n";
}
echo "</array>\n";

//Feeds
$query = "SELECT DISTINCT source FROM feed WHERE user_id IS NULL;";
$results = $mysql->query($query);
while ($row = $results->fetch_assoc()) {
    echo "<array name=\"" . strtoupper($row['source']) . "\">\n";
    $source = $mysql->real_escape_string($row['source']);
    $query = "SELECT DISTINCT feed FROM feed WHERE source LIKE '$source';";
    $feeds = $mysql->query($query);
    while ($feed = $feeds->fetch_assoc()) {
        echo "  <item name=\"" . strtoupper($feed['feed']) . "\">" . strtoupper($feed['feed']) . "</item>\n";
    }
    echo "</array>\n";
}
?>
</resources>
