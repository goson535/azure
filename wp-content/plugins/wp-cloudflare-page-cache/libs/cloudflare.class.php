<?php

defined( 'ABSPATH' ) || die( 'Cheatin&#8217; uh?' );

class SWCFPC_Cloudflare
{

    private $main_instance = null;

    private $objects   = false;
    private $api_key   = "";
    private $email     = "";
    private $api_token = "";
    private $auth_mode = 0;
    private $zone_id   = "";
    //private $subdomain = "";
    private $api_token_domain = "";
    private $worker_mode = false;
    private $worker_content = "";
    private $worker_id = "";
    private $worker_route_id = "";
    private $account_id_list = array();

    function __construct( $auth_mode, $api_key, $email, $api_token, $zone_id, $worker_mode, $worker_content, $worker_id, $worker_route_id, $main_instance ) {

        $this->auth_mode       = $auth_mode;
        $this->api_key         = $api_key;
        $this->email           = $email;
        $this->api_token       = $api_token;
        $this->zone_id         = $zone_id;
        $this->worker_mode     = $worker_mode;
        $this->worker_content  = $worker_content;
        $this->worker_id       = $worker_id;
        $this->worker_route_id = $worker_route_id;
        $this->main_instance   = $main_instance;

        $this->actions();

    }


    function actions() {

        // Ajax clear whole cache
        add_action( 'wp_ajax_swcfpc_test_page_cache', array($this, 'ajax_test_page_cache') );

    }


    function set_auth_mode( $auth_mode ) {
        $this->auth_mode = $auth_mode;
    }


    function set_api_key( $api_key ) {
        $this->api_key = $api_key;
    }


    function set_api_email( $email ) {
        $this->email = $email;
    }


    function set_api_token( $api_token ) {
        $this->api_token = $api_token;
    }


    function set_api_token_domain( $api_token_domain ) {
        $this->api_token_domain = $api_token_domain;
    }


    function set_worker_id( $worker_id ) {
        $this->worker_id = $worker_id;
    }


    function set_worker_route_id( $worker_route_id ) {
        $this->worker_route_id = $worker_route_id;
    }


    function enable_worker_mode( $worker_content ) {
        $this->worker_mode = true;
        $this->worker_content = $worker_content;
    }


    function get_api_headers() {

        $cf_headers = array();

        if( $this->auth_mode == SWCFPC_AUTH_MODE_API_TOKEN ) {

            $cf_headers = array(
                "headers" => array(
                    "Authorization" => "Bearer ".$this->api_token,
                    "Content-Type" => "application/json"
                )
            );

        }
        else {

            $cf_headers = array(
                "headers" => array(
                    "X-Auth-Email" => $this->email,
                    "X-Auth-Key"   => $this->api_key,
                    "Content-Type" => "application/json"
                )
            );

        }

        $cf_headers["timeout"] = defined('SWCFPC_CURL_TIMEOUT') ? SWCFPC_CURL_TIMEOUT : 10;

        return $cf_headers;

    }


    function get_zone_id_list(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $zone_id_list = array();
        $per_page     = 50;
        $current_page = 1;
        $pagination   = false;
        $cf_headers   = $this->get_api_headers();

        do {

            if( $this->auth_mode == SWCFPC_AUTH_MODE_API_TOKEN && $this->api_token_domain != "" ) {

                if( is_object($this->objects["logs"]) ) {
                    $this->objects["logs"]->add_log("cloudflare::cloudflare_get_zone_ids", "Request for page $current_page - URL: ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones?name=".$this->api_token_domain ) );
                }

                $response = wp_remote_get(
                    esc_url_raw( "https://api.cloudflare.com/client/v4/zones?name=".$this->api_token_domain ),
                    $cf_headers
                );

            }
            else {

                if (is_object($this->objects["logs"])) {
                    $this->objects["logs"]->add_log("cloudflare::cloudflare_get_zone_ids", "Request for page $current_page - URL: " . esc_url_raw("https://api.cloudflare.com/client/v4/zones?page=$current_page&per_page=$per_page"));
                }

                $response = wp_remote_get(
                    esc_url_raw("https://api.cloudflare.com/client/v4/zones?page=$current_page&per_page=$per_page"),
                    $cf_headers
                );

            }

            if ( is_wp_error( $response ) ) {
                $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
                $this->objects["logs"]->add_log("cloudflare::get_zone_id_list", "Error wp_remote_get: ".$error );
                return false;
            }

            $response_body = wp_remote_retrieve_body($response);

            if( is_object($this->objects["logs"]) ) {
                $this->objects["logs"]->add_log("cloudflare::cloudflare_get_zone_ids", "Response for page $current_page: ".$response_body );
            }

            $json = json_decode( $response_body, true);

            if( $json["success"] == false ) {

                $error = array();

                foreach($json["errors"] as $single_error) {
                    $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
                }

                $error = implode(" - ", $error);

                return false;

            }

            if( isset($json["result_info"]) && is_array($json["result_info"]) ) {

                if( isset($json["result_info"]["total_pages"]) && intval($json["result_info"]["total_pages"]) > $current_page ) {
                    $pagination = true;
                    $current_page++;
                }
                else {
                    $pagination = false;
                }

            }
            else {

                if( $pagination )
                    $pagination = false;

            }

            if( isset($json["result"]) && is_array($json["result"]) ) {

                foreach( $json["result"] as $domain_data ) {

                    if( !isset($domain_data["name"]) || !isset($domain_data["id"]) ) {
                        $error = __("Unable to retrive zone id due to invalid response data", 'wp-cloudflare-page-cache');
                        return false;
                    }

                    $zone_id_list[$domain_data["name"]] = $domain_data["id"];

                }

            }


        } while( $pagination );


        if( !count($zone_id_list) ) {
            $error = __("Unable to find domains configured on Cloudflare", 'wp-cloudflare-page-cache');
            return false;
        }

        return $zone_id_list;

    }


    function get_current_browser_cache_ttl(&$error) {

        $this->objects = $this->main_instance->get_objects();
        $cf_headers = $this->get_api_headers();

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_get_browser_cache_ttl", "Request ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/settings/browser_cache_ttl" ) );
        }

        $response = wp_remote_get(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/settings/browser_cache_ttl" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::get_current_browser_cache_ttl", "Error wp_remote_get: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_get_browser_cache_ttl", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) && isset($json["result"]["value"]) ) {
            return $json["result"]["value"];
        }

        $error = __("Unable to find Browser Cache TTL settings ", 'wp-cloudflare-page-cache');
        return false;

    }


    function change_browser_cache_ttl($ttl, &$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers           = $this->get_api_headers();
        $cf_headers["method"] = "PATCH";
        $cf_headers["body"]   = json_encode( array("value" => $ttl) );

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_set_browser_cache_ttl", "Request URL: ".esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/settings/browser_cache_ttl") );
            $this->objects["logs"]->add_log("cloudflare::cloudflare_set_browser_cache_ttl", "Request body: " . json_encode(array("value" => $ttl)) );
        }

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/settings/browser_cache_ttl" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::change_browser_cache_ttl", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_set_browser_cache_ttl", "Response: ".$response_body);
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        return true;

    }


    function delete_page_rule($page_rule_id, &$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers = $this->get_api_headers();
        $cf_headers["method"] = "DELETE";

        if( $page_rule_id == "" ) {
            $error = __("There is not page rule to delete", 'wp-cloudflare-page-cache');
            return false;
        }

        if( $this->zone_id == "" ) {
            $error = __("There is not zone id to use", 'wp-cloudflare-page-cache');
            return false;
        }

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_delete_page_rule", "Request: ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules/$page_rule_id" ) );
        }

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules/$page_rule_id" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::delete_page_rule", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::cloudflare_delete_page_rule", "Response: ".wp_remote_retrieve_body($response));
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        return true;

    }


    function add_cache_everything_page_rule(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers = $this->get_api_headers();
        $url = site_url("/*");

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::add_cache_everything_page_rule", "Request URL: ".esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules") );
            $this->objects["logs"]->add_log("cloudflare::add_cache_everything_page_rule", "Request Body: ".json_encode(array("targets" => array(array("target" => "url", "constraint" => array("operator" => "matches", "value" => $url))), "actions" => array(array("id" => "cache_level", "value" => "cache_everything")), "priority" => 1, "status" => "active")) );
        }

        $cf_headers["method"] = "POST";
        $cf_headers["body"] = json_encode( array("targets" => array(array("target" => "url", "constraint" => array("operator" => "matches", "value" => $url))), "actions" => array(array("id" => "cache_level", "value" => "cache_everything")), "priority" => 1, "status" => "active") );

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::add_cache_everything_page_rule", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::add_cache_everything_page_rule", "Response: ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) && isset($json["result"]["id"]) ) {
            return $json["result"]["id"];
        }

        return false;

    }


    function add_bypass_cache_backend_page_rule(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers = $this->get_api_headers();
        $url = admin_url("/*");

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::add_bypass_cache_backend_page_rule", "Request URL: ".esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules") );
            $this->objects["logs"]->add_log("cloudflare::add_bypass_cache_backend_page_rule", "Request Body: ".json_encode(array("targets" => array(array("target" => "url", "constraint" => array("operator" => "matches", "value" => $url))), "actions" => array(array("id" => "cache_level", "value" => "bypass")), "priority" => 1, "status" => "active")) );
        }

        $cf_headers["method"] = "POST";
        $cf_headers["body"] = json_encode( array("targets" => array(array("target" => "url", "constraint" => array("operator" => "matches", "value" => $url))), "actions" => array(array("id" => "cache_level", "value" => "bypass")), "priority" => 1, "status" => "active") );

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/pagerules" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::add_bypass_cache_backend_page_rule", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::add_bypass_cache_backend_page_rule", "Response: ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) && isset($json["result"]["id"]) ) {
            return $json["result"]["id"];
        }

        return false;

    }


    function purge_cache(&$error) {

        $this->objects = $this->main_instance->get_objects();

        do_action("swcfpc_cf_purge_whole_cache_before");

        $cf_headers           = $this->get_api_headers();
        $cf_headers["method"] = "POST";
        $cf_headers["body"]   = json_encode( array( "purge_everything" => true ) );

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::purge_cache", "Request URL: ". esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache") );
            $this->objects["logs"]->add_log("cloudflare::purge_cache", "Request Body: ". json_encode(array("purge_everything" => true)) );
        }

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::purge_cache", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::purge_cache", "Response: ".$response_body);
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        do_action("swcfpc_cf_purge_whole_cache_after");

        return true;

    }


    function purge_cache_urls($urls, &$error) {

        $this->objects = $this->main_instance->get_objects();

        do_action("swcfpc_cf_purge_cache_by_urls_before");

        $cf_headers           = $this->get_api_headers();
        $cf_headers["method"] = "POST";

        if( count($urls) > 30 ) {

            $chunks = array_chunk($urls, 30);

            foreach( $chunks as $single_chunk ) {

                $cf_headers["body"] = json_encode(array("files" => $single_chunk));

                if (is_object($this->objects["logs"])) {
                    $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Request URL: " . esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache"));
                    $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Request Body: " . json_encode(array("files" => $single_chunk)));
                }

                $response = wp_remote_post(
                    esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache"),
                    $cf_headers
                );

                if (is_wp_error($response)) {
                    $error = __('Connection error: ', 'wp-cloudflare-page-cache') . $response->get_error_message();
                    $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Error wp_remote_post: ".$error );
                    return false;
                }

                $response_body = wp_remote_retrieve_body($response);

                if (is_object($this->objects["logs"])) {
                    $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Response: " . $response_body);
                }

                $json = json_decode($response_body, true);

                if ($json["success"] == false) {

                    $error = array();

                    foreach ($json["errors"] as $single_error) {
                        $error[] = $single_error["message"] . " (err code: " . $single_error["code"] . " )";
                    }

                    $error = implode(" - ", $error);

                    return false;

                }

            }

        }
        else {

            $cf_headers["body"] = json_encode(array("files" => $urls));

            if (is_object($this->objects["logs"])) {
                $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Request URL: " . esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache"));
                $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Request Body: " . json_encode(array("files" => $urls)));
            }

            $response = wp_remote_post(
                esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/purge_cache"),
                $cf_headers
            );

            if (is_wp_error($response)) {
                $error = __('Connection error: ', 'wp-cloudflare-page-cache') . $response->get_error_message();
                $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Error wp_remote_post: ".$error );
                return false;
            }

            $response_body = wp_remote_retrieve_body($response);

            if (is_object($this->objects["logs"])) {
                $this->objects["logs"]->add_log("cloudflare::purge_cache_urls", "Response: " . $response_body);
            }

            $json = json_decode($response_body, true);

            if ($json["success"] == false) {

                $error = array();

                foreach ($json["errors"] as $single_error) {
                    $error[] = $single_error["message"] . " (err code: " . $single_error["code"] . " )";
                }

                $error = implode(" - ", $error);

                return false;

            }

        }

        do_action("swcfpc_cf_purge_cache_by_urls_after");

        return true;

    }


    function get_account_ids(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $this->account_id_list = array();
        $cf_headers      = $this->get_api_headers();

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::get_account_ids", "Request ".esc_url_raw( "https://api.cloudflare.com/client/v4/accounts?page=1&per_page=20&direction=desc" ) );
        }

        $response = wp_remote_get(
            esc_url_raw( "https://api.cloudflare.com/client/v4/accounts?page=1&per_page=20&direction=desc" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::get_account_ids", "Error wp_remote_get: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::get_account_ids", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) ) {

            foreach( $json["result"] as $account_data ) {

                if( !isset($account_data["id"]) ) {
                    $error = __("Unable to retrive account ID", 'wp-cloudflare-page-cache');
                    return false;
                }

                $this->account_id_list[] = $account_data["id"];

            }

        }

        return $this->account_id_list;

    }


    function worker_get_list(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $workers_id_list = array();
        $cf_headers      = $this->get_api_headers();

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_get_list", "Request ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/scripts" ) );
        }

        $response = wp_remote_get(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/scripts" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_get_list", "Error wp_remote_get: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_get_list", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) ) {

            foreach( $json["result"] as $worker_data ) {

                if( !isset($worker_data["id"]) ) {
                    $error = __("Unable to retrive worker ID", 'wp-cloudflare-page-cache');
                    return false;
                }

                $workers_id_list[] = $worker_data["id"];

            }

        }

        return $workers_id_list;

    }


    function worker_upload(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers                            = $this->get_api_headers();
        $cf_headers["method"]                  = "PUT";
        $cf_headers["headers"]["Content-Type"] = "application/javascript";
        $cf_headers["body"]                    = $this->worker_content;

        $cloudflare_request_url = "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/scripts/$this->worker_id";

        if( $this->auth_mode == SWCFPC_AUTH_MODE_API_TOKEN ) {

            if( count($this->account_id_list) == 0 )
                $this->get_account_ids( $error );

            if( count($this->account_id_list) == 0 ) {
                $this->objects["logs"]->add_log("cloudflare::worker_upload", "Unable to retrive an account ID: $error" );
                return false;
            }

            $this->objects["logs"]->add_log("cloudflare::worker_upload", "I'm using the account ID: ".$this->account_id_list[0] );

            $cloudflare_request_url = "https://api.cloudflare.com/client/v4/accounts/".$this->account_id_list[0]."/workers/scripts/$this->worker_id";

        }

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_upload", "Request ".esc_url_raw( $cloudflare_request_url ) );
        }

        $response = wp_remote_post(
            esc_url_raw( $cloudflare_request_url ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_upload", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_upload", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) && isset($json["result"]["id"]) && $json["result"]["id"] == $this->worker_id ) {
            return true;
        }

        return false;

    }


    function worker_delete(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers           = $this->get_api_headers();
        $cf_headers["method"] = "DELETE";

        $cloudflare_request_url = "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/scripts/$this->worker_id";

        if( $this->auth_mode == SWCFPC_AUTH_MODE_API_TOKEN ) {

            if( count($this->account_id_list) == 0 )
                $this->get_account_ids( $error );

            if( count($this->account_id_list) == 0 ) {
                $this->objects["logs"]->add_log("cloudflare::worker_delete", "Unable to retrive an account ID: $error" );
                return false;
            }

            $this->objects["logs"]->add_log("cloudflare::worker_delete", "I'm using the account ID: ".$this->account_id_list[0] );

            $cloudflare_request_url = "https://api.cloudflare.com/client/v4/accounts/".$this->account_id_list[0]."/workers/scripts/$this->worker_id";

        }

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_delete", "Request ".esc_url_raw( $cloudflare_request_url ) );
        }

        $response = wp_remote_post(
            esc_url_raw( $cloudflare_request_url ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_delete", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_delete", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        return true;

    }


    function worker_route_create(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers = $this->get_api_headers();
        $url = site_url("/*");

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_create", "Request URL: ".esc_url_raw("https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes") );
        }

        $cf_headers["method"] = "POST";
        $cf_headers["body"] = json_encode( array("pattern" => $url, "script" => $this->worker_id) );

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_route_create", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_create", "Response: ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) && isset($json["result"]["id"]) ) {
            return $json["result"]["id"];
        }

        return false;

    }


    function worker_route_get_list(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $routes_list = array();
        $cf_headers  = $this->get_api_headers();

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_get_list", "Request ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes" ) );
        }

        $response = wp_remote_get(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_route_get_list", "Error wp_remote_get: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_get_list", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        if( isset($json["result"]) && is_array($json["result"]) ) {

            foreach( $json["result"] as $route_data ) {

                if( !isset($route_data["id"]) ) {
                    $error = __("Unable to retrive route ID", 'wp-cloudflare-page-cache');
                    return false;
                }

                $routes_list[$route_data["id"]] = array("pattern" => $route_data["pattern"], "script" => $route_data["script"]);

            }

        }

        return $routes_list;

    }


    function worker_route_delete(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $cf_headers           = $this->get_api_headers();
        $cf_headers["method"] = "DELETE";

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_delete", "Request ".esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes/$this->worker_route_id" ) );
        }

        $response = wp_remote_post(
            esc_url_raw( "https://api.cloudflare.com/client/v4/zones/$this->zone_id/workers/routes/$this->worker_route_id" ),
            $cf_headers
        );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::worker_route_delete", "Error wp_remote_post: ".$error );
            return false;
        }

        $response_body = wp_remote_retrieve_body($response);

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::worker_route_delete", "Response ".$response_body );
        }

        $json = json_decode( $response_body, true);

        if( $json["success"] == false ) {

            $error = array();

            foreach($json["errors"] as $single_error) {
                $error[] = $single_error["message"]." (err code: ".$single_error["code"]." )";
            }

            $error = implode(" - ", $error);

            return false;

        }

        return true;

    }


    function page_cache_test($url, &$error, $test_static=false) {

        $this->objects = $this->main_instance->get_objects();
        $cloudflare_cookie = $this->get_cloudflare_cookie();

        $args = array(
            'timeout'    => defined('SWCFPC_CURL_TIMEOUT') ? SWCFPC_CURL_TIMEOUT : 10,
            'sslverify'  => false,
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0',
            'headers' => array(
                'Accept' => 'text/html'
            )
        );

        if( is_object($cloudflare_cookie) )
            $args['headers']['cookie'] =  "{$cloudflare_cookie->name}={$cloudflare_cookie->value}";


        $this->objects["logs"]->add_log("cloudflare::page_cache_test", "Start test to $url with headers ".print_r($args, true) );

        // First test - Home URL
        $response = wp_remote_get( esc_url_raw( $url ), $args );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::page_cache_test", "Error wp_remote_get: ".$error );
            return false;
        }

        $headers = wp_remote_retrieve_headers( $response );

        if( is_object($this->objects["logs"]) ) {
            $this->objects["logs"]->add_log("cloudflare::page_cache_test", "Response Headers: ".var_export($headers, true) );
        }

        if( !$test_static && !isset($headers['X-WP-CF-Super-Cache']) ) {
            $error = __('The plugin is not detected on your home page. If you have activated other caching systems, please disable them and retry the test.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( !$test_static && $headers['X-WP-CF-Super-Cache'] == "no-cache" ) {
            $error = __('The cache is not enabled on your home page. It\'s not possibile to verify if the page caching is working properly.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( !isset($headers["CF-Cache-Status"]) ) {
            $error = __('Seem that your website is not behind Cloudflare. If you have recently enabled the cache or it is your first test, wait about 30 seconds and try again because the changes take a few seconds for Cloudflare to propagate them on the web. If the error persists, request support for a detailed check.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( !isset($headers["Cache-Control"]) ) {
            $error = __('Unable to find the Cache-Control response header.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( !$test_static && !isset($headers["X-WP-CF-Super-Cache-Cache-Control"]) ) {
            $error = __('Unable to find the X-WP-CF-Super-Cache-Cache-Control response header.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( strcasecmp($headers["Cache-Control"], "{resp:x-wp-cf-super-cache-cache-control}") == 0 ) {
            $error = __('Invalid Cache-Control response header. If you are using Litespeed Server, please disable the option <strong>Overwrite the cache-control header for Wordpress\'s pages using web server rules</strong>, purge the cache and retry.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( $this->worker_mode == true && !isset($headers["x-wp-cf-super-cache-worker-status"]) ) {
            $error = __('Unable to find the X-WP-CF-Super-Cache-Worker-Status response header. Worker mode seems not working correctly.', 'wp-cloudflare-page-cache');
            return false;
        }

        if( $this->worker_mode == true && ( strcasecmp($headers["x-wp-cf-super-cache-worker-status"], "hit") == 0 || strcasecmp($headers["x-wp-cf-super-cache-worker-status"], "miss") == 0 ) ) {
            return true;
        }

        if( strcasecmp($headers["CF-Cache-Status"], "HIT") == 0 || strcasecmp($headers["CF-Cache-Status"], "MISS") == 0 || strcasecmp($headers["CF-Cache-Status"], "EXPIRED") == 0 ) {
            return true;
        }

        if( strcasecmp($headers["CF-Cache-Status"], "REVALIDATED") == 0 ) {
            $error = sprintf( __('Cache status: %s - The resource is served from cache but is stale. The resource was revalidated by either an If-Modified-Since header or an If-None-Match header.', 'wp-cloudflare-page-cache'), $headers["CF-Cache-Status"]);
            return false;
        }

        if( strcasecmp($headers["CF-Cache-Status"], "UPDATING") == 0 ) {
            $error = sprintf( __('Cache status: %s - The resource was served from cache but is expired. The resource is currently being updated by the origin web server. UPDATING is typically seen only for very popular cached resources.', 'wp-cloudflare-page-cache'), $headers["CF-Cache-Status"]);
            return false;
        }

        if( strcasecmp($headers["CF-Cache-Status"], "BYPASS") == 0 ) {
            $error = sprintf( __('Cache status: %s - Cloudflare has been instructed to not cache this asset. It has been served directly from the origin.', 'wp-cloudflare-page-cache'), $headers["CF-Cache-Status"]);
            return false;
        }

        if( strcasecmp($headers["CF-Cache-Status"], "DYNAMIC") == 0 ) {

            $cookies = wp_remote_retrieve_cookies( $response );

            if( !empty($cookies) && count($cookies) > 1 )
                $error = sprintf( __('Cache status: %s - The resource was not cached by default and your current Cloudflare caching configuration doesn\'t instruct Cloudflare to cache the resource. Try to enable the <b>Strip response cookies on pages that should be cached</b> option and retry.', 'wp-cloudflare-page-cache'), $headers["CF-Cache-Status"]);
            else
                $error = sprintf( __('Cache status: %s - The resource was not cached by default and your current Cloudflare caching configuration doesn\'t instruct Cloudflare to cache the resource.  Instead, the resource was requested from the origin web server.', 'wp-cloudflare-page-cache'), $headers["CF-Cache-Status"]);

            return false;

        }

        $error = __("Undefined error", "wp-cloudflare-page-cache");

        return false;

    }


    function disable_page_cache(&$error) {

        $error = "";

        $this->objects = $this->main_instance->get_objects();

        // Reset old browser cache TTL
        $this->change_browser_cache_ttl( $this->main_instance->get_single_config("cf_old_bc_ttl", 0), $error );

        // Delete worker route
        if( $this->worker_mode == true && !$this->worker_route_delete($error) )
            return false;

        // Delete worker script
        if( $this->worker_mode == true && !$this->worker_delete($error) )
            return false;

        // Delete page rules
        if ( $this->worker_mode == false && $this->main_instance->get_single_config("cf_page_rule_id", "") != "" && !$this->delete_page_rule($this->main_instance->get_single_config("cf_page_rule_id", ""), $error)) {
            return false;
        }
        else {
            $this->main_instance->set_single_config("cf_page_rule_id", "");
        }

        if ( $this->worker_mode == false && $this->main_instance->get_single_config("cf_bypass_backend_page_rule_id", "") != "" && !$this->delete_page_rule($this->main_instance->get_single_config("cf_bypass_backend_page_rule_id", ""), $error)) {
            return false;
        }
        else {
            $this->main_instance->set_single_config("cf_bypass_backend_page_rule_id", "");
        }

        // Purge cache
        $this->purge_cache($error);

        // Reset htaccess
        $this->objects["cache_controller"]->reset_htaccess();

        $this->main_instance->set_single_config("cf_woker_route_id", "");
        $this->main_instance->set_single_config("cf_cache_enabled", 0);
        $this->main_instance->update_config();

        return true;

    }


    function enable_page_cache(&$error) {

        $this->objects = $this->main_instance->get_objects();

        $current_cf_browser_ttl = $this->get_current_browser_cache_ttl( $error );

        if( $current_cf_browser_ttl !== false ) {
            $this->main_instance->set_single_config("cf_old_bc_ttl", $current_cf_browser_ttl);
        }

        // Step 1 - set browser cache ttl to zero (Respect Existing Headers)
        if( !$this->change_browser_cache_ttl(0, $error) ) {
            $this->main_instance->set_single_config("cf_cache_enabled", 0);
            $this->main_instance->update_config();
            return false;
        }

        // Step 2 - delete old page rule, if exist
        if( $this->main_instance->get_single_config("cf_page_rule_id", "") != "" && $this->delete_page_rule( $this->main_instance->get_single_config("cf_page_rule_id", ""), $error_msg ) ) {
            $this->main_instance->set_single_config("cf_page_rule_id", "");
        }

        if( $this->main_instance->get_single_config("cf_bypass_backend_page_rule_id", "") != "" && $this->delete_page_rule( $this->main_instance->get_single_config("cf_bypass_backend_page_rule_id", ""), $error_msg ) ) {
            $this->main_instance->set_single_config("cf_bypass_backend_page_rule_id", "");
        }

        if( $this->worker_mode == true ) {

            // Delete old worker
            $this->worker_delete($error);

            // Delete existing route
            if( $this->worker_route_id != "" ) {

                if( !$this->worker_route_delete($error) ) {
                    $this->main_instance->set_single_config("cf_cache_enabled", 0);
                    $this->main_instance->update_config();
                    return false;
                }

            }

            // Step 3a - upload worker
            if( !$this->worker_upload($error) ) {

                $this->main_instance->set_single_config("cf_cache_enabled", 0);

                $return_array["status"] = "error";
                $return_array["error"] = $error;
                die(json_encode($return_array));

            }

            // Step 3b - create route
            $this->worker_route_id = $this->worker_route_create($error);

            if( !$this->worker_route_id ) {

                $this->worker_delete($error);

                $this->main_instance->set_single_config("cf_cache_enabled", 0);
                $this->main_instance->update_config();

                return false;

            }

            $this->main_instance->set_single_config("cf_woker_id", $this->worker_id);
            $this->main_instance->set_single_config("cf_woker_route_id", $this->worker_route_id);

        }
        else {

            // Step 3a - create new page rule to force bypass for backend URLs
            if( $this->main_instance->get_single_config("cf_bypass_backend_page_rule", 0) > 0 ) {

                $bypass_backend_page_rule_id = $this->add_bypass_cache_backend_page_rule( $error );

                if ($bypass_backend_page_rule_id == false) {
                    $this->main_instance->set_single_config("cf_cache_enabled", 0);
                    $this->main_instance->update_config();
                    return false;
                }

                $this->main_instance->set_single_config("cf_bypass_backend_page_rule_id", $bypass_backend_page_rule_id);

            }

            // Step 3b - create new page rule
            $cache_everything_page_rule_id = $this->add_cache_everything_page_rule($error);

            if ($cache_everything_page_rule_id == false && $bypass_backend_page_rule_id != "") {
                $this->delete_page_rule($bypass_backend_page_rule_id, $error);
                $this->main_instance->set_single_config("cf_cache_enabled", 0);
                $this->main_instance->update_config();
                return false;
            }

            $this->main_instance->set_single_config("cf_page_rule_id", $cache_everything_page_rule_id);

        }

        // Update config data
        $this->main_instance->update_config();

        // Step 4 - purge cache
        $this->purge_cache($error);

        $this->main_instance->set_single_config("cf_cache_enabled", 1);
        $this->main_instance->update_config();

        $this->objects["cache_controller"]->write_htaccess( $error );

        return true;

    }


    function get_cloudflare_cookie($url=false) {

        $cookie_name = "__cfduid";

        $args = array(
            'timeout'    => defined('SWCFPC_CURL_TIMEOUT') ? SWCFPC_CURL_TIMEOUT : 10,
            'sslverify'  => false,
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0',
            'headers' => array(
                'Accept' => 'text/html'
            )
        );

        $this->objects = $this->main_instance->get_objects();

        if( $url === false )
            $url = home_url();

        $response = wp_remote_get( esc_url_raw( $url ), $args );

        if ( is_wp_error( $response ) ) {
            $error = __('Connection error: ', 'wp-cloudflare-page-cache' ).$response->get_error_message();
            $this->objects["logs"]->add_log("cloudflare::get_cloudflare_cookie", "Error wp_remote_get: ".$error );
            return false;
        }

        $cookies = wp_remote_retrieve_cookies( $response );

        if ( empty( $cookies ) ) {
            $this->objects["logs"]->add_log("cloudflare::get_cloudflare_cookie", "No cookies found in response HTTP packet");
            return false;
        }
        else {

            $this->objects["logs"]->add_log("cloudflare::get_cloudflare_cookie", "Cookies found: ".print_r($cookies, true) );

            foreach ($cookies as $cookie) {

                if ($cookie->name === $cookie_name) {
                    return $cookie;
                }

            }

        }

        $this->objects["logs"]->add_log("cloudflare::get_cloudflare_cookie", "Cookie $cookie_name not found" );

        return false;

    }


    function ajax_test_page_cache() {

        check_ajax_referer( 'ajax-nonce-string', 'security' );

        $return_array = array("status" => "ok");
        $error_dynamic = "";
        $error_static = "";

        $url_static_resource = SWCFPC_PLUGIN_URL.'assets/testcache.html';
        $url_dynamic_resource = home_url();

        $return_array["static_resource_url"] = $url_static_resource;
        $return_array["dynamic_resource_url"] = $url_dynamic_resource;

        $headers_dyamic_resource = $this->page_cache_test( $url_dynamic_resource, $error_dynamic );

        if( ! $headers_dyamic_resource ) {

            $headers_static_resource = $this->page_cache_test( $url_static_resource, $error_static, true );
            $error = "";

            // Error on both dynamic and static test
            if( !$headers_static_resource ) {

                $error .= __( "Page caching seems not working for both dynamic and static pages.", 'wp-cloudflare-page-cache');
                $error .= "<br/><br/>";
                $error .= __( sprintf("Error on dynamic page (%s): %s", $url_dynamic_resource, $error_dynamic), 'wp-cloudflare-page-cache');
                $error .= "<br/><br/>";
                $error .= __( sprintf("Error on static resource (%s): %s", $url_static_resource, $error_static), 'wp-cloudflare-page-cache');
                $error .= "<br/><br/>";
                $error .= __( "Please check if the page caching is working by yourself by surfing the website in incognito mode 'cause sometimes Cloudflare bypass the cache for cURL requests. Reload a page two or three times. If you see the response header <strong>cf-cache-status: HIT</strong>, the page caching is working well.", 'wp-cloudflare-page-cache');

            }
            // Error on dynamic test only
            else {

                $error .= __( sprintf("Page caching is working for static page but seems not working for dynamic pages.", $url_static_resource), 'wp-cloudflare-page-cache');
                $error .= "<br/><br/>";
                $error .= __( sprintf("Error on dynamic page (%s): %s", $url_dynamic_resource, $error_dynamic), 'wp-cloudflare-page-cache');
                $error .= "<br/><br/>";
                $error .= __( "Please check if the page caching is working by yourself by surfing the website in incognito mode 'cause sometimes Cloudflare bypass the cache for cURL requests. Reload a page two or three times. If you see the response header <strong>cf-cache-status: HIT</strong>, the page caching is working well.", 'wp-cloudflare-page-cache');

            }

            $return_array["status"] = "error";
            $return_array["error"] = $error;

            die(json_encode($return_array));

        }

        $return_array["success_msg"] = __("Page caching is working properly", 'wp-cloudflare-page-cache');

        die(json_encode($return_array));

    }

}