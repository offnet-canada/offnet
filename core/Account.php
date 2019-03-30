<?php
/*
 * Account Class
 * Handles:
 * Creating accounts
 * Getting account details
 * Setting email
 */
class Account {
    /*
     * Create Account
     *
     * @param string $phone Phone Number
     */
    public static function create($phone) {
        $mysql = db('accounts');
        //Hash Phone Number
        //$phone = password_hash($phone, PASSWORD_DEFAULT);
        $phone = $mysql->real_escape_string($phone);
        //Create Account
        $query = "INSERT INTO `account` (`id`, `phone`, `email`, `created`) VALUES (NULL, '$phone', NULL, CURRENT_TIMESTAMP)";
        $mysql->query($query);
        //Create Subscription
        $query = "SELECT id FROM `account` WHERE `phone` LIKE '$phone'";
        $result = $mysql->query($query);
        //Default trial subscription
        $trial = Core::ini('subscription', 'trial'); 
        \Subscription::create($result->fetch_assoc()['id'], $trial); 
    }
    
    /*
     * Get Account Id
     * 
     * @param string $phone Phone Number
     */
    public static function getId($phone) {
        $mysql = db('accounts');
        //Hash Phone Number
        //$phone = password_hash($phone, PASSWORD_DEFAULT);
        $phone = $mysql->real_escape_string($phone);
        //Find account id
        $query = "SELECT id FROM `account` WHERE `phone` LIKE '$phone'";
        $result = $mysql->query($query);
        $row = $result->fetch_assoc();
        if (empty($row)) {
            return false;
        } else {
            return $row['id'];
        }
    }

    /*
     * Set Email
     *
     * @param string $phone Phone Number
     * @param string $email Email
     */
    public function setEmail($phone, $email) {
    }
}
