<?php
function instagram_settings_init(){

  register_setting('instagramSettings', 'instagram_config');

  add_settings_section(
    'instagram_config_section',
    'Configuración de instagram',
    'title_section_ig',
    'instagramSettings'
  );

  add_settings_field(
    'instagram_config_campo1',
    'Access Token',
    'config_field_access_token_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'access_token',
    ]
  );

  add_settings_field(
    'instagram_config_campo2',
    'Page Id de Facebbok',
    'config_field_page_id',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'page_id',
    ]
  );

  add_settings_field(
    'instagram_config_campo3',
    'Autopublicar en instagram',
    'config_field_auto_post_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_post_ig',
    ]
  );

  add_settings_field(
    'instagram_config_campo4',
    'Incluir imagen principal',
    'config_field_img_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_img_ig',
    ]
  );

}
add_action('admin_init', 'instagram_settings_init');

function title_section_ig(){
  echo "<p>Selecciona los datos de tu cuenta de instagram</p>";
}

function config_field_access_token_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='instagram_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_page_id($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='instagram_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_auto_post_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='instagram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_img_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='instagram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

?>