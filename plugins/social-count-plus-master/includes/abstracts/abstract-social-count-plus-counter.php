<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Social Count Plus Counter.
 *
 * @package  Social_Count_Plus/Abstracts
 * @category Abstract
 * @author   Claudio Sanches
 */
abstract class Social_Count_Plus_Counter {

	/**
	 * Total count.
	 *
	 * @var int
	 */
	protected $total = 0;

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * Connection.
	 *
	 * @var WP_Error|array
	 */
	protected $connection = array();

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return false;
	}

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		return $this->total;
	}

	/**
	 * Get the li element.
	 *
	 * @param  string $url      Item url.
	 * @param  int    $count    Item count.
	 * @param  string $label    Item label.
	 * @param  array  $settings Item settings.
	 *
	 * @return string           HTML li element.
	 */
	protected function get_view_li( $url, $count, $label, $color, $settings ) {
		$target_blank = isset( $settings['target_blank'] ) ? ' target="_blank"' : '';
		$rel_nofollow = isset( $settings['rel_nofollow'] ) ? ' rel="nofollow"' : '';
		if ($this->id == "youtube") {
			if ( false == get_theme_mod( 't_s_subscribe', false ) ) { $t_s_follow = esc_html__("Subscribe us on", "magazine-plug");  } else { $t_s_follow = get_theme_mod( 't_s_subscribe' ); }
		} else {
			if ( false == get_theme_mod( 't_s_follow', false ) ) { $t_s_follow = esc_html__("Follow us on", "magazine-plug");  } else { $t_s_follow = get_theme_mod( 't_s_follow' ); }
		}
		if ($this->id == "youtube") {
			$name = "YouTube";
		} else if ($this->id == "facebook") {
			$name = "Facebook";
		} else if ($this->id == "twitter") {
			$name = "Twitter";
		} else if ($this->id == "linkedin") {
			$name = "LinkedIn";
		} else if ($this->id == "pinterest") {
			$name = "Pinterest";
		} else if ($this->id == "instagram") {
			$name = "Instagram";
		} else if ($this->id == "vimeo") {
			$name = "Vimeo";
		} else if ($this->id == "tumblr") {
			$name = "Tumblr";
		} else if ($this->id == "steam") {
			$name = "Steam";
		} else if ($this->id == "twitch") {
			$name = "Twitch";
		} else if ($this->id == "github") {
			$name = "GitHub";
		} else if ($this->id == "soundcloud") {
			$name = "SoundCloud";
		} else {
			$name = $this->id;
		}
		$html = "";
			$html .= sprintf( '<a class="social-%s mt-radius" href="%s"%s%s>',$this->id , esc_url( $url ), $target_blank, $rel_nofollow );
				$html .= sprintf( '<span class="social-count">%s</span>', number_format(apply_filters( 'social_count_plus_number_format', $count ) ));
				$html .= sprintf( '<span class="social-text %s">%s <strong>%s</strong></span>', apply_filters( 'social_count_plus_label', $label ), $t_s_follow, $name );
		$html .= '</a>';

		return $html;
	}

	/**
	 * Get conter view.
	 *
	 * @param  array  $settings   Plugin settings.
	 * @param  int    $total      Counter total.
	 * @param  string $text_color Text color.
	 *
	 * @return string
	 */
	public function get_view( $settings, $total, $text_color ) {
		return '';
	}

	/**
	 * Debug.
	 *
	 * @return array
	 */
	public function debug() {
		return $this->connection;
	}
}
