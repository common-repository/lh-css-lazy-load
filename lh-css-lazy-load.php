<?php
/**
 * Plugin Name: LH CSS Lazy load
 * Plugin URI: https://lhero.org/portfolio/lh-css-lazy-load/
 * Description: Lazy load non critical css
 * Author: Peter Shaw
 * Version: 1.02
 * Author URI: https://shawfactor.com/
 * Requires PHP: 5.6
 * Text Domain: lh_css_lazy_load
 * Domain Path: /languages
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('LH_CSS_lazy_load_plugin')) {


class LH_CSS_lazy_load_plugin {

var $filename;
var $options;
var $opt_name = 'lh_css_lazy_load-options';
var $path = 'lh-css-lazy-load/lh-css-lazy-load.php';
var $namespace = 'lh_css_lazy_load';

private static $instance;


private function is_this_plugin_network_activated(){

if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if ( is_plugin_active_for_network( $this->path ) ) {
    // Plugin is activated

return true;

} else  {


return false;


}

}


/**
     * Helper function for registering and enqueueing scripts and styles.
     *
     * @name    The    ID to register with WordPress
     * @file_path        The path to the actual file
     * @is_script        Optional argument for if the incoming file_path is a JavaScript source file.
     */
    private function load_file( $name, $file_path, $is_script = false, $deps = array(), $in_footer = true, $atts = array() ) {
        $url  = plugins_url( $file_path, __FILE__ );
        $file = plugin_dir_path( __FILE__ ) . $file_path;
        if ( file_exists( $file ) ) {
            if ( $is_script ) {
                wp_register_script( $name, $url, $deps, filemtime($file), $in_footer ); 
                wp_enqueue_script( $name );
            }
            else {
                wp_register_style( $name, $url, $deps, filemtime($file) );
                wp_enqueue_style( $name );
            } // end if
        } // end if
	  
	  if (isset($atts) and is_array($atts) and isset($is_script)){
		
		
  $atts = array_filter($atts);

if (!empty($atts)) {

  $this->script_atts[$name] = $atts; 
  
}

		  
	 add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	   

	   
if (isset($this->script_atts[$handle][0]) and !empty($this->script_atts[$handle][0])){
  
$atts = $this->script_atts[$handle];

$implode = implode(" ", $atts);
  
unset($this->script_atts[$handle]);

return str_replace( ' src', ' '.$implode.' src', $tag );

unset($atts);
usent($implode);

		 

	 } else {
	   
 return $tag;	   
	   
	   
	 }
	

}, 10, 2 );
 

	
	  
	}
		
    } // end load_file
    
    
    
private function register_scripts_and_styles() {

if (!is_admin()){



// include the add-to-home-screen-js library
$this->load_file( $this->namespace.'-js', '/scripts/lh-css-lazy-load.js',  true, array(), true, array('async="async"'));

}


}





public function plugin_menu() {
add_options_page(__('LH CSS Lazy Load Options', $this->namespace ), __('CSS Lazy Load', $this->namespace ), 'manage_options', $this->filename, array($this,"plugin_options"));

}

public function plugin_options() {

if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	
	if( isset($_POST[ $this->namespace."-nonce" ]) && wp_verify_nonce($_POST[ $this->namespace."-nonce" ], $this->namespace."-nonce" )) {
	    
	    
if (isset($_POST[$this->namespace.'-css_handles']) and ($_POST[$this->namespace.'-css_handles'] != "")){
    
$pieces = explode(",", sanitize_text_field(trim($_POST[$this->namespace.'-css_handles'])));
    
$result = array_map('trim', $pieces);
    
$options[$this->namespace.'-css_handles'] = $result;

}
	    
	    
	    
	    
	    
	    
	    
if (update_option( $this->opt_name, $options )){

$this->options = get_option($this->opt_name);

?>
<div class="updated"><p><strong><?php _e('Values saved', $this->namespace ); ?></strong></p></div>
<?php


}  
	    
	    
	    
	}
	
	
	// Now display the settings screen
include('partials/options-general.php');
	
}


// add a settings link next to deactive / edit
public function add_settings_link( $links, $file ) {

	if( $file == $this->filename ){
		$links[] = '<a href="'. admin_url( 'options-general.php?page=' ).$this->filename.'">Settings</a>';
	}
	return $links;
}



public function general_init() {
  
          // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();
        
 

}


public function add_noscript_filter($tag, $handle, $src){
    // as this filter will run for every enqueued script
    // we need to check if the handle is equals the script
    // we want to filter. If yes, than adds the noscript element
    
    //echo $handle;
    
   if (isset($this->options[$this->namespace.'-css_handles']) and is_array($this->options[$this->namespace.'-css_handles']) and in_array($handle, $this->options[$this->namespace.'-css_handles'])) {

$tag = '<noscript class="lh_css_lazy_load-file">
'.$tag.'</noscript>
';
    }
        return $tag;
}

public function plugins_loaded(){
    
load_plugin_textdomain( $this->namespace, false, basename( dirname( __FILE__ ) ) . '/languages' ); 
    
    
    //add the general admin menu
add_action('admin_menu', array($this,"plugin_menu"));

add_filter('plugin_action_links', array($this,"add_settings_link"), 10, 2);

         
    if (!is_admin()){
        
        
        //register required styles and scripts
add_action('init', array($this,"general_init"));

// adds the add_noscript_filter function to the script_loader_tag filters
// it must use 3 as the last parameter to make $tag, $handle, $src available
// to the filter function
add_filter('style_loader_tag', array($this,"add_noscript_filter"), 10, 3);
        
        
    }
    
    
    
}


 /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }
    

public function __construct() {
    
$this->filename = plugin_basename( __FILE__ );
$this->options = get_option($this->opt_name);


//run our hooks on plugins loaded to as we may need checks       
add_action( 'plugins_loaded', array($this,'plugins_loaded'));
    
}

}

$lh_css_lazy_load_instance = LH_CSS_lazy_load_plugin::get_instance();

}



?>