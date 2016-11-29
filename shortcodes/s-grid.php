<?php
function grid( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'posttype' => 'post',
			'order' => '',
			'orderby' => '',
			'include' => '',
			'exclude' => '',
			'category' => '',
			'tag' => '',
			'class' => '',
			'type' => '1',
			'offset'=> '',
			'title_type'=> 'off',
			'title'=> 'Title',
			), $atts));

			global $exclude_single_id, $post;
      if (is_single()) { $exclude = $exclude_single_id; }

			else {
				$paged = "";
			}
	$item_nr = "4";
	if($type=="2") { $item_nr = "2"; }
	if($type=="3") { $item_nr = "3"; }

			$args = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>$orderby,
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);

			$args_popular = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>"meta_value_num",
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'meta_key' => 'magazin_post_views_count',
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);
			$args_shares = array(
				'post_type'=>$posttype,
				'order'=>$order,
				'orderby'=>"meta_value_num",
				'include'=>$include,
				'exclude'=>$exclude,
				'posts_per_page'=>$item_nr,
				'offset'=>$offset,
				'meta_key' => 'magazin_share_count_real',
				'category_name'=>$category,
				'paged' => $paged,
				'tag'=>$tag
			);


			if ($orderby == "popular") {
				$the_query = new WP_Query( $args_popular );
			}
			else if ($orderby == "shares") {
				$the_query = new WP_Query( $args_shares );
			}
			else {
				$the_query = new WP_Query( $args );
			}

			$shortcode = '';
			$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
			$shares = "0";
			if (!empty($share)){
				$shares = $share;
			}
      global $post;
			if($title_type=="center" and $title != ""){ $shortcode .= '<h2 class="heading"><span>'.$title.'</span></h2>'; }
			if($title_type=="left" and $title != ""){ $shortcode .= '<h2 class="heading heading-left"><span>'.$title.'</span></h2>'; }
			if($title_type=="right" and $title != ""){ $shortcode .= '<h2 class="heading heading-right"><span>'.$title.'</span></h2>'; }

			if($the_query->have_posts()) {
				$shortcode .='<div>';

				if($type=="1"){
          $i=1;
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
						$share_real = get_post_meta(get_the_ID(), "magazin_share_count_real", true);
						$shares = $share_real;
						if (!empty($share)){
							$shares = $share+$share_real;
						}
						$view = get_post_meta(get_the_ID(), "magazin_view_count", true);
						$views = get_post_meta(get_the_ID(), "magazin_post_views_count", true);
						$viewes = $views + "0";
						if (!empty($view)){
							$viewes = $view + $views;
						}
						$attachment_id = get_post_thumbnail_id( get_the_ID() );
						$img_src = wp_get_attachment_image_url( $attachment_id );
						$img_srcset = wp_get_attachment_image_srcset( $attachment_id );
						$img_srcset_2 = wp_get_attachment_image_srcset( $attachment_id, "full" );

						$shortcode .='<div class="grid-post nr-'.$i.' style-1 '; if (has_post_format( 'video' )) { $shortcode .= ' video'; } $shortcode .='">';
							$shortcode .='<a href="'. get_the_permalink().'">';
								$shortcode .='<div class="wrap">';
		              if ( has_post_thumbnail() ) {  if($i==1) {
											$shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
		                }
		                if($i==2) {
		                  $shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
		                }
		                if($i==3) {
		                  $shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
		                }
		                if($i==4) {
		                  $shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
		                }
									}
								$shortcode .='</div>';
								$shortcode .='<div class="poster-cat"><span>';
									$category_name = get_the_category(get_the_ID());
									if(!empty($category_name[0])) { $shortcode .=''.$category_name[0]->name.''; }
									if(!empty($category_name[1])) { $shortcode .=', '.$category_name[1]->name.''; }
									if(!empty($category_name[2])) { $shortcode .=', '.$category_name[2]->name.''; }
								$shortcode .='</span></div>';

                $shortcode .='<div class="layouts">';
									$shortcode .='<h2>'. get_the_title() .'</h2>';
										$shortcode .='<div class="post-info">';
                      $shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazin") .'</span>';
                      $shortcode .='<span class="poster-views">'. $viewes .' views</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';

									$shortcode .='</div>';
								$shortcode .='</a>';
							$shortcode .='<div class="clearfix"></div>';
						$shortcode .='</div>';

            $i++;
					endwhile;
				}

				if($type=="2"){
					$i=1;
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
						$share_real = get_post_meta(get_the_ID(), "magazin_share_count_real", true);
						$shares = $share_real;
						if (!empty($share)){
							$shares = $share+$share_real;
						}
						$view = get_post_meta(get_the_ID(), "magazin_view_count", true);
						$views = get_post_meta(get_the_ID(), "magazin_post_views_count", true);
						$viewes = $views + "0";
						if (!empty($view)){
							$viewes = $view + $views;
						}
						$attachment_id = get_post_thumbnail_id( get_the_ID() );
						$img_src = wp_get_attachment_image_url( $attachment_id );
						$img_srcset = wp_get_attachment_image_srcset( $attachment_id);
						$img_srcset_2 = wp_get_attachment_image_srcset( $attachment_id);

						$shortcode .='<div class="grid-post nr-'.$i.' style-2 '; if (has_post_format( 'video' )) { $shortcode .= ' video'; } $shortcode .='">';
							$shortcode .='<a href="'. get_the_permalink().'">';
								$shortcode .='<div class="wrap">';
									if ( has_post_thumbnail() ) {
											$shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
									}
								$shortcode .='</div>';
								$shortcode .='<div class="poster-cat"><span>';
									$category_name = get_the_category(get_the_ID());
									if(!empty($category_name[0])) { $shortcode .=''.$category_name[0]->name.''; }
									if(!empty($category_name[1])) { $shortcode .=', '.$category_name[1]->name.''; }
									if(!empty($category_name[2])) { $shortcode .=', '.$category_name[2]->name.''; }
								$shortcode .='</span></div>';

								$shortcode .='<div class="layouts">';

									$shortcode .='<h2>'. get_the_title() .'</h2>';

										$shortcode .='<div class="post-info">';
											$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazin") .'</span>';
											$shortcode .='<span class="poster-views">'. $viewes .' views</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';


									$shortcode .='</div>';

									$shortcode .='</a>';

							$shortcode .='<div class="clearfix"></div>';
						$shortcode .='</div>';


						$i++;
					endwhile;
				}

				if($type=="3"){
					$i=1;
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$share = get_post_meta(get_the_ID(), "magazin_share_count", true);
						$share_real = get_post_meta(get_the_ID(), "magazin_share_count_real", true);
						$shares = $share_real;
						if (!empty($share)){
							$shares = $share+$share_real;
						}
						$view = get_post_meta(get_the_ID(), "magazin_view_count", true);
						$views = get_post_meta(get_the_ID(), "magazin_post_views_count", true);
						$viewes = $views + "0";
						if (!empty($view)){
							$viewes = $view + $views;
						}
						$attachment_id = get_post_thumbnail_id( get_the_ID() );
						$img_src = wp_get_attachment_image_url( $attachment_id );
						$img_srcset = wp_get_attachment_image_srcset( $attachment_id );
						$img_srcset_2 = wp_get_attachment_image_srcset( $attachment_id, "full" );

						$shortcode .='<div class="grid-post nr-'.$i.' style-3 '; if (has_post_format( 'video' )) { $shortcode .= ' video'; } $shortcode .='">';
							$shortcode .='<a href="'. get_the_permalink().'">';
								$shortcode .='<div class="wrap">';
									if ( has_post_thumbnail() ) {
											$shortcode .='<div class="lazyload mt-post-image"  data-bg="'. get_the_post_thumbnail_url(get_the_ID(),'magazin_585').'" ></div>';
									}
								$shortcode .='</div>';
								$shortcode .='<div class="poster-cat"><span>';
									$category_name = get_the_category(get_the_ID());
									if(!empty($category_name[0])) { $shortcode .=''.$category_name[0]->name.''; }
									if(!empty($category_name[1])) { $shortcode .=', '.$category_name[1]->name.''; }
									if(!empty($category_name[2])) { $shortcode .=', '.$category_name[2]->name.''; }
								$shortcode .='</span></div>';

								$shortcode .='<div class="layouts">';

									$shortcode .='<h2>'. get_the_title() .'</h2>';

										$shortcode .='<div class="post-info">';
											$shortcode .='<span class="poster-shares">'. $shares .' '. esc_html__("shares", "magazin") .'</span>';
											$shortcode .='<span class="poster-views">'. $viewes .' views</span>';
											if (get_comments_number()!="0") { $shortcode .='<span class="poster-comments">'.get_comments_number().'</span>'; }
										$shortcode .='</div>';


									$shortcode .='</div>';

									$shortcode .='</a>';

							$shortcode .='<div class="clearfix"></div>';
						$shortcode .='</div>';


						$i++;
					endwhile;
				}

				$shortcode .='</div>';
			}

			wp_reset_postdata();
			return $shortcode;
}
add_shortcode('grid', 'grid');
?>
