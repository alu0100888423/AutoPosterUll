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
    'Mensaje personalizado de la publicación',
    'config_field_message_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_message_fc',
    ]
  );
  add_settings_field(
    'facebook_config_campo9',
    'Programar subida dentro de cierto tiempo',
    'config_field_schedule_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_schedule_fc',
    ]
  );

  add_settings_field(
    'facebook_config_campo10',
    'Horas y Minutos de retraso para publicar',
    'config_field_time_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_time_fc',
    ]
  );
  
  add_settings_field(
    'facebook_config_campo11',
    'Programar a cierta franja de horas',
    'config_field_program_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_program_fc',
    ]
  );

  add_settings_field(
    'facebook_config_campo12',
    'Desde esta hora se puede publicar',
    'config_field_time_start_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_time_start_fc',
    ]
  );  
  
  add_settings_field(
    'facebook_config_campo13',
    'Hasta esta hora se puede publicar',
    'config_field_time_end_fc',
    'facebookSettings',
    'facebook_config_section',
    [
      'label' => 'auto_time_end_fc',
    ]
  );


}
add_action('admin_init', 'facebook_settings_init');

function title_section_fc(){
  echo "";
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

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'>Nota: No olvide acceder al <a href='https://developers.facebook.com/async/registration/' target='_blank'>enlace</a> para crear una nueva app de Facebook, con sus respectivas App Secret, y Access Token.</span>";

  echo $html;
}

function config_field_id_page($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'>Nota: Para acceder al ID dirigirse a su página de Facebook, en el apartado de Información y luego Más información. </span>";

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

  $html = "<input type='text' name='facebook_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'> Nota: Si dejas vacío el campo anterior del link enlazado, se te pondrá automáticamente el link del post en cuestión.</span>
  ";
  echo $html;
}

function config_field_message_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<textarea value='$valor' name='facebook_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>
  <br/><span style='background-color: #FFFBCC'> Nota: Por favor, usar #post_title = título, #post_content = contenido del post</span>
  <br/><span style='background-color: #FFFBCC'> #post_link = link del post, y #author_name = autor del post.</span>
  ";
  echo $html;
}

function config_field_schedule_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='facebook_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_time_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='facebook_config[{$args['label']}]'>
  ";

  echo $html;
}

function config_field_program_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='facebook_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}


function config_field_time_start_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='facebook_config[{$args['label']}]'>
  ";
  echo $html;
}

function config_field_time_end_fc($args){

  $mpconfig = get_option('facebook_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='facebook_config[{$args['label']}]'>
  ";

  echo $html;
}

?>