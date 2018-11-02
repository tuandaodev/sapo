<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function load_assets_common_admin() {
    
    // JS
    wp_register_script('prefix_jquery', SAPO_PLUGIN_URL . 'assets/admin/lib/jquery-3.3.1.min.js');
    wp_enqueue_script('prefix_jquery');
    
    wp_register_script('prefix_bootstrap', SAPO_PLUGIN_URL . 'assets/admin/lib/bootstrap.min.js');
    wp_enqueue_script('prefix_bootstrap');
    
    // CSS
    wp_register_style('prefix_bootstrap', SAPO_PLUGIN_URL . 'assets/admin/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
    wp_enqueue_style('my-styles', SAPO_PLUGIN_URL . 'assets/admin/css/styles.css' );
    wp_enqueue_style('font-awesome', SAPO_PLUGIN_URL . 'assets/admin/font-awesome/css/font-awesome.min.css' );
}

?>