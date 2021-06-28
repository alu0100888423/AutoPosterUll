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

}
add_action('admin_init', 'twitter_settings_init');

function title_section(){
  echo "<p>Selecciona los datos de tu cuenta de Twitter</p>";
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

  $html = "<input type='text' name='twitter_config[{$args['label']}]' value='$valor' style='width: 50%'>";

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

  $html = "<textarea value='$valor' name='twitter_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>";
  
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

?>