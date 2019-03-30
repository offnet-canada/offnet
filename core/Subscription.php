<?php
/*
 * Subscription class
 * Handles:
 * Creating subscription
 * Get Credit
 * Set Credit
 */
class Subscription {
    /*
     * Create Subscription
     *
     * The new subscription should include
     * remaining credit from previous subscription
     * 
     * @param int    $id      Account Id
     * @param int    $credit  Amount of credits
     * @param string $name    Name of subscription
     */
    public static function create($id, $credit, $name = "trial") { 
        $mysql = db('accounts');
        $id = $mysql->real_escape_string($id);
        $credit = $mysql->real_escape_string($credit);
        $name = $mysql->real_escape_string($name);
        //Disable all other subscriptions
        $query = "UPDATE `subscription` SET `enabled` = '0' WHERE `account_id` = $id";
        $mysql->query($query);
        //Create new subscription
        $query = "INSERT INTO `subscription` (`id`, `account_id`, `date`, `credit`, `used`, `name`, `enabled`) VALUES (NULL, '$id', CURRENT_TIMESTAMP, '$credit', '0', '$name', '1')";
        $mysql->query($query);
    }
    /*
     * Get Credit
     * Returns remaining credit
     * 
     * @param int $id Account Id
     */
    public static function getCredit($id) {
        $mysql = db('accounts');
        $id = $mysql->real_escape_string($id);
        $query = "SELECT credit, used FROM `subscription` WHERE `account_id` = '$id' AND `enabled` = '1'";
        $result = $mysql->query($query);
        $sub = $result->fetch_assoc();
        if ($sub['credit'] === NULL) {
            return false;
        };
        return $sub['credit'] - $sub['used'];
    }
    /*
     * Use Subscription
     * By using a subscription 
     * it incroments the 'used' value
     * 
     * @param int $id   Account Id
     * @param int $used Number of credits used in request
     */
    public static function useSub($id, $used) {
        $mysql = db('accounts');
        $id = $mysql->real_escape_string($id);
        $used = $mysql->real_escape_string($used);
        $query = "UPDATE `subscription` SET `used` = used + $used WHERE `account_id` = $id";
        $mysql->query($query);
    }
    /*
     * Disable subscription
     * 
     * @param int $id Account Id
     */
    public static function disable($id) { 
        $mysql = db('accounts');
        $id = $mysql->real_escape_string($id);
        $used = $mysql->real_escape_string($used);
        //Disable subscription
        $query = "UPDATE `subscription` SET `enabled` = '0' WHERE `account_id` = $id";
        $mysql->query($query);
    }
}
