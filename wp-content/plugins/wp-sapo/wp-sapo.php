<?php

/**
 * Plugin Name: Wordpress SAPO
 * Plugin URI: http://tuandaoit.me
 * Description: Công cụ quản lý Sapo trên Wordpress
 * Version: 1.0
 * Author: Tuan Dao
 * Author URI: http://tuandaoit.me
 * License: GPL2
 * Created On: 20-10-2018
 * Updated On: 31-10-2018
 */
// Define SAPO_PLUGIN_DIR.
if (!defined('SAPO_PLUGIN_DIR')) {
    define('SAPO_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Define WC_PLUGIN_FILE.
if (!defined('SAPO_PLUGIN_URL')) {
    define('SAPO_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('SAPO_API_DOMAIN'))           define('SAPO_API_DOMAIN', 'tuandaotest.bizwebvietnam.net');
if (!defined('SAPO_API_KEY'))           define('SAPO_API_KEY', 'a154aa8cbe784a1cbe4a58e526e2ef88');
if (!defined('SAPO_API_SECRET'))       define('SAPO_API_SECRET', '8aec934594b64ced9507eb3038bbc0e8');

require_once('autoload.php');

register_activation_hook(__FILE__, 'sapo_ip_create_db');

add_action('plugins_loaded', 'kiotviet_tools_plugin_init');

function kiotviet_tools_plugin_init() {
    
    add_action('admin_menu', 'sapo_tools_admin_menu');
    
    add_action('login_init', 'send_frame_options_header', 10, 0);
    add_action('admin_init', 'send_frame_options_header', 10, 0);
    
    // Connection String
    add_option('sapo_api_domain', SAPO_API_DOMAIN);
    add_option('sapo_api_key', SAPO_API_KEY);
    add_option('sapo_api_secret', SAPO_API_SECRET);
}

function sapo_tools_admin_menu() {
    add_menu_page('SAPO Tools', 'SAPO Tools', 'edit_posts', 'sapo-tools', 'function_mypos_options_page', 'dashicons-admin-multisite', 4);
    add_submenu_page('sapo-tools', __('SAPO Tools'), __('SAPO Tools'), 'edit_posts', 'sapo-tools');
    add_submenu_page('sapo-tools', __('Nhập mã sản phẩm'), __('Nhập mã sản phẩm'), 'edit_posts', 'setup-sapo-sku', 'function_setup_sapo_sku');
    add_submenu_page('sapo-tools', __('Testing'), __('Testing'), 'manage_options', 'sapo-testing', 'function_testing_page');
}

function function_mypos_options_page() {
    
    load_assets_page_options();
    
    echo '<div class="wrap"><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cài Đặt SAPO Tools
                        </div>
                        <div class="panel-body">';
    
    if (isset($_POST['sapo_api_key'])) {
        update_option('sapo_api_domain', $_POST['sapo_api_domain']);
        update_option('sapo_api_secret', $_POST['sapo_api_secret']);
        update_option('sapo_api_key', $_POST['sapo_api_key']);
        
        $sapo_api = new Sapo_API();
        $count = $sapo_api->get_count_product();

        $check = false;
        if (isset($count['count']) && !empty($count['count'])) {
            $check = true;
        }
        
        if ($check) {
            echo '<div class="alert alert-success">
                            <strong>Thông tin kết nối tới cửa hàng chính xác, vui lòng cập nhật ID và Mã sản phẩm để sử dụng.</strong>
                </div>';
        } else {
            echo '<div class="alert alert-danger">
                            <strong>Thông tin kết nối tới cửa hàng không chính xác, vui lòng kiểm tra lại.</strong>
                </div>';
        }
        
    }
    
    echo '<div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="POST">
                                        <div class="col-lg-12">
                                            <h3>Thiết lập kết nối Sapo API</h3>
                                            <div class="form-group">
                                                <label>API Domain</label>
                                                <input class="form-control" type="text" id="sapo_api_domain" name="sapo_api_domain" value="' . get_option('sapo_api_domain') . '" required>
                                            </div>
                                            <div class="form-group">
                                                <label>API Key</label>
                                                <input class="form-control" type="text" id="sapo_api_key" name="sapo_api_key" value="' . get_option('sapo_api_key') . '" required>
                                            </div>
                                            <div class="form-group">
                                                <label>API Secret</label>
                                                <input class="form-control" type="text" id="sapo_api_secret" name="sapo_api_secret" value="' . get_option('sapo_api_secret') . '" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary">Lưu Cài Đặt</button>
                                            <button type="reset" class="btn btn-default">Nhập Lại</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>';
}

function function_setup_sapo_sku() {
    
    set_time_limit(600);
    
    load_assets_match_sku();
    
    $kv_api = new Sapo_API();
    
    echo '<div class="wrap">';
    echo '<div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus-circle fa-fw"></i>
                            <strong><font color="blue">Cài đặt Mã sản phẩm SAPO</font></strong>
                        </div>
                        <div class="panel-body">';
    
    if (isset($_POST['process_checkSKU'])) {
       
        $product_id = trim($_POST['sapo_product_id']);
        $product_sku = trim($_POST['sapo_product_sku']);
        
        update_option('sapo_product_id', $product_id);
        update_option('sapo_product_sku', $product_sku);
        
        $real_id = check_id_matched_sku($product_id, $product_sku);
        update_option('sapo_real_id', $real_id);
        
        if ($real_id) {
            echo '<div class="alert alert-success">
                            <strong>ID và Mã sản phẩm chính xác, bạn có thể sử dụng ngay bây giờ.</strong>
                </div>';
        } else {
            echo '<div class="alert alert-danger">
                            <strong>ID và Mã sản phẩm không khớp hoặc không chính xác, vui lòng nhập lại.</strong>
                </div>';
        }
    }
    
    echo '          <form role="form" method="post" align="center">
                                        <div class="form-group">
                                        <label>ID sản phẩm: </label>
                                        <input class="form-control" type="text" id="sapo_product_id" name="sapo_product_id" value="' . get_option('sapo_product_id') . '" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mã sản phẩm: </label>
                                        <input class="form-control" type="text" id="sapo_product_sku" name="sapo_product_sku" value="' . get_option('sapo_product_sku') . '" required>
                                    </div>
                                <input type="hidden" id="process_checkSKU" name="process_checkSKU">
                                <button type="submit" class="btn btn-success btn-mypos-width">Kiểm tra và lưu mã sản phẩm</button>
                    </form>';
    
    echo '          <div class="alert alert-warning" style="margin-top: 15px; margin-bottom: 0!important">
                       Nhập mã sản phẩm và ấn lưu, nếu mã hợp lệ (tồn tại) thì sẽ được lưu.';
            echo '</div>';
    
    echo '</div></div></div></div>';
    
    echo '</div></div></div>';
}

function check_id_matched_sku($id, $sku) {
    $sapo_api = new Sapo_API();
    $product = $sapo_api->get_product_by_id($id);
    
    $check = 0;
    if (isset($product['product']) && !empty($product['product'])) {
        $product = $product['product'];
    } else {
        return $check;
    }
    
    if (isset($product['variants']) && !empty($product['variants'])) {
        $variants = $product['variants'];
        foreach ($variants as $item) {
            if ($item['sku'] == $sku) {
                $check = $item['id'];
                return $check;
            }
        }
    }
    return $check;
}

function function_testing_page() {
    build_order_json();
}

class Sapo_Ninja {

    public function Sapo_Ninja() {
        
    }
    
    public function build_order_json($raw) {
        $line_item['variant_id'] = get_option('sapo_real_id');
        $line_item['quantity'] = 1;
        
        $data['line_items'][] = $line_item;
        $IP = get_client_ip();
        $time_str = date('dmy.his');
        $email_build = "$IP@$time_str";
        $data['email'] = $email_build;

        $data['customer']['first_name'] = $raw['client_name'];
        $data['customer']['last_name'] = "";
        $data['customer']['email'] = $email_build;
    //    "customer": {
    //      "first_name": "Paul",
    //      "last_name": "Norman",
    //      "email": "paul.norman@example.com"
    //    },
        //$data['fulfillment_status'] = 'fulfilled';
        $data['financial_status'] = 'pending';
        $data['billing_address']['first_name'] = $raw['client_name'];
        $data['billing_address']['last_name'] = "";
//        $data['billing_address']['address1'] = $raw['client_url'];
        $data['billing_address']['phone'] = $raw['client_phone'];
        
        $data['tags'] = $raw['client_url'];
//        $data['source_identifier'] = $raw['client_url'];
//        $data['source_name'] = $raw['client_url'];
//        $data['landing_site'] = $raw['client_url'];
//        $data['landing_site_ref'] = $raw['client_url'];
//        $data['referring_site'] = $raw['client_url'];
//        $data['reference'] = $raw['client_url'];
        
        if (isset($raw['note']) && !empty($raw['note'])) {
            $data['note'] = $raw['note'];
        }
        
        $return['order'] = $data;
        
        return $return;
    }


    private function parse_data($raw) {
        $return = array();
        
        if (isset($raw['fields_by_key']) && !empty($raw['fields_by_key'])) {
            foreach ($raw['fields_by_key'] as $key => $item) {
                $return[$key] = $item['value'];
            }
        }
        
        return $return;
    }

    public function process_wp_sapo($raw) {
    
        $data = $this->parse_data($raw);
        
        $dbModel = new DbModel();
        $ip = get_client_ip();
        $check_ip = $dbModel->check_ip($ip);
        $dbModel->insert_ip($ip);
        if (!empty($check_ip)) {
            //2018-11-02 07:09:33
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $check_ip['created']);
            $str_time = $date->format('d-m-Y H:i:s');
            $data['note'] = "IP: $ip đã đặt đơn hàng trước đây vào lúc " . $str_time;
        }
        
        $converted_data = $this->build_order_json($data);
        
        if (!empty($converted_data)) {
            $sapo_api = new Sapo_API();
            $sapo_api->create_order($converted_data);
        }
    }

}

?>