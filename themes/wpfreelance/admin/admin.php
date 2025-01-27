<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class BX_Admin{
    static $instance;
    static $main_setting_slug = 'box-settings';

    function __construct(){
        add_action( 'admin_menu', array($this,'bx_register_my_custom_menu_page' ), 9);
       	add_action( 'admin_enqueue_scripts', array($this, 'box_enqueue_scripts' ) );
        add_action( 'admin_footer', array($this,'box_admin_footer_html'), 9 );
        add_action('admin_bar_menu', array($this,'add_toolbar_items'), 100);

    }
    static function get_instance(){
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    public function bx_register_my_custom_menu_page() {
        add_menu_page( __( 'Theme Options', 'boxtheme' ),'Box settings','manage_options', self::$main_setting_slug, array('BX_Admin','box_custom_menu_page'),get_template_directory_uri().'/ico.png',6);
	}

    public function box_enqueue_scripts($hook) {
        // Load only on ?page=theme-options
    	$credit_page = 'box-settings_page_credit-setting';
        $box_setting = isset($_GET['box-settings'])? $_GET['box-settings']:'';
    	$default = 'toplevel_page_box-settings';
        $hook_wdt = 'box-settings_page_widthraw-order';
        $hook_order = 'box-settings_page_credit-setting';

        if( in_array( $hook, array( $default, $hook_wdt,$hook_order ) ) ){
	        wp_enqueue_style( 'bootraps', get_template_directory_uri(). '/library/bootstrap/css/bootstrap.css'  );
	        wp_enqueue_style( 'box_wp_admin_css', get_template_directory_uri().'/admin/css/box_style.css' );
	        wp_enqueue_style( 'bootraps-toggle', get_template_directory_uri() .'/admin/css/bootstrap-toggle.min.css' );
	        wp_enqueue_script('toggle-button',get_template_directory_uri().'/admin/js/bootstrap-toggle.min.js' );
	        wp_enqueue_script( 'box-js', get_template_directory_uri().'/admin/js/admin.js', array('jquery','wp-util') );

	        if( in_array( $hook, array( $hook_wdt, $hook_order ) ) ){
	        	wp_enqueue_script('credit-js',get_template_directory_uri().'/admin/js/credit.js', array('jquery','box-js') );
	        }
	    }

    }
    function install(){ ?>
        <div class="full" style="padding:25px 0;">

            <?php
            $install = (int) get_option('install_sample', 3);
            if( $install != 1){   ?>
            <div class="full"><h3><?php _e('Click into this button to setup sample data.','boxtheme');?></h3></div>
                <button class="btn-big btn-install">Install Sample data</button>
            <?php } else { ?>
               <h3><?php _e('Sample data is imported.','boxtheme');?></h3>
                <button class="btn-big btn-install">Re Import</button>
                <?php
            }?>

        </div>
        <?php
    }
    function plugins(){
        get_template_part( 'admin/templates/plugins');
    }
    function general(){
    	get_template_part( 'admin/templates/general');
    }

    function escrow(){
    	get_template_part( 'admin/templates/escrow');

    }
    function currency_package(){
    	get_template_part( 'admin/templates/currency_package');
    }
    function payment_gateways(){
    	get_template_part( 'admin/templates/payment_gateways');
    }
    static function box_admin_footer_html(){
    	$page = isset($_GET['page']) ? $_GET['page'] : '';
    	if( in_array($page, array('credit-setting','box-settings','widthraw-order')) ) {	?>
	    	<script type="text/javascript">
	            var bx_global = {
	                'home_url' : '<?php echo home_url() ?>',
	                'admin_url': '<?php echo admin_url() ?>',
	                'ajax_url' : '<?php echo admin_url().'admin-ajax.php'; ?>',
	                'selected_local' : '',
	                'is_free_submit_job' : true,

	            }
	        </script>
    	<?php }
    }
    function email(){
    	global $main_page;
    	$main_page 		= admin_url('admin.php?page='.self::$main_setting_slug);
    	get_template_part( 'admin/templates/email');
	}
    static function box_custom_menu_page(){

        $current_section = isset($_GET['section']) ? $_GET['section'] : 'general';
        $admin = BX_Admin::get_instance();
        $sections = array('escrow','install','currency_package','payment_gateways','email','plugins');
        $main_setting_link =  admin_url('admin.php?page='.self::$main_setting_slug);
        ?>
        <div class="wrap">
            <div class="setting-logo">
                <a href="<?php echo $main_setting_link;?>"><img src="<?php echo get_template_directory_uri(); ?>/img/boxtheme.png" width="55" height="" alt="" align="left" /></a>
                <h1 class="theme-option"> <?php _e('Theme Options','boxtheme');?></h1>
            </div>
            <div class="wrap-content">

                <?php get_template_part( 'admin/templates/header_menu'); ?>

                <div class="tab-content clear">
                    <div id="main_content" ">

                        <?php
                            if( ! in_array($current_section, $sections) ){
                                $current_section = 'general';
                            }
                            $admin->$current_section();
                        ?>

                    </div>
                </div>
            </div>
        </div> <?php
    }
    function add_toolbar_items($admin_bar){
        $admin_bar->add_menu( array(
            'id'    => 'box-settings',
            'title' => '<img src="'.get_template_directory_uri().'/ico.png" /> BoxThemes Settings',
            'href'  => admin_url('admin.php?page=box-settings'),
            'meta'  => array(
                'title' => __('BoxThemes Settings'),
            ),
        ));
        $admin_bar->add_menu(
            array(
                'id'    => 'main-setting',
                'parent' => 'box-settings',
                'title' => 'Box Settings',
                'href'  => admin_url('admin.php?page=box-settings'),
                'meta'  => array(
                    'title' => __('Box Settings','boxtheme'),

                    'class' => 'my_menu_item_class'
                ),
            )
        );

        $admin_bar->add_menu(
            array(
                'id'    => 'my-sub-item',
                'parent' => 'box-settings',
                'title' => 'Credit Order',
                'href'  => admin_url('admin.php?page=credit-setting'),
                'meta'  => array(
                    'title' => __('Credit Order'),
                    //'target' => '_blank',
                    'class' => 'my_menu_item_class'
                ),
            )
        );
        $admin_bar->add_menu( array(
            'id'    => 'my-second-sub-item',
            'parent' => 'box-settings',
            'title' => 'Withdrawal Order',
           	'href'  => admin_url('admin.php?page=widthraw-order'),
            'meta'  => array(
                'title' => __('Withdrawal Order'),
               // 'target' => '_blank',
                'class' => 'my_menu_item_class'
            ),
        ));
        do_action( 'box_quick_admin_bar', $admin_bar );
    }
}

?>