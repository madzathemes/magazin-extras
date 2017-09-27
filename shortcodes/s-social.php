<?php
function social( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => ''. esc_html__( 'Follow Us', 'magazine-plug'  ) .'',
		), $atts));

			$shortcode = '';
			$shortcode .= '<div class="socials">';
				$shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>';
				if ( function_exists( 'get_scp_widget' ) ) {	$shortcode .= get_scp_widget().'<div class="clear"></div>'; }

			$shortcode .= '</div>';
			return $shortcode;
}
add_shortcode('social', 'social');
?>
