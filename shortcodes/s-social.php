<?php
function social( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => 'Follow Us',
		), $atts));

			$facebook_name = get_option("facebook_username");
			$facebook_token = get_option("facebook_token");
			$twitter_name = get_option("twitter_username");
			$youtube_name = get_option("youtube_username");

			$shortcode = '';
			$shortcode .= '<div class="socials">';
				$shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>';
				if(!empty($facebook_name)){ $shortcode .= '<a target="_blank" href="https://www.facebook.com/'.$facebook_name.'" class="social-facebook"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Follow us on', 'magazin'  ) .' <strong>Facebook</strong></span></a>'; }
				if(!empty($twitter_name)){ $shortcode .= '<a target="_blank" href="https://twitter.com/'.$twitter_name.'" class="social-twitter"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Follow us on', 'magazin'  ) .' <strong>Twitter</strong></span></a>'; }
				if(!empty($youtube_name)){ $shortcode .= '<a target="_blank" href="https://www.youtube.com/'.$youtube_name.'" class="social-subscribe"><span class="social-count"></span><span class="social-text">'. esc_html__( 'Subscribe us on', 'magazin'  ) .' <strong>YouTube</strong></span></a>'; }
				$shortcode .= '<div class="clear"></div>';
				$shortcode .= "<script>
				var facebook = '".$facebook_name."';
				var twitter = '".$twitter_name."';
				var youtube = '".$youtube_name."';
				var token = '".$facebook_token."';

				jQuery.ajax({
					url: 'https://graph.facebook.com/'+facebook,
					dataType: 'json',
					type: 'GET',
					data: {access_token:token,fields:'likes'},
					success: function(data) {
						var followers = parseInt(data.likes);
						var k = kFormatter(followers);
						jQuery('.social-facebook .social-count').append(followers).digits();

					}
				});
				jQuery.ajax({
					url: 'https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names='+twitter,
					dataType: 'jsonp',
					type: 'GET',
					crossDomain : true,
					success: function(data) {
						var twitterfollowcount = data[0]['followers_count'];
						jQuery('.social-twitter .social-count').append(twitterfollowcount).digits();
					}
				});
				jQuery.ajax({
				  url: 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername='+youtube,
				  dataType: 'jsonp',
				  type: 'GET',
				  data:{key:'AIzaSyDXpwzqSs41Kp9IZj49efV3CSrVxUDAwS0'},
				  success: function(data) {
				    var subscribers = parseInt(data.items[0].statistics.subscriberCount);
				    var k = kFormatter(subscribers);
				    jQuery('.social-subscribe .social-count').append(subscribers).digits();
				  }
				});
				//Function to add commas to the thousandths
				jQuery.fn.digits = function(){
				  return this.each(function(){
				    jQuery(this).text( jQuery(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') );
				  })
				}
				//Function to add K to thousands
				function kFormatter(num) {
				  return num > 999 ? (num/1000).toFixed(1) + 'k' : num;
				}
				</script>";
			$shortcode .= '</div>';
			return $shortcode;
}
add_shortcode('social', 'social');
?>
