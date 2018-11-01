<?php

require_once('function.php');
/**
 *
 * @author MT
 */

class DbModel {

    private $prefix;
    private $db_name;

    public function __construct() {
        $this->link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        mysqli_set_charset($this->link, "utf8");
        global $wpdb;
        $this->db_name = $wpdb->base_prefix . SAPO_IP_CUSTOMER;
    
    }
    
    public function query($query) {
        $result = mysqli_query($this->link, $query);
        
        if ($result) {
            $return = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $return = array();
        }
        
        return $return;
    }
    
    public function check_ip($ip) {
        
        if (!$ip) {
            return false;
        } else {
            $ip = trim($ip);
        }
        
        $query = "  SELECT *
                    FROM {$this->db_name}
                    WHERE ip = '" . $ip . "'
                    ORDER BY id DESC
                    LIMIT 1";
		
        $result = mysqli_query($this->link, $query);
        
        if ($result) {
            $return = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
            if ($return) {
                return $return[0];
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function insert_ip($ip) {
        $ip = trim($ip);
        $query = '  INSERT INTO ' . $this->db_name . '(ip, created)
                        VALUES (
                        "' . $ip . '",
                        "' . date('Y-m-d H:i:s') . '")';
        
        $result = mysqli_query($this->link, $query);
        return $result;
    }
}

