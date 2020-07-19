<?php
class WP_Responsive_Menu_PRO {

	protected $options = '';

	public $translatables = array(
  	'search_box_text',
    'bar_title'
  );

	public function __construct() {
		add_action( 'admin_notices', array( $this, 'check_wpr_exists' ) );

		add_action( 'wp_enqueue_scripts',  array( $this, 'wprm_enque_scripts' ) );
		
		add_action( 'wp_footer', array( $this, 'wprmenu_menu' ) );
		
		$this->options = get_option( 'wprmenu_options' );
		
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'wpr_cart_count_fragments' ), 10, 1 );

		add_action( 'plugins_loaded', array($this, 'wprmenu_init') );

		add_action( 'wpr_optionsframework_after_validate', array( $this, 'save_options_notice' ) );

		add_action( 'wp_ajax_wpr_live_update', array($this, 'wpr_live_update'));

		add_action( 'wp_footer', array($this, 'wpr_custom_css') );

		add_action( 'wp_ajax_wprmenu_import_data', array($this, 'wprmenu_import_data') );

		add_action( 'wp_ajax_wpr_get_transient_from_data', array($this, 'wpr_get_transient_from_data') );

	}


	public function option( $option ) {
		if( isset($_GET['wprmenu']) && $_GET['wprmenu'] !== '' ) {
			$data = get_option($_GET['wprmenu']);
			$data = (array)json_decode($data);
			return $data[$option];
		} 
		else {
			if( isset($_COOKIE['wprmenu_live_preview']) 
			&& $_COOKIE['wprmenu_live_preview'] == 'yes' ) {
				$check_transient = get_transient('wpr_live_settings');

				if( $check_transient ) {
					if( isset( $check_transient[$option] ) 
						&& $check_transient[$option] != '' ) {
						return $check_transient[$option];
					}
				}
			}
			else {
				if( isset( $this->options[$option] ) && $this->options[$option] != '' )
					return $this->options[$option];
					return '';
			}
	 	} 
	}

	public function save_options_notice() {
		if( $this->option('wpr_enable_external_css') == 'yes' ) {

			//create folder for plugin in uploads directory
			$base_dir = wp_upload_dir()['basedir'] . '/wp-responsive-menu-pro';

			if( !wp_mkdir_p($base_dir . '/css') ) {
				add_settings_error( 'options-framework', 'save_options', __( 'You don\'t have permissions to create CSS data folder - please check permissions.', 'wprmenu' ), 'error fade in' );
			}

			$css_file = $base_dir . '/css/wp-responsive-menu-pro-' . get_current_blog_id() . '.css';

			$css_data = $this->wpr_inline_css();

			if( $this->option('wpr_enable_minify') == 'yes' ) {
      	$css_data = $this->minify_external_css($css_data);
			}

			if( !file_put_contents($css_file, $css_data) ) {
      	add_settings_error( 'options-framework', 'save_options', __( 'You don\'t have permissions to write external CSS file - please check permissions.', 'wprmenu' ), 'error fade in' );
			}
		}
	}
  

	public function wprmenu_register_strings() {
		if( is_admin() ) :
			if( function_exists('pll_register_string')) :
				pll_register_string('search_box_text', $this->option('search_box_text'), 'WP Responsive Menu');
      	pll_register_string('bar_title', $this->option('bar_title'), 'WP Responsive Menu');
			endif;
		endif;
	}

	public function wprmenu_init() {
		$this->wprmenu_register_strings();
		$this->wprmenu_run_translate();
		$this->wprmenu_create_widget();
	}

	public function wprmenu_run_translate() {
		foreach($this->translatables as $option_name) {
			if( null !== $this->option($option_name) ) {
				do_action('wpml_register_single_string', 'WP Responsive Menu', $option_name, $this->option($option_name));
			}       
		}
	}

	//minify external css file
	function minify_external_css($data) {
		/* remove comments */
    $minified = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);

    /* remove tabs, spaces, newlines, etc. */
    $minified = str_replace(array("\r\n","\r","\n","\t",'  ','    ','     '), '', $minified);
		
		/* remove other spaces before/after ; */
    $minified = preg_replace(array('(( )+{)','({( )+)'), '{', $minified);
    $minified = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $minified);
    $minified = preg_replace(array('(;( )+)','(( )+;)'), ';', $minified);

    return $minified;
  }

	//convert hex color codes into RGB color
	function hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
 		
 		//Return default if no color provided
		if ( empty($color) )
    	return $default; 
 
		//Sanitize $color if "#" is provided 
    if ( $color[0] == '#' ) {
    	$color = substr( $color, 1 );
    }
 
    //Check if color has 6 or 3 characters and get values
    if ( strlen($color) == 6 ) {
    	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
    	$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
    	return $default;
    }
 
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if( $opacity ) {
    	if( abs($opacity) > 1 )
    		$opacity = 1.0;
    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
    	$output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
	}

	/**
	*
	* Check if responsive menu free version is installed and activated and if not
	* If free version is installed and activated then show notice to make that disable
	*
	*/
	public function check_wpr_exists() {
		if( is_plugin_active('wp-responsive-menu/wp-responsive-menu.php') ) { 
			$notice = __('<p>It seems like you are using the free version of <a href="https://wordpress.org/plugins/wp-responsive-menu/" target="_blank">WP Responsive Menu</a>. Make sure to deactivate and remove the free version of the plugin to use the pro version. All your settings of free version will be automatically transferred to pro version.</p>');
			?>
			<div id="message" class="error">
      	<?php echo $notice; ?>
      </div>
		<?php
		deactivate_plugins( 'wp-responsive-menu-pro/wp-responsive-menu-pro.php' );
		}
	}

	/**
	*
	* Generate inline style for responsive menu
	*
	* @since 1.0.2
	* @param blank
	* @return inline css
	*/
	public function wpr_inline_css() {
		$inlinecss = '';
		
		if( $this->option('enabled') ) :

			$how_wide = $this->option('how_wide') !='' ? $this->option('how_wide') : '40';
			$menu_max_width = $this->option('menu_max_width') != '' ? $this->option('menu_max_width') : '';
			$from_width = $this->option('from_width') != '' ? $this->option('from_width') : '768';
			$inlinecss .= '@media only screen and ( max-width: '.$from_width.'px ) {';
			$border_top_color = $this->hex2rgba($this->option("menu_border_top"), $this->option("menu_border_top_opacity"));

			$border_bottom_color = $this->hex2rgba($this->option("menu_border_bottom"), $this->option("menu_border_bottom_opacity"));

			//menu background image
			if( $this->option('menu_bg') != '' ) :
				$inlinecss .= 'html body .wprm-wrapper #mg-wprm-wrap {
					background-image: url( '.$this->option("menu_bg").' ) !important;
					background-size: '.$this->option("menu_bg_size").' !important;
					background-repeat: '.$this->option("menu_bg_rep").' !important;
				}';
			endif;


			if( $this->option('enable_overlay') == '1' ) :
				$overlay_bg_color = $this->hex2rgba($this->option("menu_bg_overlay_color"), $this->option("menu_background_overlay_opacity"));
				$inlinecss .= 'html body div.wprm-overlay{ background: '.$overlay_bg_color .' }';
			endif;

			if( $this->option('menu_icon_type') == 'default' ) :
				$menu_padding = $this->option("header_menu_height");
				$menu_padding = intval($menu_padding);

				if( $menu_padding > 50 ) {
					$menu_padding = $menu_padding - 27;
					$menu_padding = $menu_padding / 2;
					$top_position = $menu_padding + 30;

					$inlinecss .= 'html body div#wprmenu_bar {
						padding-top: '.$menu_padding.'px;
						padding-bottom: '.$menu_padding.'px;
					}';

					if( $this->option('menu_type') == 'default' ) {
						$inlinecss .= '.wprmenu_bar div.wpr_search form {
							top: '.$top_position.'px;
						}';
					}
				}
				
				$inlinecss .= 'html body div#wprmenu_bar {
					height : '.$this->option("header_menu_height").'px;
				}';
			endif;

			if( $this->option('menu_type') == 'default'  ) :
				$inlinecss .= '#mg-wprm-wrap.cbp-spmenu-left, #mg-wprm-wrap.cbp-spmenu-right, #mg-widgetmenu-wrap.cbp-spmenu-widget-left, #mg-widgetmenu-wrap.cbp-spmenu-widget-right {
					top: '.$this->option("header_menu_height").'px !important;
				}';
			endif;
			
			if( $this->option('fullwidth_menu_container') == '1'  ) :
				$inlinecss .= 'html body #mg-wprm-wrap.cbp-spmenu-left, html body #mg-wprm-wrap.cbp-spmenu-right, html body #mg-widgetmenu-wrap.cbp-spmenu-widget-left, html body #mg-widgetmenu-wrap.cbp-spmenu-widget-right {
					top: 0px !important;
					z-index: 9999999 !important;
				}';

				$inlinecss .= 'html body.admin-bar #mg-wprm-wrap.cbp-spmenu-left, html body.admin-bar #mg-wprm-wrap.cbp-spmenu-right, html body.admin-bar #mg-widgetmenu-wrap.cbp-spmenu-widget-left, html body.admin-bar #mg-widgetmenu-wrap.cbp-spmenu-widget-right {
					top: 46px !important;
					z-index: 9999999 !important;
				}';

			endif;


			if( $this->option('menu_border_bottom_show') == 'yes' ) :
				$inlinecss .= '
				#mg-wprm-wrap ul li {
					border-top: solid 1px '.$border_top_color.';
					border-bottom: solid 1px '.$border_bottom_color.';
				}';
			endif;

			if( $this->option('submenu_alignment') == 'right' ):
				$inlinecss .= '
				#mg-wprm-wrap li.menu-item-has-children ul.sub-menu li a {
					text-align: right;
					margin-right: 44px;
				}';
			endif;

			if( $this->option('submenu_alignment') == 'center' ):
				$inlinecss .= '
				#mg-wprm-wrap li.menu-item-has-children ul.sub-menu li a {
					text-align: center;
				}';
			endif;

			if( $this->option('menu_bar_bg') != '' ) :
				$inlinecss .= '
					#wprmenu_bar {
					background-image: url( '.$this->option("menu_bar_bg").' ) !important;
					background-size: '.$this->option("menu_bar_bg_size").' !important;
					background-repeat: '.$this->option("menu_bar_bg_rep").' !important;
				}';
			endif;
			
			$inlinecss .= '
				#wprmenu_bar { background-color: '.$this->option('bar_bgd').'; }
				html body div#mg-wprm-wrap .wpr_submit .icon.icon-search {
					color: '.$this->option("search_icon_color").';
				}
				#wprmenu_bar .menu_title, #wprmenu_bar .menu_title a, #wprmenu_bar .wprmenu_icon_menu, #wprmenu_bar .wprmenu_icon_menu a {
					color: '.$this->option("bar_color").';
				}
				#wprmenu_bar .menu_title, #wprmenu_bar .menu_title a {
					font-size: '.$this->option('menu_title_size').'px;
					font-weight: '.$this->option('menu_title_weight').';
				}
				#mg-wprm-wrap li.menu-item a {
					font-size: '.$this->option('menu_font_size').'px;
					text-transform: '.$this->option('menu_font_text_type').';
					font-weight: '.$this->option('menu_font_weight').';
				}
				#mg-wprm-wrap li.menu-item-has-children ul.sub-menu a {
					font-size: '.$this->option('sub_menu_font_size').'px;
					text-transform: '.$this->option('sub_menu_font_text_type').';
					font-weight: '.$this->option('sub_menu_font_weight').';
				}
				#mg-wprm-wrap li.current-menu-item > a {
					color: '.$this->option('active_menu_color').';
					background: '.$this->option('active_menu_bg_color').';
				}
				#mg-wprm-wrap, div.wpr_search form {
					background-color: '.$this->option("menu_bgd").';
				}
				#mg-wprm-wrap, #mg-widgetmenu-wrap {
					width: '.$how_wide.'%;
					max-width: '.$menu_max_width.'px;
				}
				#mg-wprm-wrap ul#wprmenu_menu_ul li.menu-item a,
				div#mg-wprm-wrap ul li span.wprmenu_icon, div#mg-wprm-wrap ul li, div#mg-wprm-wrap ul * {
					color: '.$this->option("menu_color").';
				}
				#mg-wprm-wrap ul#wprmenu_menu_ul li.menu-item a:hover {
					background: '.$this->option("menu_textovrbgd").'!important;
					color: '.$this->option("menu_color_hover").';
				}
				div#mg-wprm-wrap ul>li:hover>span.wprmenu_icon {
					color: '.$this->option("menu_color_hover").';
				}

				.fullwidth-menu.hamburger	.hamburger-inner, .fullwidth-menu.hamburger	.hamburger-inner::before, .fullwidth-menu.hamburger	.hamburger-inner::after { background: '.$this->option("menu_icon_color").'; }

				.wprmenu_bar .hamburger-inner, .wprmenu_bar .hamburger-inner::before, .wprmenu_bar .hamburger-inner::after { background: '.$this->option("menu_icon_color").'; }

				.fullwidth-menu.hamburger:hover .hamburger-inner, .fullwidth-menu.hamburger:hover .hamburger-inner::before,
			 .fullwidth-menu.hamburger:hover .hamburger-inner::after {
					background: '.$this->option("menu_icon_hover_color").';
				};

				.wprmenu_bar .hamburger:hover .hamburger-inner, .wprmenu_bar .hamburger:hover .hamburger-inner::before,
			 .wprmenu_bar .hamburger:hover .hamburger-inner::after {
					background: '.$this->option("menu_icon_hover_color").';
				}';

			if( $this->option("menu_symbol_pos") == 'right' ) :
				$inlinecss .= '
					html body .wprmenu_bar .hamburger {
						float: '.$this->option("menu_symbol_pos").'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger, .wprmenu_bar.custMenu .wpr-custom-menu {
						top: '.$this->option("custom_menu_top").'px;
						right: '.$this->option("custom_menu_left").'px;
						float: right !important;
						background-color: '.$this->option("custom_menu_bg_color").' !important;
					}';
			endif;

			if( $this->option("menu_symbol_pos") == 'left' ) :
				$inlinecss .= '
					.wprmenu_bar .hamburger {
						float: '.$this->option("menu_symbol_pos").'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger, .wprmenu_bar.custMenu .wpr-custom-menu {
						top: '.$this->option("custom_menu_top").'px;
						left: '.$this->option("custom_menu_left").'px;
						float: '.$this->option("menu_symbol_pos").'!important;
						background-color: '.$this->option("custom_menu_bg_color").' !important;
					}
				';
			endif;

			if( $this->option('google_font_type') != '' && $this->option('google_font_type') == 'standard' ) :
				$inlinecss .= 'body #mg-wprm-wrap *,#wprmenu_bar .menu_title,#wprmenu_bar input, html body body #mg-wprm-wrap a:not(i) {font-family: '.$this->option('google_font_family').' }';
			endif;

			if( $this->option('google_font_type') != '' && $this->option('google_font_type') == 'web_fonts' ) {
				$font = str_replace('+', ' ', $this->option('google_web_font_family') );
				$inlinecss .= 'body #mg-wprm-wrap *,#wprmenu_bar .menu_title,#wprmenu_bar input, html body body #mg-wprm-wrap a:not(::i) {font-family: '.$font.' }';
			}

			if( $this->option('hide') != '' ):
				$inlinecss .= $this->option('hide').'{ display:none!important; }';
			endif;

			if( $this->option("menu_type") == 'default' ) : 
				$inlinecss .= 'html { padding-top: 42px!important; }';
			endif;

			$inlinecss .= '#wprmenu_bar,.wprmenu_bar.custMenu .wpr-custom-menu { display: block!important; }
			div#wpadminbar { position: fixed; }';
		
		endif;

		$inlinecss .= 'div#mg-wprm-wrap .wpr_social_icons > a { color: '.$this->option('social_icon_color').' !important}';
		$inlinecss .= 'div#mg-wprm-wrap .wpr_social_icons > a:hover { color: '.$this->option('social_icon_hover_color').' !important}';
		$inlinecss .= '#wprmenu_bar .menu-elements.search-icon .toggle-search i { color: '.$this->option('search_icon_color').' !important}';
		$inlinecss .= '#wprmenu_bar .wpr-custom-menu  {float: '.$this->option('menu_symbol_pos').';}';

		$inlinecss .= '.wprmenu_bar .wpr-custom-menu i { font-size: '.$this->option('custom_menu_font_size').'px !important;  top: '.$this->option('custom_menu_icon_top').'px !important; color: '.$this->option('menu_icon_color').'}';

		$inlinecss .= '.wprmenu_bar .wpr-widget-menu i { font-size: '.$this->option('widget_menu_font_size').'px !important;  top: '.$this->option('widget_menu_top_position').'px !important;}';

		$inlinecss .= '.wprmenu_bar .wpr-widget-menu i.wpr_widget_menu_open {color: '.$this->option('widget_menu_icon_color').'!important;}';

		$inlinecss .= '.wprmenu_bar .wpr-widget-menu i.wpr_widget_menu_close {color: '.$this->option('widget_menu_icon_active_color').'!important;}';

		$inlinecss .= 'div.wprm-wrapper #mg-widgetmenu-wrap {background-color: '.$this->option('widget_menu_bg_color').'!important;}';

		$inlinecss .= 'div.wprm-wrapper #mg-widgetmenu-wrap * {color: '.$this->option('widget_menu_text_color').'!important;}';

		$inlinecss .= '#mg-wprm-wrap div.wpr_social_icons i {font-size: '.$this->option('social_icon_font_size').'px !important}';
		
		if( $this->woocommerce_installed() && $this->option('woocommerce_integration') == 'yes' ){
			$inlinecss .= 'div.wpr_cart_icon .wpr-cart-item-contents{ background: '.$this->option('cart_contents_bubble_color').' !important; color: '.$this->option('cart_contents_bubble_text_color').' !important; font-size: '.$this->option('cart_contents_bubble_text_size').'px !important}';
			$inlinecss .= '#wprmenu_bar .menu-elements.cart-icon i { color: '.$this->option('cart_icon_color').' !important}';
			$inlinecss .= '#wprmenu_bar .menu-elements.cart-icon i:hover{color: '.$this->option('cart_icon_active_color').' !important}';
		}

		$inlinecss .= '#wprmenu_bar .menu-elements.search-icon .toggle-search i:hover{color: '.$this->option('search_icon_hover_color').' !important}';
		$inlinecss .= '#mg-wprm-wrap .wpr_submit i::before {color: '.$this->option('search_icon_color').' !important }';

		$inlinecss .=	'}';
		
		return $inlinecss;

	}

	/**
	*
	* Add necessary js and css for our wp responsive menu
	*
	* @since 1.0.2
	* @param blank
	* @return array
	*/
	public function wprm_enque_scripts() {

		$is_restricted_page = $this->check_restricted_page();
			
		if( $is_restricted_page )
			return;

		//hamburger menu icon style
		wp_enqueue_style( 'hamburger.css' , plugins_url().'/wp-responsive-menu-pro/css/wpr-hamburger.css', array(), '1.0' );

		if( $this->option('google_font_type') != '' && $this->option('google_font_type') == 'web_fonts' ) {
			wp_enqueue_style('wprmenu-font', '//fonts.googleapis.com/css?family='.$this->option('google_web_font_family'));
		}
		
		wp_enqueue_style( 'wprmenu.fonts.css' , plugins_url().'/wp-responsive-menu-pro/inc/icons/style.css', array(), '1.0' );

		wp_enqueue_style( 'wprmenu.css' , plugins_url().'/wp-responsive-menu-pro/css/wprmenu.css', array(), '1.0' );

		if( $this->option('rtlview') == 1 ) :
			wp_enqueue_style( 'wprmenu-rtl.css' , plugins_url().'/wp-responsive-menu-pro/css/wprmenu-rtl.css', array(), '1.0' );
		endif;

		//menu css
		wp_enqueue_style( 'wpr-icons', plugins_url().'/wp-responsive-menu-pro/inc/icons/style.css', array(),  '1.0' );

		if( $this->option('wpr_enable_external_css') == 'yes' ) {
			$css_file = wp_upload_dir()['baseurl'] . '/wp-responsive-menu-pro/css/wp-responsive-menu-pro-' . get_current_blog_id() . '.css';
			wp_enqueue_style('wprmenu-external', $css_file, null, true);
		}
		else 
			wp_add_inline_style( 'wprmenu.css', $this->wpr_inline_css() );

		wp_enqueue_script( 'modernizr', plugins_url(). '/wp-responsive-menu-pro/js/modernizr.custom.js', array( 'jquery' ), '1.0' );
		
		//touchswipe js
		wp_enqueue_script( 'touchSwipe', plugins_url(). '/wp-responsive-menu-pro/js/jquery.touchSwipe.min.js', array( 'jquery' ), '1.0' );

		wp_enqueue_script( 'wprmenu.js', plugins_url(). '/wp-responsive-menu-pro/js/wprmenu.js',  array( 'jquery' ), '1.0' );

		$wpr_options = array(
			'zooming' 						=> $this->option('zooming'),
		 	'from_width' 					=> $this->option('from_width'),
		 	'parent_click' 				=> $this->option('parent_click'),
		 	'swipe' 							=> $this->option('swipe'),
		 	'push_width' 					=> $this->option('menu_max_width'),
		 	'menu_width' 					=> $this->option('how_wide'),
		 	'submenu_open_icon' 	=> $this->option('submenu_open_icon'),
		 	'submenu_close_icon' 	=> $this->option('submenu_close_icon'), 
		 	'SubmenuOpened' 			=> $this->option('submenu_opened') != '' ? $this->option('submenu_opened') : '0',
		 	'enable_overlay' 			=> $this->option('enable_overlay'),
		 	'menu_open_direction' => $this->option('position'),
		 	'enable_fullwidth'		=> $this->option('fullwidth_menu_container'),
		 	'widget_menu_open_direction' => $this->option('widget_menu_open_direction'),
		 	);
		wp_localize_script( 'wprmenu.js', 'wprmenu', $wpr_options );
	}

	/**
	*
	* Show woocommerce product counts in the cart
	*
	* @since 3.0.4
	* @param array
	* @return array
	*/
	public function wpr_cart_count_fragments( $fragments ) {
		$fragments['span.wpr-cart-item-contents'] = '<span class="wpr-cart-item-contents">' . WC()->cart->get_cart_contents_count() . '</span>';
	  return $fragments;
	}
	
	public function woocommerce_installed() {
		if (  class_exists( 'woocommerce' ) ) {
			return true;
		}
	}

	/**
	*
	* WordPress deafult search form
	*
	* @since 3.0.4
	* @param blank
	* @return html
	*/
	public function wpr_search_form() {

		$search_placeholder = $this->option('search_box_text');
		
		$translated = apply_filters('wpml_translate_single_string', $this->option('search_box_text'), 'WP Responsive Menu', $this->option('search_box_text'));
		$search_placeholder = function_exists('pll__') ? pll__($translated) : $translated;

		$unique_id = esc_attr( uniqid( 'search-form-' ) );
		$woocommerce_search = '';

		if( $this->woocommerce_installed() && $this->option('woocommerce_integration') == 'yes' && $this->option('woocommerce_product_search') == 'yes' ) {
			$woocommerce_search = '<input type="hidden" name="post_type" value="product" />';
		}

		echo '<form role="search" method="get" class="wpr-search-form" action="' . site_url() . '"><label for="'.$unique_id.'"></label><input type="search" class="wpr-search-field" placeholder="' . $search_placeholder . '" value="" name="s" title="Search for:"><button type="submit" class="wpr_submit"><i class="wpr-icon-search"></i></button>'.$woocommerce_search.'</form>';
	}

	/**
	*
	* Show widget menu on frontend
	*
	* @since 3.1
	* @param blank
	* @return boolean
	*/
	public function wpr_show_widget_menu() {
		if( $this->option('wpr_enable_widget') == 1 ) {
			if( is_active_sidebar('wp-responsive-menu') ) {
				dynamic_sidebar( 'wp-responsive-menu' );
			}
		}
	}


	/**
	*
	* Creates menu bar for responsive menu
	*
	* @since 1.2
	* @param blank
	* @return html
	*/
	public function show_menu_bar_element() {
		$html = '';
		
		if( $this->option('wpr_enable_widget') == 'on' || $this->option('wpr_enable_widget') == '1') :
			$widget_menu_icon = $this->option('widget_menu_icon');
			$widget_menu_active_icon = $this->option('widget_menu_close_icon');

			$html .= '<div class="wpr-widget-menu">';
			$html .= '<i class="wpr_widget_menu_open '.$widget_menu_icon.' "></i>';
			$html .= '<i class="wpr_widget_menu_close '.$widget_menu_active_icon.' "></i>';
			$html .= '</div>';
		endif;

		if( $this->option('search_box_menubar') == '1' || $this->option('search_box_menubar') == 'on' ) : 
			$html .= '<div class="wpr-search-wrap menu-bar-elements menu-elements search-icon"><div class="toggle-search"><i class="'.$this->option('search_icon').'"></i></div></div>';
		endif;
		
		if( $this->option('cart-icon') != '' ) : 
			//show woocommerce cart icon if woocommerce and cart is enabled
			if( $this->option('woocommerce_integration') == 'yes' && $this->woocommerce_installed() ) :
				global $woocommerce;
				$cart_url = wc_get_cart_url(); 
				$html .='<div class="wpr-cart-wrap menu-bar-elements menu-elements cart-icon"><div class="wpr_cart_icon"><a class="wpr_cart_item" href="'.$cart_url.'"><i class='.$this->option('cart-icon').'></i>';
				
				if( WC()->cart->get_cart_contents_count() > 0 ) :
					$html .= '<span class="wpr-cart-item-contents">'.WC()->cart->get_cart_contents_count().'</span>';
				else :
					$html .= '<span class="wpr-cart-item-contents">0</span>';
				endif;
					$html .= '</a></div></div>';
			endif; 
		endif;
		echo $html;
	}
	
	/**
	*
	* Get demo settings from the file
	*
	* @since 1.2
	* @param blank
	* @return html
	*/
	public function wpr_social_icons() {

		$socials = json_decode( $this->option('social') );
		
		if( $this->option('social') !='' && !empty($socials) ){
			$output = '';
			if( is_array ( $socials ) && count( $socials ) > 0 ) {
				foreach( $socials as $social ) {
					$output .= '<a href="'.$social->link.'" target="_blank"><i class="'.$social->icon.'"></i></a>';
				}
			}
		}
		return $output;
	}

	// function for hide menu on selected pages
	public function check_restricted_page() {
		$id = '';

		if( get_the_ID() ) {
			$id = get_the_ID();
		}
		
		$menu_hide_pages = $this->option('hide_menu_pages');

		if( is_array($menu_hide_pages) && !empty($menu_hide_pages) ) {
			foreach( $menu_hide_pages as $key => $val ) {
				if( $key == $id )
					return true;
			}
		}
	}

	/**
	*
	* Outputs Responsive Menu Html
	*
	* @since 1.0
	* @param blank
	* @return html
	*/
	public function wprmenu_menu() {

		if( $this->option('enabled') ) :

			$is_restricted_page = $this->check_restricted_page();
			
			if( $is_restricted_page )
				return;

			$menu_title = $this->option('bar_title');
			$translated = apply_filters('wpml_translate_single_string', $this->option('bar_title'), 'WP Responsive Menu', $this->option('bar_title'));
			$menu_title = function_exists('pll__') ? pll__($translated) : $translated;
			
			$logo_link = $this->option('logo_link') != '' ? $this->option('logo_link') : get_site_url();
			$openDirection = $this->option('position');
			$widget_menu_open_direction = $this->option('widget_menu_open_direction');

			$menu_icon_animation = $this->option('menu_icon_animation') != '' ? $this->option('menu_icon_animation') : 'hamburger--slider';
			
			if( $this->option('menu_type') == 'custom' ) : ?>
				<div class="wprmenu_bar custMenu <?php if ( $this->option('slide_type') == 'bodyslide' ) { echo $this->option('slide_type'); echo ' '.$this->option('position'); } ?>">
					<?php
					$menu_icon_type = $this->option('menu_icon_type') != '' ? $this->option('menu_icon_type') : 'custom';

					if( $menu_icon_type !== 'custom' ) : //show default menu
				?>
					<div id="custom_menu_icon" class="hamburger <?php echo $menu_icon_animation; ?>">
  					<span class="hamburger-box">
    					<span class="hamburger-inner"></span>
  					</span>
					</div>
				<?php
					endif;
				 ?>

				 <?php if( $menu_icon_type == 'custom' ) : ?>
				 	<div class="wpr-custom-menu">
				 		<i class="wpr_open <?php echo $this->option('menu_icon'); ?>"></i>
						<i class="wpr_close <?php echo $this->option('menu_close_icon'); ?>"></i>
					</div>
				 <?php endif; ?>

				</div>
		<?php 
			else:
				$logo_class = ' wpr-logo-' . $this->option( 'bar_logo_pos' ); 
		?>
		
	
		<!-- Menu Elements Here -->
		<div class="wprm-wrapper">
			
			<?php 
			if( $this->option('enable_overlay') == '1' ) : ?>
				<div class="wprm-overlay"></div>
			<?php endif; ?>

			<div id="wprmenu_bar" class="wprmenu_bar <?php echo $this->option('slide_type'); echo ' '.$this->option('position'); echo ' widget-menu-'.$this->option('widget_menu_open_direction'); echo $logo_class;  ?>">

				<?php
					/**
					*
					* Before Menu Filter Hook
					*
					* @since 3.1
					*/
					echo apply_filters('before_wp_responsive_menu_header', $before_menu_header); 
				?>

				<!-- menu search box -->
				<div class="search-expand">
					<div class="wpr_search">
						<?php 
						echo $this->wpr_search_form(); 
						?>
					</div>
				</div>

				<?php
					$this->show_menu_bar_element();
					$menu_icon_type = $this->option('menu_icon_type') != '' ? $this->option('menu_icon_type') : 'custom';

					if( $menu_icon_type !== 'custom' ) : //show default menu
				 		?>

					<div class="hamburger <?php echo $menu_icon_animation; ?>">
  					<span class="hamburger-box">
    					<span class="hamburger-inner"></span>
  					</span>
					</div>
				<?php
					endif;
				  
				  if( $menu_icon_type == 'custom' ) : 
				  	?>
				 		<div class="wpr-custom-menu">
				 			<i class="wpr_open <?php echo $this->option('menu_icon'); ?>"></i>
							<i class="wpr_close <?php echo $this->option('menu_close_icon'); ?>"></i>
						</div>
				 <?php endif; ?>
				

					<div class="menu_title">
						<?php if( $this->option('bar_logo') == '' && $this->option('logo_link') !== '' ) : ?>
							<a href="<?php echo $this->option('logo_link'); ?>"><?php echo $menu_title; ?></a>
						<?php else: ?>
							<?php echo $menu_title; ?>
						<?php endif; ?>
					</div>
						
				<?php 
					if( $this->option('bar_logo') != '' ) :
						echo '<span class="wpr-logo-wrap menu-elements"><a href="'.$logo_link.'"><img alt="logo"  src="'.$this->option('bar_logo').'"/></a></span>';
					endif; 
				?>

				<?php
				/**
				*
				* After Menu Filter Hook
				*
				* @since 3.1
				*/
				echo apply_filters('after_wp_responsive_menu_header', $after_menu_header); 
				?>
		</div>
		<?php endif; ?>

	
	<!-- Widget Menu Elements Starts Here -->
		<?php
			if( ( $this->option('wpr_enable_widget') == '1' || $this->option('wpr_enable_widget') == 'on' )
				&& is_active_sidebar('wp-responsive-menu') ) :
		?>
			<div class="widget-menu-elements-wrapper cbp-spmenu-widget  cbp-spmenu-widget-vertical cbp-spmenu-widget-<?php echo $widget_menu_open_direction; ?>" id="mg-widgetmenu-wrap">
				<?php dynamic_sidebar( 'wp-responsive-menu' ); ?>
			</div>
		<?php
			endif;
		?>
		<!-- Widget Menu Elements Ends Here -->

		<!-- Menu Elements Starts Here -->
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-<?php echo $openDirection; ?> <?php echo $this->option('menu_type'); ?> " id="mg-wprm-wrap">

			<?php if( $this->option('fullwidth_menu_container') == '1' ) : ?>
				<div class="wprmenu-fixed-close-button">
					<div class="fullwidth-menu hamburger <?php echo $menu_icon_animation; ?>">
						<span class="hamburger-box">
    					<span class="hamburger-inner"></span>
  					</span>
					</div>
				</div>
			<?php endif; ?>

		<?php 
			$search_position = $this->option('order_menu_items') != '' ? $this->option('order_menu_items') : 'Menu,Search,Social';
		?>

			<ul id="wprmenu_menu_ul">
				<?php
					/**
					* Before Menu Filter Hook
					* @since 3.1
					*/
				echo apply_filters('before_wp_responsive_menu_element', $before_menu_elements);

				//Content Before Menu
				if( $this->option('content_before_menu_element') !== '' ) {
					$content_before_menu_elements = preg_replace('/\\\\/', '', $this->option('content_before_menu_element'));

					echo '<li class="wprm_before_menu_content">'. $content_before_menu_elements . '</li>';
				}

				foreach( explode(',', $search_position) as $element_position ) :
					//Show search element
					if( $element_position == 'Search'  ) :
						if( $this->option('search_box_menu_block') != '' && $this->option('search_box_menu_block') == 1  ) : 
				?>
						<li class="search-menu">
							<div class="wpr_search">
								<?php echo $this->wpr_search_form(); ?>
							</div>
						</li>
						<?php
						endif;
					endif;

					//Show social block
					if( $element_position == 'Social' ) :
						$socials = json_decode( $this->option('social') );
						if( !empty($socials) ) : ?> 
						<li>
							<div class="wpr_social_icons">
								<?php echo $this->wpr_social_icons(); ?>
							</div>
						</li>
						<?php
						endif;
					endif; // End of social block

					//Show menu elements
					if( $element_position == 'Menu' ) :
						$menu = '';
						$menus = get_terms( 'nav_menu', array( 'hide_empty'=>false ) );

						if( !function_exists('icl_get_languages') ) {
							if( $menus ) :
								foreach( $menus as $m ) :
									if( $m->term_id == $this->option('menu') ) $menu = $m;
								endforeach; 
							endif;
						}
							
						if( function_exists('icl_get_languages') ) {
							$language_menu_id = $this->option(ICL_LANGUAGE_CODE.'_menu');

							if( $menus ) :
								foreach( $menus as $m ) :
									if( $m->term_id == $language_menu_id ) $menu = $m;
								endforeach;
							endif;
						}

						if( is_object( $menu ) ) :
							wp_nav_menu( array( 'menu'=>$menu->name,'container'=>false,'items_wrap'=>'%3$s' ) );
						endif;
					endif;

				endforeach;

				//Content After Menu
				if( $this->option('content_after_menu_element') !== '' ) {
					$content_after_menu_element = preg_replace('/\\\\/', '', $this->option('content_after_menu_element'));

					echo '<li class="wprm_after_menu_content">'. $content_after_menu_element . '</li>';
				}

				echo apply_filters('after_wp_responsive_menu_element', $after_menu_element);
				?>
			</ul>
		</div>
		<!-- Menu Elements Ends Here-->

		</div>
		<?php
		endif;
	}

	/**
	*
	* Create Menu Widget
	*
	* @since 3.1
	* @param blank
	* @return array
	*/
	public function wprmenu_create_widget() {
		if( $this->option('enabled') && $this->option('wpr_enable_widget') ) :
			register_sidebar( array(
        'name' => __( 'WP Responsive Menu', 'wprmenu' ),
        'description'	=> __('Widgets added here will appear in the widget menu of wp responsive menu', 'wprmenu'),
        'id' => 'wp-responsive-menu',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
    ) );
		endif;
	}

	/**
	*
	* Save settings into transient
	*
	* @since 3.1
	* @param blank
	* @return array
	*/
	public function wpr_live_update() {
		if( isset($_POST['wprmenu_options']) ) {
			set_transient('wpr_live_settings', $_POST['wprmenu_options'], 60 * 60 * 24);
		}
		wp_die();
	}

	/**
	*
	* Show custom css from the plugin settings
	*
	* @since 3.1
	* @param blank
	* @return string
	*/
	public function wpr_custom_css() {
		$wpr_custom_css = $this->option('wpr_custom_css');

		if( !empty($wpr_custom_css) ) :
		?>
		<style type="text/css">
		<?php
			echo '/* WPR Custom CSS */' . "\n";
    	echo $wpr_custom_css . "\n";
    ?>
		</style>
		<?php
		endif;
	}

	/**
	*
	* Get demo settings from the file
	*
	* @since 3.1
	* @param blank
	* @return json object
	*/
	public function wprmenu_import_data() {
		
		$response = 'error';
		$menu = '';

		if( $this->option('menu') ) {
			$menu = $this->option('menu');
		}
		
		if( isset($_POST) ) {
			$settings_id = isset($_POST['settings_id']) ? $_POST['settings_id'] : '';
			$demo_type = isset($_POST['demo_type']) ? $_POST['demo_type'] : '';

			$demo_id = isset($_POST['demo_id']) ? $_POST['demo_id'] : '';

			if( $settings_id !== '' 
				&& $demo_type !== '' 
				&& $demo_id !== ''  ) {
				$site_name = MG_WPRM_DEMO_SITE_URL;
				$remoteLink = $site_name.'/wp-json/wprmenu-server/v2/type='.$demo_type.'/demo_name='.$demo_id.'/settings_id='.$settings_id;


				$content = wp_remote_get($remoteLink);

				if( is_array($content) 
					&& isset($content['response']) 
					&& $content['response']['code'] == 200  ) {
					
					$content = $content['body'];
					$items = json_decode($content, true);
					
					if( is_array($items) ) {
						$items['menu'] = $menu;
					}

					$content = maybe_serialize($items);

					if( $content ) {
						$response = 'success';
						global $wpdb;

						$wpdb->update(
							$wpdb->prefix.'options',
							array(
								'option_value' => $content,
							),
							array(
								'option_name' => 'wprmenu_options',
							)
						);
					}
					else {
						$response = 'error';
					}
				}
				else {
					$response = 'error';
				}
			}
			else {
				$response = 'error';
			}
		}
		else {
			$response = 'error';
		}
		echo json_encode( array('status' => $response) );		
		wp_die();
	}

	/**
	*
	* Get settings from transient and save into options api
	*
	* @since 3.1
	* @param blank
	* @return json object
	*/
	public function wpr_get_transient_from_data() {
		$response = 'error';
		$check_transient = get_transient('wpr_live_settings');
		
		if( $check_transient) {
			$content = maybe_serialize($check_transient);
			update_option('wprmenu_options', $check_transient);
			$response = 'success';
		}
		
		echo json_encode( array('status' => $response) );		
		wp_die();
	}

	
}