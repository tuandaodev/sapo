<?php

include_once 'function.php';

class Sapo_API {
    
    private $sapo_api_domain = '';
    private $sapo_api_key = '';
    private $sapo_api_secret = '';
    private $api_url = '';
    
    function __construct() {
        $this->sapo_api_domain = get_option('sapo_api_domain');
        $this->sapo_api_key = get_option('sapo_api_key');
        $this->sapo_api_secret = get_option('sapo_api_secret');
        
        $this->api_url = "https://{$this->sapo_api_key}:{$this->sapo_api_secret}@{$this->sapo_api_domain}/admin/";
    }
    
    public function get_count_product() {
        $url = "https://{$this->sapo_api_domain}/admin/products/count.json";
        $result = $this->api_call($url);
        return $result;
    }
    
    public function get_product_by_id($id) {
        $url = "https://{$this->sapo_api_domain}/admin/products/$id.json";
        $result = $this->api_call($url);
        return $result;
    }
    
    public function api_call($url, $data = []) {

        if (!empty($data) && is_array($data)) {
            $url = $url . '?' . http_build_query($data, '', '&');
        } 
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_MAXREDIRS => 3,
         CURLOPT_TIMEOUT => 15,
         CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_HTTPHEADER => array(
           "Content-Type: application/json",
           "Authorization: Basic " . base64_encode($this->sapo_api_key . ":" . $this->sapo_api_secret)
         ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $result = json_decode($response, true);
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    public function create_order($json_data) {
        
        $url = "https://{$this->sapo_api_domain}/admin/orders.json";

        $curl = curl_init();

        $json_data = json_encode($json_data);
        
        curl_setopt_array($curl, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_MAXREDIRS => 3,
         CURLOPT_TIMEOUT => 15,
         CURLOPT_CUSTOMREQUEST => "POST",
         CURLOPT_POSTFIELDS => $json_data,
         CURLOPT_HTTPHEADER => array(
           "Content-Type: application/json",
           "Authorization: Basic " . base64_encode($this->sapo_api_key . ":" . $this->sapo_api_secret)
         ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $result = json_decode($response, true);
        
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
    
}