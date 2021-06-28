<?php

function addMenusPage($menus) {
  if( is_array($menus)){
    for( $i=0; $i < count($menus); $i++ ) {

      add_menu_page(
        $menus[$i]['pageTitle'],
        $menus[$i]['menuTitle'],
        $menus[$i]['capability'],
        $menus[$i]['menuSlug'],
        $menus[$i]['functionName'],
        $menus[$i]['iconUrl'],
        $menus[$i]['position']
      );
    }
  }
}

function addSubMenusPage($submenus) {
  if( is_array($submenus)){
    for( $i=0; $i < count($submenus); $i++ ) {

      add_submenu_page(
        $submenus[$i]['parentSlug'],
        $submenus[$i]['pageTitle'],
        $submenus[$i]['menuTitle'],
        $submenus[$i]['capability'],
        $submenus[$i]['menuSlug'],
        $submenus[$i]['functionName']
      );
    }
  }
}

function mpDeactivation(){
  flush_rewrite_rules();
}

?>