<?php
/*
 * MessageLog class
 * Handles:
 * Creating logs
 * Count logs
 * Getting logs
 */
class MessageLog {
    /*
     * Create log
     * 
     * @param int $id          Account Id
     * @param string $request  Message recevied
     * @param string $response Message sent
     * @param string $service  The service used (Optional)
     */
    public static function create($id, $request, $response, $service) {
        $mysql = db('logs');
        $id = $mysql->real_escape_string($id);
        $request = $mysql->real_escape_string($request);
        $response = $mysql->real_escape_string($response);
        $service = $mysql->real_escape_string($service);
        //Disable all other subscriptions
        $query = "INSERT INTO `message` (`id`, `account_id`, `request`, `response`, `service`, `date`) VALUES (NULL, '$id', '$request', '$response', '$service', CURRENT_TIMESTAMP)";
        $mysql->query($query);
    }
    /* 
     * Count logs
     * return number of message proessed
     * in a given period of time
     * 
     * @param int  $id    Account Id
     * @param date $since Date to count logs from
     */
    public static function countLogs($id) {
        $mysql = db('logs');
        $id = $mysql->real_escape_string($id);
        //Disable all other subscriptions
        $query = "SELECT COUNT(id) FROM `message` WHERE `account_id` = $id AND date >= NOW() - INTERVAL 1 MINUTE";
        $result = $mysql->query($query);
        $row = $result->fetch_row();
        if (empty($row)) {
            return 0;
        } else {
            return $row[0];
        }
    }
}
