<?php
/*
 * Verify class
 *
 * Handle:
 * Generating passcodes
 * Checking entered codes
 */
class Verify {
    /*
     * Generate
     * 
     * Send after generation
     * 
     * @param int $id    Account Id
     * @param int $phone Phone Number
     */
    public static function generate($id, $phone) {
        $code = rand(10000, 99999);
        //Send Code
        $p = new Phone();
        $p->sendCode($phone, $code);
        //Hash Code
        $code = password_hash($code, PASSWORD_DEFAULT);
        $mysql = db('accounts');
        $code = $mysql->real_escape_string($code);
        $id = $mysql->real_escape_string($id);
        $query = "INSERT INTO `verification` (`id`, `account_id`, `code`, `date`, `valid`) VALUES (NULL, '$id', '$code', CURRENT_TIMESTAMP, '1')";
        $mysql->query($query);
    }
    /*
     * Check
     *
     * Check to see if code is valid
     *  
     * @param int $id   Account Id
     * @param int $code Code Attempt
     */
    public static function check($id, $code) {
        $mysql = db('accounts');
        $id = $mysql->real_escape_string($id);
        $query = "SELECT code FROM `verification` WHERE account_id = '$id' AND valid = '1'";
        $result = $mysql->query($query);
        $row = $result->fetch_assoc();
        //Make All Users Codes Invalid
        $query = "UPDATE `verification` SET valid = '0' WHERE account_id = '$id'";
        $result = $mysql->query($query);
        if (!empty($row) && password_verify($code, $row['code'])) {
            return true;
        } else {
            return false;
        }
    }
}
