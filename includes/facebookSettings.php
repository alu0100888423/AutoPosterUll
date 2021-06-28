<?php
function facebook_settings_init(){

  register_setting('facebookSettings', 'facebook_config');

  add_settings_section(
    'facebook_config_section',
    'Configuración de facebook',
    'title_section_fc',
    'facebookSettings'
  );

  add_settings_field(
    'facebook_config_campo1',
    'App ID',
    'config_field_app_id',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'app_id',
    ]
  );

  add_settings_field(
    'facebook_config_campo2',
    'App Secret',
    'config_field_app_id_secret',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'app_secret',
    ]
  );

  add_settings_field(
    'facebook_config_campo7',
    'Access Token',
    'config_field_access_token',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'access_token',
    ]
  );

  add_settings_field(
    'facebook_config_campo8',
    'Id de la página de facebook',
    'config_field_id_page',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'id_page',
    ]
  );

  add_settings_field(
    'facebook_config_campo3',
    'Autopublicar en facebook',
    'config_field_auto_post_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_post_fc',
    ]
  );

  add_settings_field(
    'facebook_config_campo6',
    'Link Enlazado',
    'config_field_fc_link',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'fc_link',
    ]
  );

  add_settings_field(
    'facebook_config_campo4',
    'Mensaje personalizado del tweet',
    'config_field_message_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_message_fc',
    ]
  );

  add_settings_field(
    'facebook_config_campo5',
    'Incluir imagen principal',
    'config_field_img_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_img_fc',
    ]
  );

}
add_action('admin_init', 'facebook_settings_init');

function title_section_fc(){
  echo "<p>Selecciona los datos de tu cuenta de facebook</p>";
}

function config_field_app_id($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_app_id_secret($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_access_token($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_id_page($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_auto_post_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='facebook_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_fc_link($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_message_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<textarea value='$valor' name='facebook_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>";
  
  echo $html;
}


function config_field_img_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='facebook_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

?>