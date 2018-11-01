<?php

if (!defined('SAPO_IP_CUSTOMER')) {
    define('SAPO_IP_CUSTOMER', 'sapo_ip');
}

function sapo_ip_create_db() {
    global $wpdb;
    $db_name = $wpdb->base_prefix . SAPO_IP_CUSTOMER;
    $charset_collate = $wpdb->get_charset_collate();
    
    if($wpdb->get_var("show tables like '$db_name'") != $db_name) 
    {
            $sql = 'CREATE TABLE ' . $db_name . ' (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `ip` VARCHAR(100) NULL,
                    `created` DATETIME NULL DEFAULT NOW(),
                    PRIMARY KEY (`id`)
            )' . $charset_collate . ';';
                
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
    }
}
