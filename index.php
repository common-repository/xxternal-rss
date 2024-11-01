<?php
/*
Plugin Name: xxternal-rss
Plugin URI: https://blog.kuepper.nrw
Description: Include external RSS-Feed and now Google-Reader Feeds into Page/Post per simple tag. Install, config and insert simple tag into your post or site, That's all
Version: 0.1.12.1
Author: Ruediger Kuepper
Author URI: https://blog.kuepper.nrw
*/

# error_reporting(E_ALL); ini_set("display_errors", 1);

define('externalrssversion',  "0.1.12.1");
define('externalrssauthor',   "Ruediger Kuepper");
define('externalrssemail',    "wp-plugins@kuepper.nrw");
define('externalrssurl',      "https://blog.kuepper.nrw/");
define('externalrssdate',     "Do  2 Jan 2020 23:15:46 CET");
define('externalrssbuild',    "#137");

if ( !defined('ABSPATH') ) { die('You are not allowed to call this page directly.'); }

require_once(ABSPATH."wp-content/plugins/xxternal-rss/view.php");
require_once(ABSPATH."wp-content/plugins/xxternal-rss/extrss_options_page.php");

add_action('admin_menu', 'erss_admin_menu');
 
function erss_admin_menu()
{
  if (function_exists('add_menu_page')){
    add_menu_page('Xternal RSS', 'Xxternal RSS', 10, __FILE__, 'extrss_options_page');
    add_submenu_page(__FILE__, 'View', 'View', 8, 'view', 'erssview');
    add_submenu_page(__FILE__, 'About', 'About', 8, 'about', 'mt_sublevel_page2');
  }
}

function getthefeed($url,$count,$show_description) 
{
  $opt_name   = 'mt_favorite_food';
  $opt_name2  = 'mt_favorite_count';
  $opt_name3  = 'mt_favorite_language';
  $opt_name4  = 'xxternalrsspubdate';
  $opt_name5  = 'xxternalrssdbg';
  if ( $url == "" ) {
    $opt_val    = get_option( $opt_name );
  } else {
    $opt_val = $url;
  }
  $debug .= "Debug: " . $count . "<br />";
  if ( ! $count ) {
    $opt_val2 = get_option( $opt_name2 );
  } else {
    $opt_val2 = $count;
  }
  if ( ! $lang ) {
    $opt_val3 = get_option( $opt_name3 );
  } else {
    $opt_val3 = $count;
  }
  if ( ! $printPubDate ) {
    $opt_val4 = get_option( $opt_name4 );
  } else {
    $opt_val4 = "n";
  }
	$newsurl  				= $opt_val; 
  $number   				= $opt_val2; 
  $lang							= $opt_val3;
  $printPubDate			= $opt_val4;
  $xxternalrssdebug = get_option ( $opt_name5 );
	# echo "Opt_name5: $opt_name5 XXX: $xxternalrssdebug ";
	$debug .= "newsurl $newsurl number $number lang $lang printpubdate $printPubDate ";
	$msg ="";
  if ( $show_description ) {
    $xhead_a= '<h3>';
    $xhead_b = '</h3>';
  } else {
    $ul_start = "<ul>";
    $xhead_a  = "<li>\n";
    $xhead_b  = "</li>\n";
    $ul_end = "</ul>";
  }
  $newsurl = str_replace('&#130;',',',$newsurl);
  $newsurl = str_replace('&#8218;',',',$newsurl);
  $file_content = @file_get_contents($newsurl);
  $items = preg_match_all("/<item>(.*)<\/item>/Uis", $file_content, $array_items);
  $array_items = $array_items[1];
  if(!empty($array_items) ) {
    $max=count($array_items);
    $msg .= $ul_start . "\n";
		$debug .= "max $max ";
		if ( ( $count==0 ) && ( $count<$max ) ) { 
			$number=$max; 
		} 
		$debug .= "number $number max $max ";
    for( $n=0; $n<$number; $n++ ) {

      preg_match("/<link>(.*)<\/link>/Uis", 			$array_items[$n], $array_link);      
      preg_match("/<title>(.*)<\/title>/Uis", 		$array_items[$n], $array_title);
      preg_match("/<pubDate>(.*)<\/pubDate>/Uis", $array_items[$n], $array_pubDate);
      $link 		= $array_link[1];
      $title 		= $array_title[1];
      $pubDate 	= $array_pubDate[1];
			$title 		= str_replace('<![CDATA[','',str_replace(']]','',$title));
			$title 		= str_replace('>','',$title);
			$title 		= str_replace('&amp;','&',$title);
			$title 		= str_replace('"amp;','&',$title);
      $msg .= $xhead_a . "<a title=\"\" href=\"" . $link . "\" target=\"_blank\">" . $title . "</a> \n" . $xhead_b . "\n"; 
			if ( $printPubDate == "y" ) { $msg .= "Date: " . $pubDate . "<br />\n"; }
			# $msg .= $xhead_b . " ";
      if($show_description ) {
        preg_match("/<description>(.*)<\/description>/Uis", $array_items[$n], $array_description);
        if(!empty($array_description[1])) {
          $dest = str_replace('[AUTOR]','<strong><em>',str_replace('[/AUTOR]','</em></strong>',str_replace('<![CDATA[','',str_replace(']]','',$array_description[1]))));        
          $dest = str_replace('[...]>','',$dest);
          $dest = str_replace('&lt;','<',$dest);
          $dest = str_replace('&gt;','>',$dest);
          $dest = str_replace('&amp;','"',$dest);
          $msg .= $dest;
        }
      }
      if ( $show_description ) {
				// read_more Language de/en/...
        if ( $lang == "de" ) { $read_more = "Weiterlesen ... "; } 
				elseif ( $lang == "fr" ) { $read_more = "Lire la suite ... "; }
				elseif ( $lang == "es" ) { $read_more = "Leer más ... "; }
				elseif ( $lang == "it" ) { $read_more = "Per saperne di più ... "; }
				elseif ( $lang == "en" ) { $read_more = "Read more ..."; }
				else { $read_more = "Read more ..."; }
        $msg .= "<br><a title=\"" . $read_more . "\" href=\"". $link . "\" target=\"_blank\">" . $read_more . "</a>\n";
        $msg .= "<hr />\n";
      }
    }
    $msg .= $ul_end;
  } else {
    # $msg .= "Keine Meldungen"; 
    $items = preg_match_all("/<entry[^>]*>(.+)<\/entry>/Uis", $file_content, $array_items);
    $array_items = $array_items[1];
    if(!empty($array_items)) {
      $max=count($array_items);
			$debug .= "max $max ";
			if ( ( $count==0 ) && ( $count<$max ) ) { 
				$number=$max; 
			} 
			$debug .= "number $number max $max ";
      for( $n=0; $n<$number; $n++ ) { 
        preg_match("/<link[^>]*href=\"(.*)\"*\/>/i", $array_items[$n], $array_link);    
        preg_match("/<title[^>]*>(.*)<\/title>/Uis", $array_items[$n], $array_title);
        $link = $array_link[1];
        $title = $array_title[1];
        $msg .= $xhead_a . "<a title=\"\" href=\"" . $link . "\" target=\"_blank\">" . $title . "</a>" . $xhead_b . " ";
        if($show_description ) {
          preg_match("/<summary[^>]*>(.*)<\/summary>/Uis", $array_items[$n], $array_description);
          if(!empty($array_description[1])) {
          $dest = str_replace('[AUTOR]','<strong><em>',str_replace('[/AUTOR]','</em></strong>',str_replace('<![CDATA[','',str_replace(']]','',$array_description[1]))));
          $dest = str_replace('&lt;','<',$dest);
          $dest = str_replace('&gt;','>',$dest);
          $dest = str_replace('&amp;','"',$dest);
          $msg .= $dest;
          }
        }
        if ( $show_description ) {
	        if ( $lang == "de" ) { $read_more = "Weiterlesen..."; } 
					elseif ( $lang == "fr" ) { $read_more = "Lire la suite ... "; }
					elseif ( $lang == "es" ) { $read_more = "Leer más ... "; }
					elseif ( $lang == "it" ) { $read_more = "Per saperne di più ... "; }
					elseif ( $lang == "en" ) { $read_more = "Read more ..."; }
					else { $read_more = "Read more ..."; }
				  $msg .= "<br><a title=\"" . $read_more . "\" href=\"". $link . "\" target=\"_blank\">" . $read_more . "</a>\n";
          $msg .= "<hr />";
        }
      }
      $msg .= $ul_end;
    } else {
      $msg .= "Weder RSS noch Google Feed gefunden";
    }
  }
  $returnvalue = "<div id=\"xxternalrss\">" . $msg . "</div>";
	# echo "chck: $xxternalrssdebug";
	if ( ( $xxternalrssdebug == "y" ) || ( $xxternalrssdebug == "" ) ) { $returnvalue .= "<div style=\"background-color:#AAAAAA; color:#DD0000;\">" . $debug . "</div>"; }
  return $returnvalue;
}
function mt_sublevel_page2() {
    // Now display the options editing screen
    echo '<div class="wrap">';
    // header
    echo "<h2>" . __( 'Xxternal-RSS-Feed', 'mt_trans_domain' ) . "</h2>";

    echo "<h2>About</h2>";
    echo "<p>Xxternal-RSS Version: " . externalrssversion . "Build: " . externalrssbuild  . "</p>"; 
    echo "<p>Builddate: " . externalrssdate   . "</p>"; 
    echo "<p>Author:    " . externalrssauthor . "</p>"; 
    echo "<p>E-Mail:    <a href=\"mailto:" . externalrssemail . "\">" . externalrssemail . "</a></p>"; 
    echo "<p>Homepage:  <a href=\"" . externalrssurl . "\">" . externalrssurl . "</a></p>"; 
    echo "<hr>";
    echo "<h3>Usage:</h3>";
    echo "<p>Im Adminbreich Ihrer Wordpress Installation ist im Menü der Eintrag \"Xxternal-RSS\".";
    echo "Dort kann eine URL zu einem RSS-Feed eingtragen werden und die Anzahl der Einträge die aus diesem";
    echo "Feed angzeigt werden sollen.</p>";
    echo "<p>Der Feed kann dann mit folgender Zeile in jede Seite oder Blogeintrag eingefügt werden auf der er erscheinen soll:<p>";
    echo "<p><code class=\"prettyprint\">[rss=1,url=]</code></p>";
    echo "<p>Wenn ein anderer Feed benutzt werden soll, der nicht im Adminbereich eingetragen wurde, kann man machen mit:</p>";
    echo "<p><code class=\"prettyprint\">[rss=5,url=http://www.example.org/feed/]</code></p>";
    echo "<p>Dieser Eintrag zeigt die ersten 10 Einträge des Feeds von www.example.org an</p>";
    echo "</div>";
}

add_filter('the_content', 'getexternalfeedtags', 10);
add_filter('the_excerpt', 'getexternalfeedtags', 10);


function getexternalfeedtags($content) 
{
  if ( stristr( $content, '[rss' )) {

	$search = "@(?:<p>)*\s*\[rss=\s*(\w+|^\+)(|,)(.*)\]\s*(?:</p>)*@i";
  $items = preg_match_all($search, $content, $matches);  
		if (is_array($matches)) {
      foreach ($matches[1] as $key =>$v1) {
        $search = $matches[0][$key];
        $count = $matches[1][0];
        $parameter = $matches[0][$key].",";
        $mrss = "@(rss=(.*?)),.*\]@i";
				$prss = preg_match_all($mrss, $search, $rmatch);
				$count = $rmatch[2][0];
        $murl = "@url=([^,]*)(,([^=]*)=([^,]*))*\]@i";
				$purl = preg_match_all($murl, $search, $umatch);
				$url = $umatch[1][0];
				$murl = "@google=([^,]*)(,([^=]*)=([^,]*))*\]@i";
				$purl = preg_match_all($murl, $search, $umatch);
				$google = $umatch[1][0];
				$murl = "@extend=([^,]*)(,([^=]*)=([^,]*))*\]@i";
				$purl = preg_match_all($murl, $search, $umatch);
				$extend = $umatch[1][0];
				$murl = "@compact=([^,]*)(,([^=]*)=([^,]*))*\]@i";
				$purl = preg_match_all($murl, $search, $umatch);
				$compac = $umatch[1][0];
        if ( $compac == 1 ) { $show_description = 0; } 
        else { $show_description = 1; }
        $replace = getthefeed( $url, $count, $show_description, $compac, $extend, $google );
        $content= str_replace ($search, $replace, $content);
        $url = '';
      }
    }
  }
  return $content;
}


function xxternal_rss_widget_init() {

  // check for the required WP functions, die silently for pre-2.2 WP.
  if ( !function_exists('wp_register_sidebar_widget') )
    return;

  // front end view
  function xxternal_rss_widget($args) {
    extract($args);
    // the widget's form, themeable through $args
    $title = 'Xxternal-RSS';
    $show_description = false;
    echo $before_widget . $before_title . $title . $after_title;
    echo '<div id="xxternalrss" style="margin-top:5px;">';
    echo getthefeed($url,$count,$show_description); 
    echo '</div>';
    echo $after_widget;
  }

  // back end controller
  function xxternal_rss_widget_control() {
    echo 'kommt noch, ganz sicher.';
  }

  // let WP know of this plugin's widget view entry
  wp_register_sidebar_widget('xxternal_rss_widget', 'Xxternal-RSS Widget', 
        'xxternal_rss_widget', 
       array(
          'classname' => 'xxternal_rss_widget', 
          'description' =>'Allows the user to add RSS-Feeds to sidebar'.
                    ' So der Plan ;-).',
      )
        );

  // let WP know of this widget's controller entry
  wp_register_widget_control('xxternal_rss_widget', 'Xxternal-RSS Widget', 
        'xxternal_rss_widget_control', 
      array(
          'width' => 300
      )
        );
}
function xxternal_rss_header()
{
  echo "\n\n        <meta name='Xxternal-RSS' content='" . externalrssversion . "' />";
  echo "\n        <meta name='Xxternal-RSS-Build' content='" . externalrssbuild . "' />";
  echo "\n        <meta name='Xxternal-RSS-URL' content='" . externalrssurl . "' />";
  echo "\n        <meta name='Xxternal-RSS-Author' content='" . externalrssauthor . "' />";
  echo "\n        <meta name='Xxternal-RSS-Builddate' content='" . externalrssdate . "' />\n\n";
}
function xxternal_rss_install() {
  add_option("mt_favorite_food","http://twitter.com/statuses/user_timeline/18465527.rss");
  add_option("mt_favorite_count","0");
  add_option("mt_favorite_language","en");
  add_option("xxternalrsspubdate","1");
  add_option("xxternalrssdbg","n");
}
register_activation_hook( __FILE__, 'xxternal_rss_install');
function xxternal_rss_deinstall() {   
  delete_option("mt_favorite_food");
  delete_option("mt_favorite_count");
  delete_option("mt_favorite_language");
  delete_option("xxternalrsspubdate");
  delete_option("xxternalrssdbg");
}
register_uninstall_hook( __FILE__, 'xxternal_rss_deinstall');

add_action('widgets_init', 'xxternal_rss_widget_init');
add_action('wp_head', 'xxternal_rss_header');
?>
