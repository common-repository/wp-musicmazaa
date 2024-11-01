<?php
/*
Plugin Name: WP MusicMazaa
Plugin URI: http://www.musicmazaa.com/MMaPlayer/embedded/
Description: WP MusicMazaa makes it easier for you to embed MusicMazaa playlists in Wordpress.
Tags: musicmazaa, embed , flash, audio, hindi, tamil, telugu, kannada, movie
Author: Vamsi Krishna V
Contributors: v1cstudio
Author link: http://www.v1cstudio.com/
Requires at least: 2.2
Tested up to: 2.3
Version: 0.5.0.1
*/
function mm_tag_replace($content){
	$output = $content;	
	$mm_tag_name = "musicmazaa";	
	$mm_open_tag = "[" . $mm_tag_name . "]";
	$mm_close_tag = "[/" . $mm_tag_name . "]";
	$wpmm_content = explode( $mm_open_tag, $output );
	$output = $wpmm_content[0];
	for( $i=1; $i<count($wpmm_content); $i++ ){
		$array2 = explode( $mm_close_tag, $wpmm_content[$i] );
		$wp_mm_uid = $array2[0];		
		$p=0;
		$play="play";
		$playIn = stripos($wp_mm_uid, $play);
		if ($playIn >=33) {
			$p=1;
			$wp_mm_uid=str_replace(" ".$play,"",$wp_mm_uid);
		}		
		$vars='id='.$wp_mm_uid.'&amp;p='.$p;
		$objEmbed.='<object width="400" height="90" type="application/x-shockwave-flash" data="http://musicmazaa.com/MMaPlayer/embedded/player.swf?'.$vars.'">';
		$objEmbed.='<param name="movie" value="http://musicmazaa.com/MMaPlayer/embedded/player.swf?'.$vars.'" />';
		$objEmbed.='<param name="wmode" value="transparent" />';
		$objEmbed.='<em>You need to a flash player enabled browser to view this MusicMazaa Playlist. Powered by <a href="http://musicmazaa.com/?e">MusicMazaa.com</a></em>';
		$objEmbed.='</object>';	
	}
	return $objEmbed;
}
add_filter('the_content','mm_tag_replace');
//Make our admin page function
function wpmm_admin(){
?>
    <div class="wrap">
      <h2>Instructions</h2>
      <br />
      <strong>1. Go to <a href="http://musicmazaa.com/">Musicmazaa.com</a> </strong><br />
      <br />
      <strong>2. Create your playlist.</strong><br />
      <br />
      <strong>3. Get the embed code.</strong><br />
      <br />
      <strong>4. Get your <span style="color:red">embed id</span> from the embed code:</strong><br />
      <br />
      <span style="font-family: Courier">&lt;object width=&quot;400&quot; height=&quot;90&quot; type=&quot;application/x-shockwave-flash&quot; data=&quot;http://musicmazaa.com/MMaPlayer/embedded/player.swf&quot;&gt;&lt;param name=&quot;movie&quot; value=&quot;http://musicmazaa.com/MMaPlayer/embedded/player.swf&quot; /&gt;&lt;param name=&quot;flashvars&quot; value=&quot;id=<span style="color:red">63dc926f017ee2498f926034c6da6e32</span>&amp;amp;p=0&quot; /&gt;&lt;param name=&quot;wmode&quot; value=&quot;transparent&quot; /&gt;&lt;/object&gt;
      <br />      <br />
      <strong>Example Usage 1:</strong><br />
      <span style="font-family: Courier">[musicmazaa]<span style="color: red;">63dc926f017ee2498f926034c6da6e32</span>[/musicmazaa]</span><br />
      <br />
      <strong>Example Usage 2:</strong><br />
      By default the embed player is paused. Use the following to start  <span style="color:teal;">play</span>back immediatly.<br />
      <span style="font-family: Courier">[musicmazaa]<span style="color: red;">63dc926f017ee2498f926034c6da6e32</span> <span style="color:teal;">play</span>[/musicmazaa]</span><br />
      <br />
      For support visit <a href="http://www.musicmazaa.com/MMaPlayer/embedded/">MusicMazaa Embedded</a><br />
      <br />
    </div>
<?php 
}
//Add the options page in the admin panel
function wpmm_addpage() {
    add_submenu_page('options-general.php', 'WP MusicMazaa', 'WP MusicMazaa', 10, __FILE__, 'wpmm_admin');
}
add_action('admin_menu', 'wpmm_addpage');
?>
