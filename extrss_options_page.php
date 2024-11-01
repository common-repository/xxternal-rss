<?php
// mt_options_page() displays the page content for the Test Options submenu
if ( !defined('ABSPATH') ) { die('You are not allowed to call this page directly.'); }
function extrss_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_favorite_food';
    $opt_name2 = 'mt_favorite_count';
    $opt_name3 = 'mt_favorite_language';
    $opt_name4 = 'xxternalrsspubdate';
    $opt_name5 = 'xxternalrssdbg';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name  = 'mt_favorite_food';
    $data_field_name2 = 'mt_favorite_count';
    $data_field_name3 = 'mt_favorite_language';
    $data_field_name4 = 'xxternalrsspubdate';
    $data_field_name5 = 'xxternalrssdbg';

    // Read in existing option value from database
    $opt_val  = get_option( $opt_name );
    $opt_val2 = get_option( $opt_name2 );
    $opt_val3 = get_option( $opt_name3 );
    $opt_val4 = get_option( $opt_name4 );
    $opt_val5 = get_option( $opt_name5 );
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        $opt_val2 = $_POST[ $data_field_name2 ];
        $opt_val3 = $_POST[ $data_field_name3 ];
        $opt_val4 = $_POST[ $data_field_name4 ];
        $opt_val5 = $_POST[ $data_field_name5 ];
        // Save the posted value in the database
        update_option( $opt_name,  $opt_val  );
        update_option( $opt_name2, $opt_val2 );
        update_option( $opt_name3, $opt_val3 );
        update_option( $opt_name4, $opt_val4 );
        update_option( $opt_name5, $opt_val5 );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php
    }
    // Now display the options editing screen
    echo '<div class="wrap">';
    // header
    echo "<h2>" . __( 'xxternal-rss-Feed', 'mt_trans_domain' ) . "</h2>";
    // options form
    ?>
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<p><?php _e("RSS-Feed URL:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p>
<p><?php _e("Anzahl der Einträge::", 'mt_trans_domain' ); ?> 
<select name="<?php echo $data_field_name2; ?>">
  <option value="0" <? if ( $opt_val2 == "0" ) { echo "selected"; } ?>>0</option>
  <option value="1" <? if ( $opt_val2 == "1" ) { echo "selected"; } ?>>1</option>
  <option value="2" <? if ( $opt_val2 == "2" ) { echo "selected"; } ?>>2</option>
  <option value="3" <? if ( $opt_val2 == "3" ) { echo "selected"; } ?>>3</option>
  <option value="4" <? if ( $opt_val2 == "4" ) { echo "selected"; } ?>>4</option>
  <option value="5" <? if ( $opt_val2 == "5" ) { echo "selected"; } ?>>5</option>
  <option value="6" <? if ( $opt_val2 == "6" ) { echo "selected"; } ?>>6</option>
  <option value="7" <? if ( $opt_val2 == "7" ) { echo "selected"; } ?>>7</option>
  <option value="8" <? if ( $opt_val2 == "8" ) { echo "selected"; } ?>>8</option>
  <option value="9" <? if ( $opt_val2 == "9" ) { echo "selected"; } ?>>9</option>
  <option value="10" <? if ( $opt_val2 == "10" ) { echo "selected"; } ?>>10</option>
</select>
</p>
<p><?php _e("Language :", 'mt_trans_language' ); ?> 
<select name="<?php echo $data_field_name3; ?>">
  <option value="de" <? if ( $opt_val3 == "de" ) { echo "selected"; } ?>>de</option>
  <option value="en" <? if ( $opt_val3 == "en" ) { echo "selected"; } ?>>en</option>
  <option value="fr" <? if ( $opt_val3 == "fr" ) { echo "selected"; } ?>>fr</option>
  <option value="es" <? if ( $opt_val3 == "es" ) { echo "selected"; } ?>>es</option>
  <option value="it" <? if ( $opt_val3 == "it" ) { echo "selected"; } ?>>it</option>
</select>
</p>
<p><?php _e("Show PubDate :", 'xxternalrsspubdate' ); ?> 
<select name="<?php echo $data_field_name4; ?>">
  <option value="y" <? if ( $opt_val4 == "y" ) { echo "selected"; } ?>>On</option>
  <option value="n" <? if ( $opt_val4 == "n" ) { echo "selected"; } ?>>Off</option>
</select>
</p>
<p><?php _e("Show Debug :", 'xxternalrssdbg' ); ?> 
<select name="<?php echo $data_field_name5; ?>">
  <option value="y" <? if ( $opt_val5 == "y" ) { echo "selected"; } ?>>On</option>
  <option value="n" <? if ( ($opt_val5 == "n") || ($opt_val5=="")) { echo "selected"; } ?>>Off</option>
</select>
</p>
<p><?php _e("Aktueller Feed:", 'mt_trans_domains'); ?>
<?php echo $opt_val; ?> 
</p>
<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>
</form>
</div>
<?php
}
?>
