<?php

class Restaurant_Menu {

  private static $symbol = '$';
  private static $format = '%1$s %2$5.2f';
  private static $class  = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';

  public static function display_menu() {
echo "<h1>In Menu!!!</h1>";
    self::$format = _x('%1$s %2$5.2f','item price format: symbol and number','tcc-theme-options');
    $menu  = get_option('tcc_options_menu-setup');
    $mdefs = Restaurant_Menu_Options::options_defaults('menu-setup');
    $opts  = array_merge($mdefs,$menu);
    if ($opts['layout']=='single') self::$class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
    self::$symbol = $opts['symbol'];
    $items = get_option('rmp_menu_items');
    $html  = "<div class='tagline'>";
    $html .= "<h2 class='rmp-mtitle'>";
    $html .= stripslashes($items['title']);
    $html .= "</h2></div>";
    foreach($items as $key=>$section) {
      if (!is_array($section)) continue;
      if (!isset($section['title'])) continue;
      if ((isset($section['hide'])) && ($section['hide']=='yes')) continue;
      $html .= self::render_section($section);
    }
    return $html;
  }

  private static function render_section($section) {
    $html  = "<div>";
    $html .= "<div class='tagline'>";
    $html .= "<h2 class='rmp-stitle'>";
    $html .= stripslashes($section['title']);
    $html .= "</h2></div>";
    foreach($section as $key=>$group) {
      if (!is_array($group)) continue;
      if ((isset($group['hide'])) && ($group['hide']=='yes')) continue;
      $html .= self::render_group($group);
    }
    $html .= "</div>";
    $html .= "<div class='clear'></div>";
    return $html;
  }

  private static function render_group($group) {
    $html  = "<div class='".self::$class."'>";
    $html .= "<div class='inner-padding article'>";
    if (!empty($group['title'])) {
      $html .= "<div class='tagline'>";
      $html .= "<h2 class='rmp-gtitle'>";
      $html .= stripslashes($group['title']);
      $html .= "</h2></div>";
    }
    $html .= "<div class='clearbottom'></div>";
    $html .= "<div class='bcomenupage'>";
    foreach($group as $key=>$item) {
      if (!is_array($item)) continue;
      if ((isset($item['hide'])) && ($item['hide']=='yes')) continue;
      $html .= self::render_item($item);
    }
    $html .= "</div>";
    if (isset($group['tagline'])) {
      $html .= "<div class='block'>";
      $html .= "<p class='rmp-tagline'>";
      $html .= stripslashes($group['tagline']);
      $html .= "</p></div>";
      $html .= "<div class='clearbottom'></div>";
    }
    $html .= "</div></div>";
    return $html;
  }

  private static function render_item($item) {
    $html = '';
    if (!empty($item['title'])) {
      $html .= "<h2 class='rmp-ititle'>";
      $html .= htmlentities($item['title']);
      $html .= "</h2>";
    }
    if ((isset($item['price'])) && (floatval($item['price'])>0)) {
      $price = sprintf(self::$format,self::$symbol,$item['price']);
      $html .= "<span class='rmp-price'>$price</span>";
    }
    $html .= "<div class='clear'></div>";
    if (!empty($item['desc'])) {
      $html .= "<p class='rmp-desc'>";
      $html .= htmlentities($item['desc']);
      $html .= "</p>";
    }
    if (isset($item['extra'])) {
      $html .= "<ul class='rmp-extra'>";
      foreach($item['extra'] as $key=>$line) {
        if ((array)$line===$line) {
          $price = sprintf(self::$format,self::$symbol,$line['price']);
          $html .= "<li class='rmp-pdesc'>";
          $html .= htmlentities($line['desc']);
          $html .= " <span class='rmp-eprice'>$price</span></li>";
        } else {
          $html .= "<li class='rmp-edesc'>$line</li>";
        }
      }
      $html .= "</ul>";
    }
    $html .= "<div class='clearbottom'></div>";
    return $html;
  }

}

?>
