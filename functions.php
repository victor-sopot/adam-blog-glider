<?php

wp_deregister_script( 'jquery' );
wp_enqueue_script( 'jquery', 'http://code.jquery.com/jquery-latest.js' );

// Add the effects
wp_enqueue_script( 'jquery-ui-effects-core', 'http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.core.js', array( 'jquery' ) );
wp_enqueue_script( 'jquery-ui-effects-slide', 'http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.slide.js', array( 'jquery', 'jquery-ui-effects-core' ) );

function register_my_menus()
{
    register_nav_menu('header-menu',__( 'Header Menu' ));
    register_nav_menu('portfolio-menu',__( 'Portfolio Menu' ));

}

add_action( 'init', 'register_my_menus' );

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'portfolio_item',
    array(
      'labels' => array(
        'name' => __( 'Project' ),
        'singular_name' => __( 'Projects' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}

// Show portfolio items on home page
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'portfolio_item' ) );
  return $query;
}

function glider_widgets_init() {

	register_sidebar( array(
		'name' => 'Footer',
		'id' => 'footer',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
	) );
}
add_action( 'widgets_init', 'glider_widgets_init' );

function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
     
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);


?>