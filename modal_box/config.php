<?php
class config{

    function __construct(){
        add_action("admin_menu", array($this, "crear_menu"));
        add_action ('admin_enqueue_scripts', function () {
            if(is_admin()){
                wp_enqueue_media();
            }
        });
    }

    public function crear_menu() {
        add_menu_page('Modal Box Configuración', 'Modal Box', 'manage_options', 'modal_box_config', array($this, 'menu_config'));
    }

    public function menu_config() {
        global $wpdb;
        ?>
        <div class="wrap">
            <h1>Menú Configuración Modal Box</h1>

            <br>
            <br>

            <form method="post" action="<?php echo plugins_url('/includes/update_data.php', __FILE__); ?>">
                <input type="hidden" name="db_host" id="db_host" value="<?php echo $wpdb->dbhost; ?>">
                <input type="hidden" name="db_name" id="db_name" value="<?php echo $wpdb->dbname; ?>">
                <input type="hidden" name="db_user" id="db_user" value="<?php echo $wpdb->dbuser; ?>">
                <input type="hidden" name="db_password" id="db_password" value="<?php echo $wpdb->dbpassword; ?>">

                <label>Tiempo: </label>
                <input type="number" id="tiempo" name="tiempo" value="<?php echo $this->getDatosModal()->tiempo; ?>">
                <strong> Segundos.</strong>
                <br>
                <br>
                <br>

                <label>Texto Informativo:</label>
                <textarea id="texto" name="texto" rows="5"><?php echo $this->getDatosModal()->txt; ?></textarea>
                <br>
                <br>
                <br>

                <label>Ruta Imagen: <strong><?php echo get_site_url() . ""; ?></strong></label>
                <input type="text" id="ruta_imagen" name="ruta_imagen" value="<?php echo $this->getDatosModal()->foto; ?>" readonly>&nbsp;<button type="button" class="set_custom_images button">Buscar Imagen</button>

                <br>
                <br>
                <br>

                <?php submit_button(); ?>
            </form>

            <script type="text/javascript" src="<?php echo plugins_url('/js/jquery-3.4.0.js', __FILE__); ?>"></script>
            <script type='text/javascript' src="<?php echo plugins_url('/js/admin.js', __FILE__); ?>"></script>
        </div>

        <?php
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

new config();