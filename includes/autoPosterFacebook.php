<?php

require_once __DIR__ . "/facebookSettings.php";
require_once __DIR__ . "/../lib/FacebookSDK/src/Facebook/autoload.php";
error_reporting(0);

class facebook
 {
   
    // class variables

    protected static $fb;
 
    public static function init() {
      $settings = get_option('facebook_config');

      $appId = $settings['app_id'];
      $appSecret =  $settings['app_secret'];

      self::$fb = new Facebook\Facebook(array(
        'app_id' => $appId,
        'app_secret' => $appSecret,
    ));
    }

    public static function post_fc($postID) {
      $message = get_option('facebook_config')['auto_message_fc'];
      $link = get_option('facebook_config')['fc_link'];
      $attachImage = get_option('facebook_config')['auto_img_fc'];
      $post = get_post($postID);
      $post_link = get_the_permalink(isset($id));
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
      // $thumbID = get_post_thumbnail_id( $postID );
      // $imgLink = wp_get_attachment_url( $thumbID );
      if($link == false){
        $linkData = [
          'message' => $message,
          'link' => "http://periodismo.ull.es/",
        ];
      }else{
        $linkData = [
          'message' => $message,
          'link' => $link,
        ];
      }

      $page_id = get_option('facebook_config')['id_page'];
      $pageAccessToken = get_option('facebook_config')['access_token'];
      if(!empty($post_link) && $post->post_status == 'publish') {
      $response = self::$fb->post('/'.$page_id.'/feed/', $linkData, $pageAccessToken);
      $graphNode = $response->getGraphNode();
      }
    }
 }

 $autoFacebook = get_option('facebook_config')['auto_post_fc'];

 if($autoFacebook == 'si'){
   add_action('init', 'facebook::init');
   add_action('save_post', 'facebook::post_fc');
 } 

?>