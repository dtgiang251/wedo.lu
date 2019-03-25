<?php



class VC_WDO_Pricing_Tables {


    /**
     * Get things started
     */
    function __construct() {

        add_action('init', array($this, 'wdo_pricing_table_parent'));
        add_action('init', array($this, 'wdo_pricing_table_child'));
        add_action( 'wp_enqueue_scripts', array($this, 'loading_hover_scripts') );
        add_shortcode('wdo_pricing_tables', array($this, 'wdo_tables_rendering'));
        add_shortcode('wdo_pricing_table', array($this, 'wdo_table_rendering'));
    }

    function wdo_pricing_table_parent() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Pricing Tables - Free", "wdo-pricing-tables"),
                "base" => "wdo_pricing_tables",
                "as_parent" => array('only' => 'wdo_pricing_table'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => 'Content',
                "is_container" => true,
                'description' => __('Insert Pricing Tables', 'wdo-pricing-tables'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-wpb-pricing_column',
                "params" => array(

                    
                    
                ),
            ));


        }
    }

    function wdo_pricing_table_child() {
        if (function_exists("vc_map")) {
        	$animationEffects = array(
						'Fade'			=>	'tc-animation-fade',
						'Slide Top'		=>	'tc-animation-slide-top',
						'Slide Bottom'	=>	'tc-animation-slide-bottom',
						'Slide Left'	=>	'tc-animation-slide-left',
						'Slide Right'	=>	'tc-animation-slide-right',
						'Scale Up'		=>	'tc-animation-scale-up',
						'Scale Down'	=>	'tc-animation-scale-down',
						'Shake'			=>	'tc-animation-shake',
						'Rotate'		=>	'tc-animation-rotate',
						'Scale'			=>	'tc-animation-scale',
						'Scale'			=>	'tc-animation-scale',
			);

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Pricing Table", "wdo-pricing-tables"),
                "base" => "wdo_pricing_table",
                "content_element" => true,
                "as_child" => array('only' => 'wdo_pricing_tables'), // Use only|except attributes to limit parent (separate multiple values with comma)
                "icon" => 'icon-wpb-pricing_column',
                "params" => array(
			                	array(
						            "type" => "dropdown",
						            "holder" => "div",
						            "class" => "",
						            "heading" => "Columns",
						            "param_name" => "wdo_columns",
						            "value" => array(
						                "Two"       => "vc_col-sm-6",
						                "Three"     => "vc_col-sm-4",
						                "Four"      => "vc_col-sm-3",
						            ),
									'save_always' => true,
						            "description" => ""
						        ),
								array(
									"type" => "textfield",
									"holder" => "div",
									"class" => "",
									"heading" => "Title",
									"param_name" => "table_title",
									"value" => "Basic Plan",
									"description" => ""
								),
								array(
									"type" => "textfield",
									"holder" => "div",
									"class" => "",
									"heading" => "Price",
									"param_name" => "table_price",
									"description" => ""
								),
								array(
									"type" => "textfield",
									"holder" => "div",
									"class" => "",
									"heading" => "Currency",
									"param_name" => "table_currency",
									"description" => ""
								),
								array(
									"type" => "textfield",
									"holder" => "div",
									"class" => "",
									"heading" => "Price Period",
									"param_name" => "table_price_period",
									"description" => ""
								),
								array(
									"type" => "dropdown",
									"holder" => "div",
									"class" => "",
									"heading" => "Show Button",
									"param_name" => "table_show_button",
									"value" => array(
										"Yes" => "yes",
										"No" => "no"
									),
									'save_always' => true
								),
					            array(
					                "type" => "textfield",
					                "holder" => "div",
					                "class" => "",
					                "heading" => "Button Text",
					                "param_name" => "table_button_text",
					                "description" => "Default label is Purchase",
					                "dependency" => array('element' => 'table_show_button', 'value' => 'yes')
					            ),
								array(
									"type" => "textfield",
									"holder" => "div",
									"class" => "",
									"heading" => "Button Link",
									"param_name" => "table_link",
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes')
								),
								array(
									"type" => "dropdown",
									"holder" => "div",
									"class" => "",
									"heading" => "Button Target",
									"param_name" => "table_target",
									"value" => array(
										"" => "",
										"Self" => "_self",
										"Blank" => "_blank",	
										"Parent" => "_parent"
									),
									"dependency" => array('element' => 'table_show_button', 'value' => 'yes')
								),
								array(
									"type" => "dropdown",
									"holder" => "div",
									"class" => "",
									"heading" => "Featured",
									"param_name" => "active",
									"value" => array(
										"No" => "no",
										"Yes" => "yes"	
									),
									'save_always' => true,
									"description" => ""
								),
					            array(
					                "type" => "textfield",
					                "holder" => "div",
					                "class" => "",
					                "heading" => "Featured Text",
					                "param_name" => "active_text",
					                "description" => "This will be shown at the top right corner of table",
					                "dependency" => array('element' => 'active', 'value' => 'yes')
					            ),
								array(
									"type" => "textarea_html",
									"holder" => "div",
									"class" => "",
									"heading" => "Content",
									"param_name" => "content",
									"value" => '<li class="whyt">Your Content Here</li>
												<li>Your Content Here</li>
												<li class="whyt">Your Content Here</li>
												<li>Your Content Here</li>
												<li class="whyt">Your Content Here</li>',
									"description" => ""
								),

								/*Animation and style tab*/
								array(
						            "type" => "dropdown",
						            "holder" => "div",
						            "class" => "",
						            "heading" => "Style",
						            "group" => "Pro Features",
						            "param_name" => "wdo_tables_style_pro",
						            "value" => array(
						                "Style 1"       => "pricing-style1",
						                "Style 2"       => "pricing-style2",
						                "Style 3"       => "pricing-style3",
						                "Style 4"       => "pricing-style4",
						                "Style 5"       => "pricing-style5",
						                "Style 6"       => "pricing-style6",
						                "Style 7"       => "pricing-style7",
						                "Style 8"       => "pricing-style8",
						                "Style 9"       => "pricing-style9",
						                "Style 10"      => "pricing-style10",
						                "Style 11"      => "pricing-style11",
						                "Style 12"      => "pricing-style12",
						                "Style 13"      => "pricing-style13",
						                "Style 14"      => "pricing-style14",
						                "Style 15"      => "pricing-style15",
						                "Style 16"      => "pricing-style16",
						            ),
									'save_always' => true,
						            "description" => ""
						        ),
								
								array(
									"type" => "dropdown",
									"holder" => "div",
									"class" => "",
									"heading" => "Animations",
									"group" => "Pro Features",
									"param_name" => "pricing_animation_pro",
									"value" => $animationEffects,
									"description" => "Select animation when hovered over pricing."
								),

								array(
									"type" => "dropdown",
									"holder" => "div",
									"class" => "",
									"heading" => "Color Scheme",
									"group" => "Pro Features",
									"param_name" => "pricing_color_scheme",
									"value" => array(
										"Blue" => "blue.css",
										"Green" => "green.css",	
										"Orange" => "orange.css",
										"Red" 	=> "red.css",
										"Violet" 	=> "violet.css",
									),
									"description" => ""
								),
								array(
									"type" => "html",
									"heading" => "	<h3 style='padding: 10px;background: #2b4b80;color: #fff;'>50% Discount. For First 100 Sales</h3>
													<a target='_blank' href='https://codecanyon.net/item/pricing-tables-vc-addon/19505119?ref=wpscripts' >Get Pro Version From CodeCanyon in $10</a>
													<h3 style='padding: 10px;background: #2b4b80;color: #fff;'>60% Discount on our site</h3>
													<a target='_blank' href='https://webdevocean.com/product/pricing-table-vc-addon/' >Get Pro Version From Site in $8</a>",
									"param_name" => "pro_feature",
									"group" => "Pro Features"
								),

								
					)
            ));


        }
    }

    function loading_hover_scripts(){
		wp_enqueue_style( 'pricing-table-css', plugins_url( 'css/pure-pricing.css' , __FILE__ ));
	}

    function wdo_tables_rendering($atts, $content = null, $tag) {


        extract(shortcode_atts(array(
            
        ), $atts));
        ob_start();

        ?>
     
        <div class="pricing-plans">
            <div class="wrap">
                <div class="pricing-grids">
                	<?php do_shortcode( $content ); ?>
                </div>
            </div>
        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }


    function wdo_table_rendering($atts, $content = null, $tag) {


	    extract(shortcode_atts(array(
	        'table_title' => 'Basic Plan',
	        'wdo_columns' => 'vc_col-sm-4',
	        'table_price' => '0',
	        'table_currency' => '$',
	        'table_price_period' => 'month',
	        'table_show_button' => 'yes',
	        'table_button_text' => 'Purchase',
	        'table_link' => '',
	        'table_target' => '_self',
	        'active' => 'yes',
	        'active_text' => '',

	    ), $atts));

	    ?>
			<div class="pricing-grid <?php echo $wdo_columns; ?>"> 
				<div class="price-value">
					<h2><a href="#"> <?php echo $table_title; ?></a></h2>
					<h5><span><?php echo $table_currency; ?> <?php echo $table_price; ?></span><lable> / <?php echo $table_price_period; ?></lable></h5>
					<?php 
						if ($active=='yes') { ?>
							<div class="sale-box">
								<span class="on_sale title_shop"><?php echo $active_text; ?></span>
							</div>
					<?php	}
					?>
					

				</div>
				<div class="price-bg">
				<?php echo $content; ?>
					<!-- <ul>
						<li class="whyt"><a href="#">5GB Disk Space </a></li>
						<li><a href="#">10 Domain Names</a></li>
						<li class="whyt"><a href="#">5 E-Mail Address </a></li>
						<li><a href="#">50GB Monthly Bandwidth </a></li>
						<li class="whyt"><a href="#">Fully Support</a></li>
					</ul> -->
					<?php 
						if ($table_show_button=='yes') { ?>
							<div class="cart1">
								<a class="popup-with-zoom-anim" target="<?php echo $table_target; ?>" href="<?php echo $table_link; ?>"><?php echo $table_button_text; ?></a>
							</div>
					<?php	}
					?>
					
				</div>
			</div>



<?php
	} 

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_wdo_pricing_tables extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_wdo_pricing_table extends WPBakeryShortCode {
    }
}