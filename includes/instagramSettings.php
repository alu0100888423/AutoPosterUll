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
  add_settings_field(
    'instagram_config_campo5',
    'Introducir mensaje del post',
    'config_field_message_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'message_ig',
    ]
  );
  add_settings_field(
    'instagram_config_campo6',
    'Programar subida dentro de un cierto tiempo',
    'config_field_schedule_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_schedule_ig',
    ]
  );

  add_settings_field(
    'instagram_config_campo7',
    'Minutos de retraso para publicar el post (0-59)',
    'config_field_time_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_time_ig',
    ]
  );

  add_settings_field(
    'instagram_config_campo10',
    'Programar a cierta franja de horas',
    'config_field_program_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_program_ig',
    ]
  );

  add_settings_field(
    'instagram_config_campo11',
    'Desde esta hora se puede publicar',
    'config_field_time_start_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_time_start_ig',
    ]
  );  
  
  add_settings_field(
    'instagram_config_campo12',
    'Hasta esta hora se puede publicar',
    'config_field_time_end_ig',
    'instagramSettings',
    'instagram_config_section',
    [
      'label' => 'auto_time_end_ig',
    ]
  );

}
add_action('admin_init', 'instagram_settings_init');

function title_section_ig(){
  echo "<p></p>";
}

function config_field_access_token_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='instagram_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'>Nota: No olvide acceder al <a href='https://developers.facebook.com/async/registration/' target='_blank'>enlace</a> para crear una nueva app de Facebook, con sus respectivas App Secret, y Access Token.</span>
  ";
  echo $html;
}

function config_field_page_id($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='instagram_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'>Nota: Para acceder al ID dirigirse a su página de Facebook, en el apartado de Información y luego Más información.</span>
  <br/><span style='background-color: #FFFBCC'>Para esto tenemos que tener asociada nuestras cuentas con la página de Facebook</span>";
  
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
  echo"<br/><span style='background-color: #FFFBCC'>Si no marcas esta casilla, o no introduces ninguna imagen en el post se pondrá el logo de PeriodismoUll por defecto</span>";

}

function config_field_message_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<textarea value='$valor' name='instagram_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>
  <br/><span style='background-color: #FFFBCC'> Nota: Por favor, usar #post_title = título, #post_content = contenido del post</span>
  <br/><span style='background-color: #FFFBCC'> #post_link = link del post, y #author_name = autor del post.</span>
  ";
  echo $html;
}

function config_field_schedule_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='instagram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_time_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='instagram_config[{$args['label']}]'>
  ";

  echo $html;
}

function config_field_program_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='instagram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_time_start_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='instagram_config[{$args['label']}]'>
  ";
  echo $html;
}

function config_field_time_end_ig($args){

  $mpconfig = get_option('instagram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='instagram_config[{$args['label']}]'>
  ";

  echo $html;
}
?>