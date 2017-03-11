<?php
/*
Plugin Name: Magazin
Plugin URI: https://themeforest.net
Description: Magazin Plugin
Author: Madars Bitenieks
Version: 1.2.8
Author URI: https://themeforest.net
*/
include_once ('plugins/easy-google-fonts/easy-google-fonts.php');
include_once ('plugins/megadropdownmenu-master/megadropdown.php');
if (class_exists('WPBakeryShortCode')) {
	include_once ('vc-shortcodes/vc-ads.php');
	include_once ('vc-shortcodes/vc-subscribe.php');
	include_once ('vc-shortcodes/vc-social.php');
	include_once ('vc-shortcodes/vc-grid.php');
	include_once ('vc-shortcodes/vc-posts.php');
}
include_once ('shortcodes/s-ads.php');
include_once ('shortcodes/s-posts.php');
include_once ('shortcodes/s-space.php');
include_once ('shortcodes/s-social.php');
include_once ('shortcodes/s-share.php');
include_once ('shortcodes/s-subscribe.php');
include_once ('shortcodes/s-grid.php');
include_once ('widgets/w-ads.php');
include_once ('widgets/w-posts.php');
include_once ('widgets/w-space.php');
include_once ('widgets/w-social.php');
include_once ('widgets/w-subscribe.php');
include_once ('widgets/w-grid.php');
include_once ('customizer/customizer-general.php');
include_once ('customizer/customizer-ads.php');
include_once ('customizer/customizer-posts.php');
include_once ('example-functions.php');
include_once ('plugins/kirki/kirki.php');
add_filter('widget_text', 'do_shortcode');

function magazin_text_domain() {
	load_plugin_textdomain( 'magazin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'magazin_text_domain' );

add_action('init','magazin_random_add_rewrite');
function magazin_random_add_rewrite() {
       global $wp;
       $wp->add_query_var('random');
       add_rewrite_rule('random/?$', 'index.php?random=1', 'top');
}
add_action('template_redirect','magazin_random_template');
function magazin_random_template() {
       if (get_query_var('random') == 1) {
               $posts = get_posts('post_type=post&orderby=rand&numberposts=1');
               foreach($posts as $post) {
                       $link = get_permalink($post);
               }
               wp_redirect($link,307);
               exit;
       }
}

function magazin_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'magazin_javascript_detection', 0 );

function magazin_theme_setup() {

	add_image_size( 'magazin_350', 420, 320, true );
	add_image_size( 'magazin_585', 640, 313, true );
	add_image_size( 'magazin_100', 100, 68, true );

}

add_action( 'after_setup_theme', 'magazin_theme_setup' );

function magazin_header_hooks() {

	if ( is_singular() ) { wp_enqueue_script( "comment-reply" ); }

	?>
	<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); if ( !is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) { ?>
	<meta property="og:url"           content="<?php the_permalink();?>" />
	<meta property="og:type"          content="<?php wp_title();?>" />
	<meta property="og:title"         content="<?php the_title();?>" />
	<meta property="og:description"   content="<?php the_excerpt();?>" />
	<meta property="og:image"         content="<?php  if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url(get_the_ID(),"full"); } ?>" />
	<?php } ?>
	<style type="text/css"><?php echo balanceTags(get_option("custom_css")); ?></style>
	<?php
}
add_action('wp_head', 'magazin_header_hooks');

function magazin_custom_excerpts($limit) {
    return wp_trim_words(get_the_content(), $limit);
}

function html_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/*-----------------------------------------------------------------------------------*/
/* Magazin Framework post views function
/*-----------------------------------------------------------------------------------*/
function magazin_PostViews($post_ID) {

    //Set the name of the Posts Custom Field.
    $count_key = 'magazin_post_views_count';

    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, $count_key, true);

    //If the the Post Custom Field value is empty.
    if($count == ''){
        $count = 0; // set the counter to zero.

        //Delete all custom fields with the specified key from the specified post.
        delete_post_meta($post_ID, $count_key);

        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, $count_key, '0');
        return $count . '';

    //If the the Post Custom Field value is NOT empty.
    }else{
        $count++; //increment the counter by 1.
        //Update the value of an existing meta key (custom field) for the specified post.
        update_post_meta($post_ID, $count_key, $count);

        //If statement, is just to have the singular form 'View' for the value '1'
        if($count == '1'){
        return $count . '';
        }
        //In all other cases return (count) Views
        else {
        return $count . '';
        }
    }
}
function magazin_custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-wrap"><div class="video-container">'.$html.'</div></div>';
    return $return;
}
add_filter( 'embed_oembed_html', 'magazin_custom_oembed_filter', 10, 4 ) ;

add_filter('body_class','magazin_class');
function magazin_class($classes) {

	$body_class = "";

	$title = get_post_meta(get_the_ID(), "magazin_page_title", true);
	if(!empty($title) and !is_search()){
		$body_class .= 'remove-title';
	}

	$classes[] =  $body_class;
	return $classes;
}

function admin_js() {
    if ( is_admin() ) {
			wp_enqueue_script('magazin-admin', get_template_directory_uri() . '/inc/js/admin.js', array('jquery'), '1.0', true);
    }
}
add_action('admin_footer', 'admin_js');

function magazin_get_shares( $post_id ) {
	$cache_key = 'magazin_share_cash' . $post_id;
	$access_token = 'APP_ID|APP_SECRET';
	$count = get_transient( $cache_key ); // try to get value from Wordpress cache
	$share_time = get_option("share_time");

	if(!empty( $share_time )){ $share_times = $share_time; } else { $share_times = 36000;  }
	// if no value in the cache
	if ( $count === false ) {
		$count = "0";
		$response = wp_remote_get('https://graph.facebook.com/v2.7/?id=' . urlencode( get_permalink( $post_id ) ) . '&access_token=' . get_option("facebook_token"));

		if(!is_wp_error($response)) {
			$body = json_decode( $response['body'] );
			//print_r($body);

			if (!empty($body->share)) {
	      $count = intval( $body->share->share_count );
	    }

			update_post_meta($post_id, 'magazin_share_count_real', $count);

			set_transient( $cache_key, $count, $share_times ); // store value in cache for a 10 hour
		}
	}
	return $count;
}

function SearchFilter($query) {

	if ($query->is_search) {

		$query->set('post_type', 'post');

	}

	return $query;

}

add_filter('pre_get_posts','SearchFilter');


add_action('pre_get_posts', 'myprefix_query_offset', 1 );
function myprefix_query_offset(&$query) {


		if ( is_admin() || ! $query->is_main_query() )
	 return;

    //Before anything else, make sure this is the right query...
    if ( ! $query->is_category() ) {
        return;
    }

    $offset = 4;
    $option = get_option("magazin_theme_options");
    if(!empty($option['category_grid_style'])) {
    	if($option['category_grid_style']=="1"){
    		$offset = 0;
    	} else if($option['category_grid_style']=="2"){
    		$offset = 3;
    	} else if($option['category_grid_style']=="3"){
    		$offset = 2;
    	}
    }

    $default_posts_per_page = get_option( 'posts_per_page' );

    //First, define your desired offset...
    $offset = $offset;

    //Next, determine how many posts per page you want (we'll use WordPress's settings)
    $ppp = $default_posts_per_page;

    //Next, detect and handle pagination...
    if ( $query->is_paged ) {

        //Manually determine page query offset (offset + current page (minus one) x posts per page)
        $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );

        //Apply adjust page offset
        $query->set('offset', $page_offset );

    }
}

add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );
function myprefix_adjust_offset_pagination($found_posts, $query) {

    //Define our offset again...
    $offset = 4;

    //Ensure we're modifying the right query object...
    if ( $query->is_category() ) {
        //Reduce WordPress's found_posts count by the offset...
        return $found_posts - $offset;
    }
    return $found_posts;
}

function mt_header_script() {
		$autoplay = get_option("carousel_autoplay");
		$options = get_option("sticky_sidebar");
		wp_enqueue_script('mt-effects', get_template_directory_uri() . '/inc/js/effects.js', array('jquery'), '1.0', true);
		if(is_rtl()){ wp_add_inline_script( 'mt-effects', 'var $rtl = true;', 'before' ); } else { wp_add_inline_script( 'mt-effects', 'var $rtl = false;', 'before' ); }
		if(!empty($autoplay)){ if($autoplay=="1"){ wp_add_inline_script( 'mt-effects', 'var $autoplay = true;', 'before' ); } else { wp_add_inline_script( 'mt-effects', 'var $autoplay = false;', 'before' ); } } else { wp_add_inline_script( 'mt-effects', 'var $autoplay = false;', 'before' ); }
		if(!empty($options)){ if($options=="1"){ wp_add_inline_script( 'mt-effects', 'jQuery(document).ready(function() {jQuery(".sidebar, .panel-grid-cell").theiaStickySidebar({additionalMarginTop: 29,	minWidth: 1200});});', 'after' ); } } else { wp_add_inline_script( 'mt-effects', 'jQuery(document).ready(function() {jQuery(".sidebar, .panel-grid-cell").theiaStickySidebar({additionalMarginTop: 29,	minWidth: 1200});});', 'after' ); }
}
add_action('wp_enqueue_scripts', 'mt_header_script');

function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['twitter'] = 'Twitter URL';
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['instagram'] = 'Instagram URL';
	$profile_fields['linkedin'] = 'LinkedIn URL';
	$profile_fields['pinterest'] = 'Pinterest URL';
	$profile_fields['youtube'] = 'YouTube URL';
	$profile_fields['dribbble'] = 'Dribbble URL';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
?>
