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
require_once('includes/autoPosterTelegram.php');
require_once plugin_dir_path(__FILE__) . 'includes/menus.php';
require_once __DIR__ . "/includes/twitterSettings.php";
require_once __DIR__ . "/includes/facebookSettings.php";
require_once __DIR__ . "/includes/instagramSettings.php";
require_once __DIR__ . "/includes/telegramSettings.php";


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

      $submenus[] = [
        'parentSlug' => 'auto_poster_ull',
        'pageTitle' => 'Settings Telegram',
        'menuTitle' => 'Settings Telegram',
        'capability' => 'manage_options',
        'menuSlug' => 'settings_telegram',
        'functionName' => 'telegram_auto_poster_ull',
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
      echo"<div style='margin-right:10px; margin-top: 10px; padding: 5px;  box-shadow: 0 0 0 4px #fff; padding-left: 15px; background-color:  #54048c '><h1 style='text-align: center'>Auto Poster ULL - Herramienta de automatización en WordPress.</h1>
      </div>
      <br/>
      <div style='display: flex; margin-right:10px; margin-top: 10px; padding: 10px;  box-shadow: 0 0 0 4px black; padding-left: 15px; background-color: white '>

      <div style='margin: 30px; width: 750px; height: 600px; line-height: 30px; margin-right:10px; margin-top: 10px; padding: 15px;  box-shadow: 0 0 0 4px #fff; padding-left: 15px; background-color: #641b9c '>
      <h1 style='text-align: center'>Bienvenidos a todos a Auto Poster ULL!</h1>
      <br/>
      <h3 style='text-align: left'> Con este plugin nos podremos a encontrar una herramienta de automatización de RRSS para nuestra página web en WordPress. 
      Podrás automatizar tareas en el tiempo o en el momento en tus redes sociales favoritas así como: Twitter, Facebook, Telegram e Instagram. Automatizar 
      cuando publicas un post, y cuando deseas que este se notifique en tus redes sociales, o al momento de subirlo. </h3>
      </div>
      
      <br/>

      <div style='margin: 30px; width: 750px; height: 600px; line-height: 30px; margin-right:10px; margin-top: 10px; padding: 15px;  box-shadow: 0 0 0 4px #fff; padding-left: 15px; background-color: #7c3cac  '>
      <h1 style='text-align: center'>Instrucciones de uso</h1>
      <br/>
      <h3 style='text-align: left'> 
      <ol>
      <li type='disc'>En el menú de la izquierda donde encontrarás el plugin, poniendo el ratón encima podrás ver los distintos settings de configuración de las distintas redes sociales. </li>
      <li type='disc'>Todas las settings requieren de tus datos de cuenta, como pueden ser apis, tokens, etc. Podrás encontrar un enlace haciendo click en los iconos de abajo. </li>
      <li type='disc'>En algunas confiiguraciones podrás incluir un mensaje, en el cual tendrás ciertos comandos para introducir directamente títulos, contenido, etc del post en cuestión. </li>
      <li type='disc'>También podrás programar que en X horas y X minutos se publique en cualquiera de las redes sociales disponibles. </li>
      </ol>
      </h3>
      <a style='padding-left: 50px;' href='https://developer.twitter.com/en/apps'><img src='https://logodownload.org/wp-content/uploads/2014/09/twitter-logo-6.png' width='100' height='80' alt='twitter settings'/></a>
      <a style='padding-left: 50px;' href='https://developers.facebook.com/'><img src='https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Facebook_f_logo_%282019%29.svg/1365px-Facebook_f_logo_%282019%29.svg.png' width='80' height='80' alt='facebook settings'/></a>
      <a style='padding-left: 50px;' href='https://core.telegram.org/bots#3-how-do-i-create-a-bot'><img src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Telegram_2019_Logo.svg/1200px-Telegram_2019_Logo.svg.png' width='80' height='80' alt='telegram settings'/></a>

      </div>

      <div style='margin: 30px; width: 750px; height: 600px; line-height: 30px; margin-right:10px; margin-top: 10px; padding: 15px;  box-shadow: 0 0 0 4px #fff; padding-left: 15px; background-color:  #8b56b4   '>
      <h1 style='text-align: center'>About</h1>
      <br/>
      <h3 style='text-align: left'> 
      <ol>
      <li type='disc'>Título: Herramienta de automatización en Wordpress para la web PeriodismoULL. </li>
      <li type='disc'>Proyecto de Fin de Grado de la Escuela Tecnológica Superior de Ingeniería Informática de La Universidad de La Laguna. </li>
      <li type='disc'>Tutora: Carina Soledad González González. </li>
      <li type='disc'>Cotutor: Eduardo Nacimiento García. </li>
      <li type='disc'>Alumno: Juan Eduardo Flores González - alu0100888423. </li>
      </ol>
      </h3>
      </div>

      </div>

      <p style='text-align: right; padding-right: 10px'> Proyecto final de Grado de Ingeniería informática, E.T.S.I.I de la Universidad de La Laguna.</p>
      <p style='text-align: right; padding-right: 10px'> Publicado por Juan Eduardo Flores González - Alu0100888423.</p>
      
      ";
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

if(!function_exists('telegram_auto_poster_ull')){
  function telegram_auto_poster_ull(){
    if(current_user_can('manage_options')){
      echo "<form action='options.php' method='post'>";
      settings_fields('telegramSettings');
      do_settings_sections('telegramSettings');
      submit_button('Guardar cambios');
    }
  }
}


?>