<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;

$db_name = $wpdb->base_prefix . SAPO_IP_CUSTOMER;
$wpdb->query("DROP TABLE IF EXISTS {$db_name}");