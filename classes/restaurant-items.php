<?php

class Restaurant_Items {

  private static $text = array();

  private static function translate_text() {
    return array('add'     => array('extra'   => __('Add Extra',          'tcc-theme-options'),
                                    'group'   => __('Add New Group',      'tcc-theme-options'),
                                    'item'    => __('Add New Item',       'tcc-theme-options'),
                                    'priced'  => __('Add Priced',         'tcc-theme-option'),
                                    'section' => __('Add New Section',    'tcc-theme-options'),
                                    'tagline' => __('Add Tagline',        'tcc-theme-options')),
                 'delete'  => array('group'   => __('Delete This Group',  'tcc-theme-options'),
                                    'item'    => __('Delete This Item',   'tcc-theme-options'),
                                    'section' => __('Delete This Section','tcc-theme-options'),
                                    'tagline' => __('Delete Tagline','tcc-theme-options')),
                 'edit'    => __('Edit','tcc-theme-options'),
                 'item'    => array('desc'    => __('Description','tcc-theme-options'),
                                    'price'   => __('Price',      'tcc-theme-options')),
                 'page'    => __('Restaurant Menu Items Administration Page','tcc-theme-options'),
                 'saved'   => __('Your menu has been saved!',                'tcc-theme-options'),
                 'status'  => array('hide'    => __('Hide',                  'tcc-theme-options'),
                                    'askh'    => __('Stop this item from showing on the menu?','tcc-theme-options'),
                                    'show'    => __('Show',                  'tcc-theme-options'),
                                    'asks'    => __('Allow this item to appear on the menu?',  'tcc-theme-options')),
                 'title'   => array('group'   => __('Group Title',           'tcc-theme-options'),
                                    'item'    => __('Item Name',             'tcc-theme-options'),
                                    'line'    => __('Extra Description',     'tcc-theme-options'),
                                    'menu'    => __('Menu Title',            'tcc-theme-options'),
                                    'page'    => __('Restaurant Menu Title', 'tcc-theme-options'),
                                    'price'   => _x('0.00','displayed as item price placeholder','tcc-theme-options'),
                                    'section' => __('Section Title',         'tcc-theme-options'),
                                    'tagline' => __('Tagline',               'tcc-theme-option')),
                 'tooltip' => array('handle'  => __('Click to toggle',       'tcc-theme-options'),
                                    'hide'    => __('Checking this will stop this from showing up on your web site.','tcc-theme-options')));
  }

  public static function render_page() {
    self::$text = self::translate_text();
    wp_localize_script('rmp-items','rmpText',self::$text['status']);
    if (isset($_POST['restaurant-menu-nonce'])) {
      self::save_menu_items();
    }
    $data = get_option('rmp_menu_items');
#tcc_log_entry('loading database');
#tcc_log_entry($data);
    if (!$data) $data = array('title' => self::$text['title']['page']); ?>
    <div class='wrap'>
      <div class='section group'>
        <div class='col span_11_of_12 centered'>
          <h1><span class='dashicons dashicons-carrot rmp_icon'></span> <?php echo self::$text['page']; ?></h1>
        </div>
        <div id='section-clone' class='hidden'><?php
          self::render_single_section(array(),'clone'); ?>
        </div>
        <div id='group-clone' class='hidden'><?php
          self::render_single_group(array(),'menu[section_clone]','clone'); ?>
        </div>
        <div id='tagline-clone' class='hidden'><?php
          self::render_tagline('','menu[section_clone][group_clone]'); ?>
        </div>
        <div id='item-clone' class='hidden'><?php
          self::render_single_item(array(),'menu[section_clone][group_clone][item_clone]'); ?>
        </div>
        <div id='line-clone' class='hidden'><?php
          echo self::render_single_line('','menu[section_clone][group_clone][item_clone][extra][line_clone]'); ?>
        </div>
        <div id='priced-clone' class='hidden'><?php
          echo self::render_single_priced(array('clone'=>true),'menu[section_clone][group_clone][item_clone][extra][line_clone]'); ?>
      </div>
      </div><?php
      do_action('restaurant_notices'); ?>
      <form name='restaurant-menu' method='post' action=''>
        <div id='rmp-menu'><?php
          wp_nonce_field( 'restaurant-menu', 'restaurant-menu-nonce' );
          self::render_title($data['title']); ?>
          <div class='section group'>
            <div class='col span_1_of_12'></div>
            <div id='section-wrap' class='col span_10_of_12' data-cnt='<?php echo count($data); ?>'><?php
              self::render_sections($data);
              $button  = "<button type='button' class='button-secondary' onclick='addMenuSection(this);'>";
              $button .= "<i class='fa fa-plus'></i> ".self::$text['add']['section']." </button>";
              echo $button; ?>
            </div>
          </div><?php
        submit_button(); ?>
        </div>
      </form>
    </div><?php
  }

  private static function render_title($title) { ?>
    <div class='section group'>
      <div class='col span_1_of_12'></div>
      <div class='col'>
        <h3 class='title'><?php echo self::$text['title']['menu'] ?></h3>
      </div>
      <div class='col span_8_of_12'>
        <input type='text' class='textwide' name='menu[title]' value='<?php echo $title; ?>' />
      </div>
    </div><?php
  }

  private static function render_sections($data) {
    $cnt = 1;
    foreach($data as $key=>$section) {
      if (!is_array($section)) continue;
      self::render_single_section($section,$cnt++);
    }
  }

  private static function render_single_section($data=array(),$cnt=0) {
    $defs = array('title'=>'','hide'=>'no');
    $data = array_merge($defs,$data);
    $base = "menu[section_$cnt]"; ?>
    <div class='metabox ui-state-default'><?php
      $title = (empty($data['title'])) ? self::$text['title']['section'] : $data['title'];
      self::render_box_header($title); ?>
      <div class='inside hidden'>
        <div class='col span_6_of_6'>
          <div class='col span_1_of_6 centered'>
            <h3 class='title'><?php echo self::$text['title']['section']; ?></h3>
          </div>
          <div class='col span_4_of_6'><?php
            $area  = "<input type='text' class='textwide updateTitle' name='{$base}[title]'";
            $area .= " placeholder='".self::$text['title']['section']."' value='{$data['title']}' />"; echo $area; ?>
          </div>
          <div class='col span_1_of_6 pad-t-half'><?php
            $anchor = ($data['hide']=='yes') ? self::$text['status']['show'] : self::$text['status']['hide'];
            echo "<input type='text' class='hidden' name='{$base}[hide]' value='{$data['hide']}' />";
            echo "<a href='#' class='hide-status'>$anchor</a>"; ?>
          </div>
        </div>
        <div id='group-sort-<?php echo $cnt; ?>' class='col groups' data-section='<?php echo $cnt; ?>'><?php
          $gcnt = self::render_groups($data,$base); ?>
        </div><?php
        $button  = "<button type='button' class='button-secondary addGroup' data-cnt='$gcnt'>";
        $button .= "<i class='fa fa-plus'></i> ".self::$text['add']['group']." </button>";
        #$button .= " <button type='button' class='button-secondary addItem' data-cnt='$icnt'>";
        #$button .= "<i class='fa fa-plus'></i> ".self::$text['add']['item']." </button>";
        $button .= "<button type='button' class='button-secondary pull-right deleteSection'>";
        $button .= "<i class='fa fa-minus'></i> ".self::$text['delete']['section']." </button>";
        echo $button; ?>
      </div>
    </div><?php
  }

  private static function render_groups($data,$base) {
    $cnt = 1;
    foreach($data as $key=>$group) {
      if (is_string($group)) continue;
      self::render_single_group($group,$base,$cnt++);
    }
    return $cnt;
  }

  private static function render_single_group($data=array(),$base,$cnt=0) {
    $defs  = array('title'=>'','hide'=>'no');
    $data  = array_merge($defs,$data);
    $base .= "[group_$cnt]"; ?>
    <div class='metabox ui-state-default'><?php
      $title = (empty($data['title'])) ? self::$text['title']['group'] : $data['title'];
      self::render_box_header($title); ?>
      <div class='inside hidden'>
        <div class='col span_6_of_6'>
          <div class='col span_1_of_6 centered'>
            <h3 class='title'><?php echo self::$text['title']['group']; ?></h3>
          </div>
          <div class='col span_4_of_6'><?php
            $area  = "<input type='text' class='textwide updateTitle' name='{$base}[title]'";
            $area .= " placeholder='".self::$text['title']['group']."' value='{$data['title']}' />";
            echo $area; ?>
          </div>
          <div class='col span_1_of_6 pad-t-half'><?php
            $anchor = ($data['hide']=='yes') ? self::$text['status']['show'] : self::$text['status']['hide'];
            echo "<input type='text' class='hidden' name='{$base}[hide]' value='{$data['hide']}' />";
            echo "<a href='#' class='hide-status'>$anchor</a>"; ?>
          </div>
        </div>
        <div class='col items' data-group='<?php echo $cnt; ?>'><?php
          $icnt = self::render_items($data,$base); ?>
        </div>
        <div class='textwide inline'><?php
          if (isset($data['tagline'])) {
            self::render_tagline($data['tagline'],$base);
          } ?>
        </div>
        <div class='centered'><?php
          $button  = "<button type='button' class='button-secondary pull-left addItem' data-cnt='$icnt'>";
          $button .= "<i class='fa fa-plus'></i> ".self::$text['add']['item']." </button>";
          $bclass  = (isset($data['tagline'])) ? 'hidden' : '';
          $button .= "<span class='$bclass'><button type='button' class='button-secondary addTagline'>";
          $button .= "<i class='fa fa-plus'></i> ".self::$text['add']['tagline']." </button></span>";
		  $bclass  = (isset($data['tagline'])) ? '' : 'hidden';
		  $button .= "<span class='$bclass'><button type='button' class='button-secondary deleteTagline'>";
		  $button .= "<i class='fa fa-minus'></i> ".self::$text['delete']['tagline']." </button></span>";
          $button .= "<button type='button' class='button-secondary pull-right deleteGroup'>";
          $button .= "<i class='fa fa-minus'></i> ".self::$text['delete']['group']." </button>";
          echo $button; ?>
		</div>
      </div>
    </div><?php
  }
  
  private static function render_tagline($text,$base) { ?>
    <div class='tagline'>
      <div class='col span_1_of_6 centered'>
        <h3 class='title'><?php echo self::$text['title']['tagline']; ?></h3>
      </div>
      <div class='col span_4_of_6'><?php
        $area  = "<input type='text' class='textwide' name='{$base}[tagline]'";
        $area .= " placeholder='".self::$text['title']['tagline']."' value='$text' />";
	    echo $area; ?>
	  </div>
	  <div class='col span_1_of_6'></div>
    </div><?php
  } //*/

  private static function render_items($data=array(),$base) {
    $cnt = 1;
    foreach($data as $key=>$item) {
      if (is_string($item)) continue;
      self::render_single_item($item,"{$base}[item_$cnt]");
	  $cnt++;
    }
    return $cnt;
  }

  private static function render_single_item($data=array(),$base) {
    static $setup;
    if (empty($setup)) $setup = Restaurant_Menu_Options::get_setup();
    $defs  = array('title'=>'','hide'=>'no','desc'=>'','price'=>'');
    $data  = array_merge($defs,$data); ?>
    <div class='metabox ui-state-default'><?php
      $title = (empty($data['title'])) ? self::$text['title']['item'] : stripslashes($data['title']);
      self::render_box_header($title); ?>
      <div class='inside hidden item-details'>
        <div class='section group'>
          <div class='col span_1_of_6 centered'>
            <h3 class='title'><?php echo self::$text['title']['item']; ?></h3>
          </div>
          <div class='col span_4_of_6'><?php
            $area  = "<input type='text' class='textwide updateTitle' name='{$base}[title]'";
            $area .= " placeholder='".self::$text['title']['item']."' value='{$data['title']}' />";
            echo $area; ?>
          </div>
          <div class='col span_1_of_6 pad-t-half'><?php
            if (!isset($data['hide'])) $data['hide'] = 'no';
            $anchor = ($data['hide']=='yes') ? self::$text['status']['show'] : self::$text['status']['hide'];
            echo "<input type='text' class='hidden' name='{$base}[hide]' value='{$data['hide']}' />";
            echo "<a href='#' class='hide-status'>$anchor</a>"; ?>
          </div>
        </div>
        <div class='section group'>
          <div class='col span_1_of_6 centered'>
            <h3 class='title'><?php echo self::$text['item']['desc'];  ?></h3>
          </div>
          <div class='col span_4_of_6'><?php
            $html  = "<textarea class='text2 textwide' name='{$base}[desc]'";
            $html .= " placeholder='".self::$text['item']['desc']."'>{$data['desc']}</textarea>";
			$linecnt = 1;
			$showprice = true;
			if (isset($data['extra'])) {
			  foreach($data['extra'] as $key=>$line) {
			    if (empty($line)) continue;
				$showprice = (is_array($line)) ? false : $showprice;
				$type  = 'render_single_'.((is_array($line)) ? 'priced' : 'line');
				$html .= self::$type($line,"{$base}[extra][line_$linecnt]");
			    $linecnt++;
			  }
			}
			$priclass = ($showprice) ? '' : 'hidden';
            echo $html; ?>
          </div>
		  <div class='col span_1_of_6'><?php
		    $button  = "<div><button type='button' class='button-secondary textwide addExtra' data-cnt='$linecnt'>";
			$button .= "<i class='fa fa-plus'></i> ".self::$text['add']['extra']." </button></div>";
			$button .= "<div><button type='button' class='button-secondary textwide addPriced'>";
			$button .= "<i class='fa fa-plus'></i> ".self::$text['add']['priced']." </button></div>";
			echo $button; ?>
		  </div>
        </div>
        <div class='section group'>
          <div class='col span_1_of_6 centered'><?php
            echo "<h3 class='title $priclass'>".self::$text['item']['price']."</h3>"; ?>
          </div>
          <div class='col span_4_of_6'><?php
            $html  = "<span class='$priclass'>{$setup['symbol']} </span>";
            $html .= "<input type='text' inputmode='numeric' class='text6em $priclass' placeholder='".self::$text['title']['price']."'";
            $html .= " name='{$base}[price]' value='{$data['price']}' />";
            echo $html; ?>
          </div>
		  <div class='col span_1_of_6 pull-right'>
            <button type='button' class='button-secondary deleteItem'>
              <i class='fa fa-minus'> </i><?php
			  echo self::$text['delete']['item']; ?>
			</button>
		  </div>
        </div>
      </div>
    </div><?php
  }

  private static function render_single_line($line,$name) {
    $html  = "<div class='pad-lr-2em'>";
	$html .= "<input type='text' class='textwide' name='$name'";
	$html .= " placeholder='".self::$text['title']['line']."' value='$line' />";
	$html .= "</div>";
	return $html;
  }

  private static function render_single_priced($data,$base) {
    static $setup;
    if (empty($setup)) $setup = Restaurant_Menu_Options::get_setup();
    $defs  = array('desc'=>'','price'=>'');
	$data  = array_merge($defs,$data);
    $html  = "<div class='pad-lr-2em'>";
	$html .= "<input type='text' class='text75per' name='{$base}[desc]'";
	$html .= " placeholder='".self::$text['title']['line']."' value='{$data['desc']}' />";
	$html .= "<span class='pull-right'><span>{$setup['symbol']} </span>";
	$html .= "<input type='text' class='text6em' name='{$base}[price]'";
	$html .= " placeholder='".self::$text['title']['price']."' value='{$data['price']}' />";
	$html .= "</span></div>";
	return $html;
  }

  private static function render_box_header($title='') {
    $title = (empty($title)) ? self::$text['title']['menu'] : $title; ?>
    <div class='boxhandle' title='<?php echo self::$text['tooltip']['handle'] ?>'>
      <i class='fa fa-sort-desc pull-right boxtoggle'></i>
      <span class='textwide centered'>
        <h3 class='boxtitle'><?php echo $title; ?></h3>
<!--        <a href='' class='editTitle'><?php #echo self::$text['edit']; ?></a></h3>-->
      </span>
    </div><?
  }

  public static function save_menu_items() {
    if (!isset($_POST['restaurant-menu-nonce'])) return;
    $nonce = $_POST['restaurant-menu-nonce'];
    $menu  = $_POST['menu'];
#tcc_log_entry('incoming data');
#tcc_log_entry($menu);
    if (!wp_verify_nonce($nonce,'restaurant-menu')) return;
    $cleansed = self::clean_menu($menu);
#tcc_log_entry('clean data');
#tcc_log_entry($cleansed);
    update_option('rmp_menu_items',$cleansed);
    add_action('restaurant_notices',array(__CLASS__,'settings_saved'));
  }

  public static function settings_saved() {
    echo "<div class='updated'><p>".self::$text['saved']."</p></div>";
  }

  private static function clean_menu($data) {
    $ret = array();
    foreach($data as $key=>$item) {
      if (strpos($key,'clone')>-1) continue;
	  if (empty($item)) continue;
      $new = sanitize_key($key);
      if ((array)$item===$item) {
        $ret[$new] = self::clean_menu($item);
      } else {
        if (($new==='price') && (!empty($item))) {
          $ret[$new] = floatval($item);
        } else {
		  $text = str_replace("\'",'',$item);
          $ret[$new] = esc_textarea($text);
        }
      }
    }
    return $ret;
  }

}

?>
