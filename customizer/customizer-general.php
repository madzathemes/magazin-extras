<?php
function magazin_customize_general($wp_customize){


  $wp_customize->add_panel( 'magazin_general', array(
    'priority'       => 300,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'    	=> esc_html__('General', 'magazin'),
    'description'    => '',
  ));

  $wp_customize->add_section('css_settings', array(
    'title'    	=> esc_html__('Custom CSS', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  Kirki::add_field( 'custom_css', array(
      'type'        => 'code',
    	'settings'    => 'custom_css',
    	'label'       => esc_html__( 'Custom CSS', 'magazin' ),
    	'section'     => 'css_settings',
    	'default'     => 'body { background: #fff; }',
    	'priority'    => 10,
      'option_type' => 'option',
    	'choices'     => array(
    		'language' => 'css',
    		'theme'    => 'monokai',
    		'height'   => 250,
    	),
  ) );

  $wp_customize->add_section('performance', array(
    'title'    	=> esc_html__('Performance', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  Kirki::add_field( 'sticky_sidebar', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'sticky_sidebar',
    'label'       => esc_html__( 'Sticky Sidebar', 'magazin' ),
    'section'     => 'performance',
    'default'     => '1',
    'priority'    => 1,
    'option_type'           => 'option',
    'choices'     => array(
      '1'   => esc_attr__( 'ON', 'magazin' ),
      '2' => esc_attr__( 'OFF', 'magazin' ),
    ),
 ));

 Kirki::add_field( 'carousel_autoplay', array(
   'type'        => 'radio-buttonset',
   'settings'    => 'carousel_autoplay',
   'label'       => esc_html__( 'Carousel Autoplay', 'magazin' ),
   'section'     => 'performance',
   'default'     => '1',
   'priority'    => 1,
   'option_type'           => 'option',
   'choices'     => array(
     '1'   => esc_attr__( 'ON', 'magazin' ),
     '2' => esc_attr__( 'OFF', 'magazin' ),
   ),
));






  $wp_customize->add_section('social_widget', array(
    'title'    	=> esc_html__('Social Widget Settings', 'magazin'),
    'panel'  => 'magazin_general'
  ));

  $wp_customize->add_setting('facebook_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('facebook_username', array(
      'label'    	=> esc_html__('Facebook username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'facebook_username',
  ));

  $wp_customize->add_setting('facebook_token', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('facebook_token', array(
      'label'    	=> esc_html__('Facebook token', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'facebook_token',
  ));

  $wp_customize->add_setting('twitter_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('twitter_username', array(
      'label'    	=> esc_html__('Twitter username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'twitter_username',
  ));

  $wp_customize->add_setting('youtube_username', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'option',
      'sanitize_callback' => 'esc_attr',
  ));
  $wp_customize->add_control('youtube_username', array(
      'label'    	=> esc_html__('YouTube username', 'magazin'),
      'section'    => 'social_widget',
      'settings'   => 'youtube_username',
  ));




}

add_action('customize_register', 'magazin_customize_general');
?>
