<?php

require_once __DIR__ . "/telegramSettings.php";
error_reporting(0);

class Telegram
 {
    
    public static function post($postID) {
      $settings = get_option('telegram_config');

      $token = $settings['tg_token'];
      $id =  $settings['tg_id'];
      $message = $settings['tg_message'];
      $attachImage = $settings['auto_img_tg'];
      $post = get_post($postID);
      $post_link = get_permalink($postID);
      $post_title = $post->post_title;
      $post_content = strip_tags($post->post_content);
      $post_content = str_replace('&nbsp;','',$post_content);
      $post_content = strip_shortcodes($post_content);
      $post_author_id = $post->post_author;
      $author_name = get_the_author_meta('user_nicename', $post_author_id);
      $message = str_replace('#post_title', $post_title, $message);
      $message = str_replace('#post_content', $post_content, $message);
      $message = str_replace('#post_link', $post_link, $message);
      $message = str_replace('#author_name', $author_name, $message);
      $thumbID = get_post_thumbnail_id( $postID );
      $imgLink= wp_get_attachment_image_url( $thumbID, 'original');

      if ( ($post->post_status == 'publish') && ($attachImage == 'no')) { 
        $urlMsg = "https://api.telegram.org/bot{$token}/sendMessage";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlMsg);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chat_id={$id}&parse_mode=HTML&text=$message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
      }
      else if ( ($post->post_status == 'publish') && ($attachImage == 'si')) {
        $url = "https://api.telegram.org/bot{$token}/sendPhoto";
        $arg = array(
          'chat_id' => $id , 
          'photo' => $imgLink,
          'caption' => $message
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arg);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
      }
    }

    public static function schedule($postID) {
      $minutes = get_option('telegram_config')['auto_time_tg'][3];
      $minutes1 = get_option('telegram_config')['auto_time_tg'][4];
      $hours = get_option('telegram_config')['auto_time_tg'][0];
      $hours1 = get_option('telegram_config')['auto_time_tg'][1];


      if( !wp_next_scheduled( 'share_the_post_tg', $postID) ){
        wp_clear_scheduled_hook( 'share_the_post_tg');
        wp_schedule_single_event(time() + $minutes1*60+ $minutes*600+$hours*36000+$hours1*3600, 'share_the_post_tg', array($postID));
        }
    }


    public static function recop($postID) {
      $options_program = get_option('recop_tg');
      if(end($options_program) !== $postID){
        $elemento = array_push($options_program, $postID);
        update_option('recop_tg', $options_program);
      }
  }

    public static function programm() {
      $settings = get_option('telegram_config');
      $options_program = get_option('recop_tg');
      $time_st = $settings['auto_time_start_tg'];
      $time_en = $settings['auto_time_end_tg'];

      $arr = array_map('intval', explode(':', $time_st));
      $time_start = mktime($arr[0], $arr[1], 1, date('m'), date('d'), date('Y'));
      $arr1 = array_map('intval', explode(':', $time_en));
      $time_end = mktime($arr1[0], $arr1[1], 1, date('m'), date('d'), date('Y'));

      if(!empty($options_program) && (time()+3600 > $time_start) && (time()+3600 < $time_end)){
        $token = $settings['tg_token'];
        $id =  $settings['tg_id'];
        $message = $settings['tg_message'];
        $attachImage = $settings['auto_img_tg'];

        $postID = array_shift($options_program);
        update_option('recop_tg', $options_program);
        
        $post = get_post($postID);
        $post_link = get_permalink($postID);
        $post_title = $post->post_title;
        $post_content = strip_tags($post->post_content);
        $post_content = str_replace('&nbsp;','',$post_content);
        $post_content = strip_shortcodes($post_content);
        $post_author_id = $post->post_author;
        $author_name = get_the_author_meta('user_nicename', $post_author_id);
        $message = str_replace('#post_title', $post_title, $message);
        $message = str_replace('#post_content', $post_content, $message);
        $message = str_replace('#post_link', $post_link, $message);
        $message = str_replace('#author_name', $author_name, $message);
        $thumbID = get_post_thumbnail_id( $postID );
        $imgLink= wp_get_attachment_image_url( $thumbID, 'original');

        if ( ($post->post_status == 'publish') && ($attachImage == 'no')) { 
          $urlMsg = "https://api.telegram.org/bot{$token}/sendMessage";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $urlMsg);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "chat_id={$id}&parse_mode=HTML&text=$message");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          curl_close($ch);
        }
        else if ( ($post->post_status == 'publish') && ($attachImage == 'si')) {
          $url = "https://api.telegram.org/bot{$token}/sendPhoto";
          $arg = array(
            'chat_id' => $id , 
            'photo' => $imgLink,
            'caption' => $message
          );
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $arg);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          curl_close($ch);
        }
      }
      else{
        return;
      }
    }

 }

function my_cron_schedules_tg($schedules){
  $schedules["5min"] = array(
      'interval' => 5*60,
      'display' => __('Once every 5 minutes'));
  return $schedules;
}

add_filter('cron_schedules','my_cron_schedules_tg');

$array = [];
add_option('recop_tg', $array);

if( !wp_next_scheduled( 'programm_tg') ){
  wp_schedule_event(time(), '5min', 'programm_tg');
}
add_action('programm_tg', 'Telegram::programm');

$autoTelegram = get_option('telegram_config')['tg_auto'];
$autoSchedule = get_option('telegram_config')['auto_schedule_tg'];
$autoProgram = get_option('telegram_config')['auto_program_tg'];

  if(($autoTelegram == 'si') && ($autoSchedule == 'no') && ($autoProgram == 'no')){
    add_action('publish_post', 'Telegram::post');
  }
  else if(($autoTelegram == 'si') && ($autoSchedule == 'si')){
    add_action('publish_post', 'Telegram::schedule');
    add_action('share_the_post_tg', 'Telegram::post', 10, 1);
  }
  else if(($autoTelegram == 'si') && ($autoProgram == 'si')){
    add_action('publish_post', 'Telegram::recop');
   }
?>
