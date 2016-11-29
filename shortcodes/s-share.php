<?php
function share( $atts, $content = null ) {
  $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
  $shortcode = '';
	$shortcode .= '<div class="single-share">' . apply_filters('the_content', $content);
    $shortcode .= '<div class="single-share-socials">';
      $shortcode .= '<a href="http://www.facebook.com/sharer.php?u='. get_the_permalink() .'" target="_blank"><div class="facebook"></div></a>';
      $shortcode .= '<a href="http://twitter.com/home/?status='. get_the_title().' - '. get_the_permalink() .'" target="_blank"><div class="twiiter"></div></a>';
      $shortcode .= '<a href="https://plus.google.com/share?url='. get_the_permalink() .'" target="_blank"><div class="google"></div></a>';
      $shortcode .= '<a href="http://pinterest.com/pin/create/button/?url='. get_the_permalink() .'&media='.  $url .'" target="_blank"><div class="pinterest"></div></a>';
    $shortcode .= '</div>';
  $shortcode .= '</div>';
	return $shortcode;
}
add_shortcode('share', 'share');
?>
