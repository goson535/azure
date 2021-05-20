<?php

defined( 'ABSPATH' ) || die( 'Cheatin&#8217; uh?' );

class SWCFPC_Logs
{

    private $main_instance = null;

    private $is_logging_enabled  = false;
    private $log_file_path       = false;
    private $log_file_url        = false;

    function __construct($log_file_path, $log_file_url, $logging_enabled, $max_file_size, $main_instance)
    {

        $this->log_file_path       = $log_file_path;
        $this->log_file_url        = $log_file_url;
        $this->is_logging_enabled  = $logging_enabled;
        $this->main_instance       = $main_instance;

        // Reset log if it exceeded the max file size
        if( $max_file_size > 0 && file_exists($log_file_path) && ( filesize($log_file_path) / 1024 / 1024 ) >= $max_file_size )
            $this->reset_log();

        $this->actions();

    }


    function actions() {

        // Ajax clear logs
        add_action( 'wp_ajax_swcfpc_clear_logs', array($this, 'ajax_clear_logs') );

        // Download logs
        add_action( 'init', array($this, 'download_logs') );

    }


    function enable_logging() {
        $this->is_logging_enabled = true;
    }


    function disable_logging() {
        $this->is_logging_enabled = false;
    }


    function add_log($identifier, $message) {

        if( $this->is_logging_enabled && $this->log_file_path ) {

            $log = sprintf("[%s] [%s] %s", date("Y-m-d H:i:s"), $identifier, $message) . PHP_EOL;

            error_log($log, 3, $this->log_file_path);

        }

    }


    function get_logs() {

        $log = "";

        if( $this->log_file_path )
            $log = file_get_contents( $this->log_file_path );

        return $log;

    }


    function reset_log() {

        if( $this->log_file_path )
            file_put_contents( $this->log_file_path, "" );

    }


    function download_logs() {

        if( isset($_GET['swcfpc_download_log']) ) {

            $file_log = file_get_contents($this->log_file_path);
            $filename = "debug.log";

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . strlen($file_log));

            die( $file_log );

        }

    }


    function ajax_clear_logs() {

        check_ajax_referer( 'ajax-nonce-string', 'security' );

        $return_array = array("status" => "ok");

        if( !current_user_can('manage_options') ) {
            $return_array["status"] = "error";
            $return_array["error"] = __("Permission denied", "wp-cloudflare-page-cache");
            die(json_encode($return_array));
        }

        $this->reset_log();

        $return_array["success_msg"] = __("Log cleaned successfully", "wp-cloudflare-page-cache");

        die(json_encode($return_array));

    }

}