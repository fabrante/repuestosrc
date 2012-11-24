<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0
 */             
 global $yiw_mobile;
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if ( ! $yiw_mobile->isIpad() ) : ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<?php endif ?>
<title><?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );
    
    // Add description, if is home
    if ( is_home() || is_front_page() )
        echo ' | ' . get_bloginfo( 'description' );

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'yiw' ), max( $paged, $page ) );

    ?></title>          
    
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />                              
	
	<?php if ( yiw_get_option( 'responsive', 1 ) ) : ?>
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 960px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen960.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 600px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen600.css" />
	<link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="<?php echo get_template_directory_uri(); ?>/css/lessthen480.css" />
	<?php endif; ?>
    
    <?php
        // styles 
        wp_enqueue_style( 'prettyPhoto',  get_template_directory_uri()."/css/prettyPhoto.css" );  
        wp_enqueue_style( 'tipsy',        get_template_directory_uri()."/core/includes/css/tipsy.css" );
        wp_enqueue_style( 'flexslider',   get_template_directory_uri()."/css/flexslider.css" );  

        // scripts    
        wp_enqueue_script( 'jquery-easing' );
        wp_enqueue_script( 'jquery-prettyPhoto' );
        wp_enqueue_script( 'jquery-tipsy' );  
        wp_enqueue_script( 'jquery-tweetable' );           
        wp_enqueue_script( 'jquery-nivo' ); 
        wp_enqueue_script( 'jquery-cycle' );    
        wp_enqueue_script( 'jquery-jcarousel' );
        wp_enqueue_script( 'jquery-mobilemenu', get_template_directory_uri().'/js/jquery.mobilemenu.js', array('jquery') );   
        
        if( yiw_get_option( 'topbar_content' ) == 'twitter' ) {
            wp_enqueue_script( 'jquery-flexislider',        get_template_directory_uri()."/js/jquery.flexslider.min.js" );
        }    
        
        $slider_type = yiw_slider_type();    

        if( !in_array( $slider_type, array('none','fixed-image')) ) {

                if( !in_array( $slider_type, array('carousel')) )
                    wp_enqueue_style( 'slider-' . $slider_type,        get_template_directory_uri()."/css/slider-". $slider_type .".css" );  
            
                // cycle
                if ( $slider_type == 'cycle' ) {
                    wp_enqueue_script('swfobject');
                    
                } 
                
                // flash
		elseif ( $slider_type == 'flash' ){
                    wp_enqueue_script( 'swfobject' );
                }
                
                // thumbnails
                elseif ( $slider_type == 'thumbnails' ){
                    wp_enqueue_script( 'jquery-aw-showcases', get_template_directory_uri()."/js/jquery.aw-showcase.js" );
                }
                
                //unoslider
                elseif( $slider_type == 'unoslider' ) {    
                    $slider_theme = yiw_get_option( 'slider_' . $slider_type . '_theme' );                                
                    wp_enqueue_style( 'slider-' . $slider_type . '-', get_template_directory_uri()."/css/unoslider-themes/$slider_theme/theme.css" );  
                    wp_enqueue_script( 'unoslider', get_template_directory_uri()."/js/unoslider.js" );
                }   
	    
                // elastic
                elseif ( $slider_type == 'elastic' ) {                                                                                       
                    wp_enqueue_style( 'Playfair', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Playfair+Display:400italic' ); 
                    wp_enqueue_script( 'jquery-elastic', get_template_directory_uri()."/js/jquery.eislideshow.js", array('jquery'), '1.0' );   
                }                    
        }                             


        // custom
        wp_enqueue_script( 'jquery-custom',      get_template_directory_uri()."/js/jquery.custom.js", array('jquery'), '1.0', true); 
                                                                                
        if( yiw_get_option( 'font_type' ) == 'cufon' )
        {                      
            wp_enqueue_script('cufon');
            //wp_enqueue_script('cufon-' . $actual_font, get_template_directory_uri()."/fonts/{$actual_font}.font.js");   
        }    
                           
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if ( is_singular() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' );        
                                                                
        $body_class = '';
        if ( ( yiw_get_option( 'responsive', 1 ) && ! $GLOBALS['is_IE'] ) || ( yiw_get_option( 'responsive', 1 ) && yiw_ieversion() >= 9 ) )   
            $body_class = ' responsive';     
                                         
        if ( ! is_user_logged_in() )
            $body_class .= ' not-logged-in'; 
        
        global $post;
        $post_id = isset( $post->ID ) ? $post->ID : 0;
		
		$src = get_post_meta( $post_id, '_map_url', true );
        if ( get_post_meta( $post_id, '_show_map', true ) == 'yes' && ! empty( $src ) ) 
    		wp_localize_script( 'jquery-custom', 'header_map', array(
            	'tab_open'  => __( 'Open map', 'yiw' ),
            	'tab_close' => __( 'Close map', 'yiw' ),
            ) );
        
        
        wp_enqueue_style( 'custom-css', get_template_directory_uri().'/custom.css' );            
    ?>


    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php yiw_favicon(); ?>" />
    <link rel="icon" type="image/x-icon" href="<?php yiw_favicon(); ?>" />
    <!-- [favicon] end -->  
    
    <?php wp_head() ?>
</head>

<body <?php body_class( "no_js" . $body_class ) ?>>   
                             
    <!-- START SHADOW WRAPPER -->
    <div class="bg-shadow group">        
                             
        <!-- START WRAPPER -->
        <div class="wrapper group">        
            
            <!-- START HEADER -->
            <div id="header" class="group">   
        
                <!-- TOPBAR -->
                <?php get_template_part( 'topbar' ) ?>
                <!-- END TOPBAR -->  
                
                <div class="group inner">
                    <!-- START LOGO -->
                    <div id="logo" class="group">
                        <?php if( yiw_get_option( 'use_logo' ) ): ?>
                            <a href="<?php echo home_url() ?>" title="<?php bloginfo('name') ?>"> 
                                <?php $logo = yiw_get_option( 'logo' ) ? yiw_get_option( 'logo' ) : get_template_directory_uri() . '/images/logo.png'; ?>
                                <img src="<?php echo $logo  ?>" alt="Logo <?php bloginfo('name') ?>" <?php if(yiw_get_option('logo_width')): ?>width="<?php echo yiw_get_option('logo_width') ?>"<?php endif ?> <?php if(yiw_get_option('logo_height')): ?>height="<?php echo yiw_get_option('logo_height') ?>"<?php endif ?> />
                            </a>
                        <?php else: ?>
                            <a class="logo-text" href="<?php echo home_url() ?>" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a>
                        <?php endif ?>
                        <?php if ( yiw_get_option('logo_use_description') ) :  
                        
                            $description = get_bloginfo('description');
                            $description = str_replace( '[', '<strong>', $description );
                            $description = str_replace( ']', '</strong>', $description );
                            
                            echo '<p class="logo-description">', $description, '</p>';
                                                                                        
                        endif; ?>
                    </div>
                    <!-- END LOGO -->  
                    
                    <!-- START SEARCHFORM -->
                    <?php if ( yiw_get_option( 'show_searchform_header', 0 ) ) yiw_search_form( __( 'Search...', 'yiw' ), ' ', yiw_get_option( 'show_searchform_post_type', 'product' ) ); ?> 
                    <!-- END SEARCHFORM -->
                
                    <!-- START NAV -->
                    <div id="nav" class="group">
                        <?php  
                            $nav_args = array(
                                'theme_location' => 'nav',
                                'container' => 'none',
                                'menu_class' => 'level-1',
                                'depth' => 3,   
                                //'fallback_fb' => false,
                                //'walker' => new description_walker()
                            );
                            
                            wp_nav_menu( $nav_args ); 
                        ?>    
                    </div>
                    <!-- END NAV -->     
                </div>
            </div>   
            <!-- END HEADER -->
            
            <!-- SLIDER -->
            <?php get_template_part( 'slider' ); ?>
            <!-- /SLIDER -->                        
        	    
        	<?php get_template_part( 'map' ); ?> 