<?php
/*
  Plugin Name: Modal Box
  Plugin URI:
  Description: Modal con Información configurable
  Author: Felipe Rodríguez
  Version: 1.0.0
  Author URI: http://www.lazos.cl
 */

include (plugin_dir_path(__FILE__) . "config.php");

class modal_box{

    function __construct(){

        add_action('wp_enqueue_scripts', array($this, 'script_modal_box'));
        add_action('wp_enqueue_styles', array($this, 'style_modal_box'));

        add_shortcode('modal_box', array($this, 'shortcode_modal_box'));

        $this->db_connect();
    }

    public function shortcode_modal_box() {

        wp_enqueue_script('info_box_modal');
        wp_enqueue_style('modal_box-custom-style');

        return $this->modal();
    }

    public function script_modal_box() {
        wp_register_script('info_box_modal', plugins_url('/js/modal_box.js', __FILE__));
    }

    public function style_modal_box() {
        wp_register_style('modal_box-custom-style', plugins_url('/css/custom.css', __FILE__));
    }

    public function modal(){
        $html = "<link rel='stylesheet' type='text/css' href='" . plugins_url('/css/custom.css', __FILE__) . "'>
                
                <div id='modal_box'>
                    <div id='modal_info' class='modal text-center'>
                        <div class='modal-content'>
                            <span class='close'>&times;</span>
                            <input type='hidden' id='tiempo_modal' value='" . ($this->getDatosModal()->tiempo * 1000) . "'>
                            <img src='" . get_site_url() . $this->getDatosModal()->foto . "' style='width: 50%;'>
                            
                            <br>
                            <span>" . nl2br($this->getDatosModal()->txt) . "</span>
                        </div>
                    </div>
                
                    <script type='text/javascript' src='" . plugins_url('/js/jquery-3.4.0.js', __FILE__) . "'></script>
                    <script type='text/javascript' src='" . plugins_url('/js/modal_box.js', __FILE__) . "'></script>
                </div>";

        return $html;
    }

    public function db_connect(){
        global $wpdb;

        $modal_photo = "CREATE TABLE IF NOT EXISTS modal_info(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, directorio_img text NOT NULL, txt_info TEXT NOT NULL, tiempo INT NOT NULL)";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($modal_photo);
    }

    public function getDatosModal(){
        global $wpdb;

        $result = $wpdb->get_results("SELECT tiempo, directorio_img, txt_info FROM modal_info WHERE id = 1");

        $data_foto = new stdClass();
        $data_foto->tiempo = $result[0]->tiempo;
        $data_foto->foto = $result[0]->directorio_img;
        $data_foto->txt = $result[0]->txt_info;

        return $data_foto;
    }
}

ob_clean();
ob_start();

new modal_box();