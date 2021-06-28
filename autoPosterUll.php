<?php
/*
Plugin name: Auto Poster ULL
Plugin URI: htttp://autoposterull.com
Description: A plugin to auto post your wordpress posts to your favourite social media.
Version: 1.0
Author: Juan Eduardo Flores
Author URI: http://miurlpersonal.com
Text Domain: autoposterull
Domain Path: /lenguages
License: GPL2

Miplugin es un software libre y está distribuido...
*/

require_once __DIR__ . "/lib/codebird-php/src/codebird.php";
require_once('includes/autoPosterTwitter.php');
require_once('includes/autoPosterFacebook.php');
require_once('includes/autoPosterInstagram.php');
require_once plugin_dir_path(__FILE__) . 'includes/menus.php';
require_once __DIR__ . "/includes/twitterSettings.php";
require_once __DIR__ . "/includes/facebookSettings.php";
require_once __DIR__ . "/includes/instagramSettings.php";

error_reporting(0);
register_activation_hook( __FILE__, 'mpInstall');
register_deactivation_hook( __FILE__, 'mpDeactivation' );
// register_uninstal_hook(__FILE__, 'mpDesinstall');
function mpInstall(){
if(!function_exists('mp_plugins_cargados')){
  add_action( 'plugins_loaded', 'mp_plugins_cargados');
  function mp_plugins_cargados(){
    //Agregando meta description
    if(current_user_can('edit_pages')){
      add_action('wp_head', 'add_meta_description');
      if( !function_exists( 'add_meta_description')){
        function add_meta_description(){
          echo "<meta name='description' content='Herramienta de automatización' >";
    
        }
      }
    }
  }
}
}

if(!function_exists('mp_options_page')){
  add_action('admin_menu', 'mp_options_page');
    function mp_options_page() {

      $menus = [];
      $submenus =[];

      $menus[] = [
        'pageTitle' => 'Auto Poster Ull',
        'menuTitle' => 'Auto Poster Ull',
        'capability' => 'manage_options',
        'menuSlug' => 'auto_poster_ull',
        'functionName' => 'auto_poster_ull_display',
        'iconUrl' => plugin_dir_url(__FILE__) . 'lib/images/icono.svg',
        'position' => 15,
      ];

      addMenusPage( $menus );

      $submenus[] = [
        'parentSlug' => 'auto_poster_ull',
        'pageTitle' => 'Settings Twitter',
        'menuTitle' => 'Settings Twitter',
        'capability' => 'manage_options',
        'menuSlug' => 'settings_twitter',
        'functionName' => 'twitter_auto_poster_ull',
      ];
      $submenus[] = [
        'parentSlug' => 'auto_poster_ull',
        'pageTitle' => 'Settings Facebook',
        'menuTitle' => 'Settings Facebook',
        'capability' => 'manage_options',
        'menuSlug' => 'settings_fc',
        'functionName' => 'fc_auto_poster_ull',
      ];
      $submenus[] = [
        'parentSlug' => 'auto_poster_ull',
        'pageTitle' => 'Settings Instagram',
        'menuTitle' => 'Settings Instagram',
        'capability' => 'manage_options',
        'menuSlug' => 'settings_ig',
        'functionName' => 'ig_auto_poster_ull',
      ];

      addSubMenusPage( $submenus );

    }
}

if(!function_exists('auto_poster_ull_display')){
  function auto_poster_ull_display(){
    if(current_user_can('edit_others_posts')){
      $nonce = wp_create_nonce('mi_nonce_security');

      if( isset($_POST['nonce']) && ! empty($_POST['nonce']) ){
        if( wp_verify_nonce($_POST['nonce'], 'mi_nonce_security') ){
          echo "<br><br><br>hemos verificado correctamente el nonce recibido<br>
            Nonce: {$_POST['nonce']}<br>";
        }
        else{
          echo "Este nonce no es correcto";
        }
      }
      echo"<h1>Bienvenido al plugin</h1>";
    }
  }
}

if(!function_exists('twitter_auto_poster_ull')){
  function twitter_auto_poster_ull(){
    if(current_user_can('manage_options')){
      echo "<form action='options.php' method='post'>";
      settings_fields('twitterSettings');
      do_settings_sections('twitterSettings');
      submit_button('Guardar cambios');
    }
  }
}

if(!function_exists('fc_auto_poster_ull')){
  function fc_auto_poster_ull(){
    if(current_user_can('manage_options')){
      echo "<form action='options.php' method='post'>";
      settings_fields('facebookSettings');
      do_settings_sections('facebookSettings');
      submit_button('Guardar cambios');
    }
  }
}

if(!function_exists('ig_auto_poster_ull')){
  function ig_auto_poster_ull(){
    if(current_user_can('manage_options')){
      echo "<form action='options.php' method='post'>";
      settings_fields('instagramSettings');
      do_settings_sections('instagramSettings');
      submit_button('Guardar cambios');
    }
  }
}
?>