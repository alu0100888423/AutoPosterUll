<?php
function telegram_settings_init(){
  //Registrando una nueva sección en la pestaña mp_pruebas
  register_setting('telegramSettings', 'telegram_config');

  add_settings_section(
    'telegram_config_section',
    'Configuración de telegram',
    'title_section_tg',
    'telegramSettings'
  );

  add_settings_field(
    'telegram_config_campo1',
    'Token del Bot de Telegram',
    'config_field_token_bot',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'tg_token',
    ]
  );

  add_settings_field(
    'telegram_config_campo2',
    'Id del Canal/Usuario',
    'config_field_tg_id',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'tg_id',
    ]
  );

  add_settings_field(
    'telegram_config_campo3',
    'Autopublicar en telegram',
    'config_field_tg_auto',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'tg_auto',
    ]
  );

  add_settings_field(
    'telegram_config_campo4',
    'Mensaje personalizado a enviar',
    'config_field_tg_message',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'tg_message',
    ]
  );

  add_settings_field(
    'telegram_config_campo5',
    'Incluir imagen principal',
    'config_field_img_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_img_tg',
    ]
  );
  add_settings_field(
    'telegram_config_campo8',
    'Programar subida dentro de un cierto tiempo',
    'config_field_schedule_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_schedule_tg',
    ]
  );

  add_settings_field(
    'telegram_config_campo9',
    'Horas y minutos de retraso para publicar',
    'config_field_time_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_time_tg',
    ]
  );
  add_settings_field(
    'telegram_config_campo10',
    'Programar a cierta franja de horas',
    'config_field_program_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_program_tg',
    ]
  );

  add_settings_field(
    'telegram_config_campo11',
    'Desde esta hora se puede publicar',
    'config_field_time_start_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_time_start_tg',
    ]
  );  
  
  add_settings_field(
    'telegram_config_campo12',
    'Hasta esta hora se puede publicar',
    'config_field_time_end_tg',
    'telegramSettings',
    'telegram_config_section',
    [
      'label' => 'auto_time_end_tg',
    ]
  );

}
add_action('admin_init', 'telegram_settings_init');

function title_section_tg(){
  echo "<p></p>";
}

function config_field_token_bot($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';
  $html = "<input type='text' name='telegram_config[{$args['label']}]' value='$valor' style='width: 50%'>
  <br/><br/><span style='background-color: #FFFBCC'> Nota: Tienes que generar un bot con BotFather y el comando /newbot</span>
  <br/><span style='background-color: #FFFBCC'> luego elegir el nombre y el username,y nos ofrecerá el token de este.</span>
  ";
  echo $html;
}

function config_field_tg_id($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='text' name='telegram_config[{$args['label']}]' value='$valor' style='width: 50%'>";

  echo $html;
}

function config_field_tg_auto($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='telegram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_tg_message($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<textarea value='$valor' name='telegram_config[{$args['label']}]' cols=80 rows=10> {$valor} </textarea>
  <br/><span style='background-color: #FFFBCC'> Nota: Por favor, usar #post_title = título, #post_content = contenido del post</span>
  <br/><span style='background-color: #FFFBCC'> #post_link = link del post, y #author_name = autor del post.</span>
  ";
  echo $html;
}


function config_field_img_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='telegram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_schedule_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='telegram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}

function config_field_time_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='telegram_config[{$args['label']}]'>
  ";

  echo $html;
}

function config_field_program_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

	$items = array("si", "no");
	foreach($items as $item) {
		$checked = ($mpconfig[$args['label']]==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='telegram_config[{$args['label']}]' type='radio' /> $item</label><br />";
	}
}


function config_field_time_start_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='telegram_config[{$args['label']}]'>
  ";
  echo $html;
}

function config_field_time_end_tg($args){

  $mpconfig = get_option('telegram_config');
  $valor = isset($mpconfig[$args['label']]) ? esc_attr($mpconfig[$args['label']]) : '';

  $html = "<input type='time' id='appt' value='$valor' name='telegram_config[{$args['label']}]'>
  ";

  echo $html;
}

?>