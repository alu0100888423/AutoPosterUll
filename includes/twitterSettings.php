<?php
function twitter_settings_init(){
  //Registrando una nueva sección en la pestaña mp_pruebas
  register_setting('twitterSettings', 'twitter_config');

  add_settings_section(
    'twitter_config_section',
    'Configuración de twitter',
    'title_section',
    'twitterSettings'
  );

  add_settings_field(
    'twitter_config_campo1',
    'API Key',
    'config_field_api',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'api_key',
    ]
  );

  add_settings_field(
    'twitter_config_campo2',
    'API Secret Key',
    'config_field_api_secret',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'api_key_secret',
    ]
  );
  
  add_settings_field(
    'twitter_config_campo3',
    'Access Token',
    'config_field_token',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'access_token',
    ]
  );

  add_settings_field(
    'twitter_config_campo4',
    'Access Secret Token',
    'config_field_token_secret',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'access_token_secret',
    ]
  );

  add_settings_field(
    'twitter_config_campo5',
    'Autopublicar en twitter',
    'config_field_auto_tweet',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_tweet',
    ]
  );

  add_settings_field(
    'twitter_config_campo6',
    'Mensaje personalizado del tweet',
    'config_field_message',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_message',
    ]
  );

  add_settings_field(
    'twitter_config_campo7',
    'Incluir imagen principal',
    'config_field_img',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_img',
    ]
  );
  add_settings_field(
    'twitter_config_campo8',
    'Programar subida dentro de un cierto tiempo',
    'config_field_schedule',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_schedule',
    ]
  );

  add_settings_field(
    'twitter_config_campo9',
    'Horas y minutos de retraso para publicar el tweet',
    'config_field_time',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_time',
    ]
  );

  add_settings_field(
    'twitter_config_campo10',
    'Programar a cierta franja de horas',
    'config_field_program',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_program',
    ]
  );

  add_settings_field(
    'twitter_config_campo11',
    'Desde esta hora se puede publicar',
    'config_field_time_start',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_time_start',
    ]
  );  
  
  add_settings_field(
    'twitter_config_campo12',
    'Hasta esta hora se puede publicar',
    'config_field_time_end',
    'twitterSettings',
    'twitter_config_section',
    [
      'label' => 'auto_time_end',
    ]
  );

}
add_action('admin_init', 'twitter_settings_init');

function title_section(){
  echo "<p></p>";
}

function config_field_api($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='twitter_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_api_secret($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='twitter_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}
function config_field_token($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='twitter_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_token_secret($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='twitter_config[{$args['label']}]' value='$valor' style='width: 50%'><br />
  <br/><span style='background-color: #FFFBCC'>Nota: No olvide acceder al <a href='https://apps.twitter.com/' target='_blank'>enlace</a> para crear una nueva app de Twitter, con sus respectivas API Keys, y Access Tokens.</span>";

  echo $html;
}

function config_field_auto_tweet($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='twitter_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_message($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<textarea value='$valor' name='twitter_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>
  <br/><span style='background-color: #FFFBCC'> Nota: Por favor, usar #post_title = título, #post_content = contenido del post</span>
  <br/><span style='background-color: #FFFBCC'> #post_link = link del post, y #author_name = autor del post. NO superar 280 caracteres!! </span>
  ";
  
  echo $html;
}


function config_field_img($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='twitter_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_schedule($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='twitter_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_time($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='twitter_config[{$args['label']}]'>
  ";

  echo $html;
}

function config_field_program($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='twitter_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}


function config_field_time_start($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='twitter_config[{$args['label']}]'>
  ";
  echo $html;
}

function config_field_time_end($args){

  $mpconfig = get_option('twitter_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='twitter_config[{$args['label']}]'>
  ";

  echo $html;
}


?>