<?php 
/**
 * All functions and hooks for jigoshop plugin  
 *
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.4
 */          
 
// global flag to know that woocommerce is active
$yiw_is_woocommerce = true; 
 
include 'shortcodes-woocommerce.php';   

remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
add_action( 'woocommerce_before_main_content' , create_function( '', 'if ( ! is_single() ) woocommerce_catalog_ordering();' ) );

// add the sale icon inside the product detail image container
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash');   

// active the price filter
add_action('init', 'woocommerce_price_filter_init');
add_filter('loop_shop_post_in', 'woocommerce_price_filter');      
   
// add body class
add_filter( 'body_class', create_function( '$classes', '$classes[] = "shop-".yiw_get_option( "shop_products_style", "ribbon" ); return $classes;' ) ); 

// remove the add to cart option
function yiw_remove_add_to_cart() {
    if ( yiw_get_option('shop_show_button_add_to_cart_single_page') ) return;
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}
add_action('init', 'yiw_remove_add_to_cart');

// since woocommerce 1.6 - add the style to <ul> products list
function yiw_add_style_products_list( $content ) {
    return str_replace( '<ul class="products">', '<ul class="products ' . yiw_get_option( 'shop_products_style', 'ribbon' ) . '">', $content );    
}
add_filter( 'the_content', 'yiw_add_style_products_list', 99 );

// add image size for the product categories in woocommerce api
add_filter( 'woocommerce_get_image_size_shop_category_image_width',  create_function( '', 'return get_option("woocommerce_category_image_width");' ) );
add_filter( 'woocommerce_get_image_size_shop_category_image_height', create_function( '', 'return get_option("woocommerce_category_image_height");' ) );

function yiw_set_posts_per_page( $cols ) {        
    $items = yiw_get_option( 'shop_products_per_page', $cols );         
    return $items == 0 ? -1 : $items;
}
add_filter('loop_shop_per_page', 'yiw_set_posts_per_page');

function yiw_add_style_woocommerce() {
    wp_enqueue_style( 'jquery-ui-style', (is_ssl()) ? 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' : 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
}
add_action( 'init', 'yiw_add_style_woocommerce' );

function yiw_add_to_cart_success_ajax( $datas ) {
    global $woocommerce;       
	
	// quantity
	$qty = 0;
	if (sizeof($woocommerce->cart->get_cart())>0) : foreach ($woocommerce->cart->get_cart() as $item_id => $values) :
	
		$qty += $values['quantity'];  
	
	endforeach; endif;                     
	
	if ( $qty == 1 )
	   $label = __( 'item', 'yiw' );
	else             
	   $label = __( 'items', 'yiw' );
	
	ob_start();
	echo '<ul class="cart_list product_list_widget hide_cart_widget_if_empty">';
	if (sizeof($woocommerce->cart->get_cart())>0) : 
		foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
			$_product = $cart_item['data'];
			if ($_product->exists() && $cart_item['quantity']>0) :
				echo '<li><a href="'.get_permalink($cart_item['product_id']).'">';
				
				echo $_product->get_image();
				
				echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a>';
				
   				echo $woocommerce->cart->get_item_data( $cart_item );
				
				echo '<span class="quantity">' .$cart_item['quantity'].' &times; '.woocommerce_price($_product->get_price()).'</span></li>';
			endif;
		endforeach; 
	else: 
		echo '<li class="empty">'.__('No products in the cart.', 'woocommerce').'</li>'; 
	endif;
	echo '</ul>';
	if ($qty == 1) :
		echo '<p class="total"><strong>' . __('Subtotal', 'woocommerce') . ':</strong> '. $woocommerce->cart->get_cart_total() . '</p>';
			
		do_action( 'woocommerce_widget_shopping_cart_before_buttons' );
			
		echo '<p class="buttons"><a href="'.$woocommerce->cart->get_cart_url().'" class="button">'.__('View Cart &rarr;', 'woocommerce').'</a> <a href="'.$woocommerce->cart->get_checkout_url().'" class="button checkout">'.__('Checkout &rarr;', 'woocommerce').'</a></p>';
	endif;
    $widget = ob_get_clean();
		
    //$datas['span.minicart'] = '<span class="minicart">' . $qty . ' ' . $label . '</span>';
    $datas['.widget_shopping_cart .product_list_widget'] = $widget;  
    $datas['.widget_shopping_cart .total .amount'] = $woocommerce->cart->get_cart_total();  
    $datas['#cart'] = '<div id="cart">' . yiw_minicart(false) . '</div>';  
    
    return $datas;
}
add_filter( 'add_to_cart_fragments', 'yiw_add_to_cart_success_ajax' );

function yiw_woocommerce_javascript_scripts() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){   
        $('body').bind('added_to_cart', function(){
            $('.add_to_cart_button.added').text('ADDED');
        });               
    });
    </script>
    <?php
}
add_action( 'wp_head', 'yiw_woocommerce_javascript_scripts' );


/** SHOP
-------------------------------------------------------------------- */

// decide the layout for the shop pages
function yiw_shop_layouts( $default_layout ) {
    $is_shop_page = ( get_option('woocommerce_shop_page_id') != false ) ? is_page( get_option('woocommerce_shop_page_id') ) : false;
    if ( is_tax('product_cat') || is_post_type_archive('product') || $is_shop_page )
        return YIW_DEFAULT_LAYOUT_PAGE_SHOP;    
    else
        return $default_layout;
}
add_filter( 'yiw_layout_page', 'yiw_shop_layouts' );

// generate the main width for content and sidebar
function yiw_layout_widths() {
    global $content_width, $post;
    
    $sidebar = YIW_SIDEBAR_WIDTH;
    
    $post_id = isset( $post->ID ) ? $post->ID : 0;
    
    if ( ! is_search() && get_post_type() == 'product' || get_post_meta( $post_id, '_sidebar_choose_page', true ) == 'Shop Sidebar' )
        $sidebar = YIW_SIDEBAR_SHOP_WIDTH;
    
    $content_width = YIW_MAIN_WIDTH - ( $sidebar + 40 );
    
    ?>
        #content { width:<?php echo $content_width ?>px; }
        #sidebar { width:<?php echo $sidebar ?>px; }        
        #sidebar.shop { width:<?php echo YIW_SIDEBAR_SHOP_WIDTH ?>px; }
    <?php
}
//add_action( 'yiw_custom_styles', 'yiw_layout_widths' );

function yiw_minicart( $echo = true ) {
    global $woocommerce;
    
    ob_start();
	
	// quantity
	$qty = 0;
	if (sizeof($woocommerce->cart->get_cart())>0) : foreach ($woocommerce->cart->get_cart() as $item_id => $values) :
	
		$qty += $values['quantity'];
	
	endforeach; endif;
	
	if ( $qty == 1 )
	   $label = __( 'item', 'yiw' );
	else             
	   $label = __( 'items', 'yiw' );  ?>
	   
	<a class="widget_shopping_cart trigger" href="<?php echo $woocommerce->cart->get_cart_url() ?>">
		<span class="minicart"><?php echo $qty ?> <?php echo $label ?> </span>
	</a>
	
	<?php if ( yiw_get_option('topbar_cart_ribbon_hover') ) : ?>
	<div class="quick-cart">
    	<ul class="cart_list product_list_widget"><?php
    	
    	if (sizeof($woocommerce->cart->get_cart())>0) :
            foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product = $cart_item['data'];
				if ($_product->exists() && $cart_item['quantity']>0) : ?>
				    <li>
                        <a href="<?php echo get_permalink($cart_item['product_id']) ?>"><?php echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product) ?></a>
                        <span class="price"><?php echo woocommerce_price($_product->get_price()); ?></span>
                    </li><?php
				endif;
            endforeach;
        else : ?>
            <li class="empty"><?php _e('No products in the cart.', 'woocommerce') ?></li><?php
        endif;   
    	
    	if (sizeof($woocommerce->cart->get_cart())>0) : ?>
    	   <li class="totals"><?php _e( 'Subtotal', 'yiw' ) ?><span class="price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></li><?php
    	endif; ?>
    	
    	   <li class="view-cart-button"><a class="view-cart-button" href="<?php echo get_permalink( get_option('woocommerce_cart_page_id') ); ?>"><?php _e( apply_filters( 'yiw_topbar_minicart_view_cart', 'View cart' ), 'yiw' ) ?></a></li>
    	
    	</ul>
    	
    </div><?php
    endif;
    
    $html = ob_get_clean();
    
    if ( $echo )
        echo $html;
    else
        return $html;
}     

// Decide if show the price and/or the button add to cart, on the product detail page
function yiw_remove_ecommerce() {
    if ( ! yiw_get_option( 'shop_show_button_add_to_cart_single_page', 1 ) )                         
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); 
    if ( ! yiw_get_option( 'shop_show_price_single_page', 1 ) )                       
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
}
add_action( 'wp_head', 'yiw_remove_ecommerce', 1 );

/**
 * LAYOUT
 */
function yiw_shop_layout_pages_before() {
    $layout = yiw_layout_page();
    if ( get_post_type() == 'product' && is_tax( 'product-category' ) )
        $layout = 'sidebar-no';          
    elseif ( get_post_type() == 'product' && is_single() )          
        $layout = yiw_get_option( 'shop_layout_page_single', 'sidebar-no' ); 
    elseif ( get_post_type() == 'product' && ! is_single() )
        $layout = ( $l=get_post_meta( get_option( 'woocommerce_shop_page_id' ), '_layout_page', true )) ? $l : YIW_DEFAULT_LAYOUT_PAGE;  
    ?><div id="primary" class="layout-<?php echo $layout ?> group">
        <div class="inner group"><?php    
    
    if ( $layout == 'sidebar-no' ) {
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
        add_filter('loop_shop_columns', create_function('$columns', 'return $columns+1;'));
    }
} 

function yiw_shop_layout_pages_after() {
    ?></div></div><?php    
}                                                                   
  
add_action( 'woocommerce_before_main_content', 'yiw_shop_layout_pages_before', 1 );
add_action( 'woocommerce_sidebar', 'yiw_shop_layout_pages_after', 99 );
                    
/**
 * SIZES
 */ 

// shop small
function yiw_shop_small_w() { global $woocommerce; return $woocommerce->get_image_size('shop_catalog_image_width'); }	
function yiw_shop_small_h() { global $woocommerce; return $woocommerce->get_image_size('shop_catalog_image_height'); }   
// shop thumbnail
function yiw_shop_thumbnail_w() { global $woocommerce; return $woocommerce->get_image_size('shop_thumbnail_image_width'); }	
function yiw_shop_thumbnail_h() { global $woocommerce; return $woocommerce->get_image_size('shop_thumbnail_image_height'); } 
// shop large
function yiw_shop_large_w() { global $woocommerce; return $woocommerce->get_image_size('shop_single_image_width'); }	
function yiw_shop_large_h() { global $woocommerce; return $woocommerce->get_image_size('shop_single_image_height'); }   
// category image
function yiw_shop_category_w() { global $woocommerce; return $woocommerce->get_image_size('shop_category_image_width'); }	
function yiw_shop_category_h() { global $woocommerce; return $woocommerce->get_image_size('shop_category_image_height'); }  
	
/**
 * Init images
 */
function yiw_image_sizes() {
    global $woocommerce;
    
	// Image sizes
	$shop_category_crop 	= (get_option('woocommerce_category_image_crop')==1) ? true : false;

	add_image_size( 'shop_category', $woocommerce->get_image_size('shop_category_image_width'), $woocommerce->get_image_size('shop_category_image_height'), $shop_category_crop );
} 
add_action( 'woocommerce_init', 'yiw_image_sizes' );

// print style for small thumb size
function yiw_size_images_style() {
	?>
	.shop-traditional .products li { width:<?php echo yiw_shop_small_w() + ( yiw_get_option( 'shop_border_thumbnail' ) ? 14 : 0 ) ?>px !important; }
	.products li a strong { width:<?php echo yiw_shop_small_w() - 40 ?>px !important; }
	/*..shop-traditional .products li a img { width:<?php echo yiw_shop_small_w() ?>px !important; }  removed for the category images */
	div.product div.images { width:<?php echo ( yiw_shop_large_w() + 14 ) / 720 * 100 ?>%; }
	.layout-sidebar-no div.product div.images { width:<?php echo ( yiw_shop_large_w() + 14 ) / 960 * 100 ?>%; }
	div.product div.images img { width:<?php echo yiw_shop_large_w() ?>px; }
	.layout-sidebar-no div.product div.summary { width:<?php echo ( 960 - ( yiw_shop_large_w() + 14 ) - 20 ) / 960 * 100 ?>%; }
	.layout-sidebar-right div.product div.summary, .layout-sidebar-left div.product div.summary { width:<?php echo ( 720 - ( yiw_shop_large_w() + 14 ) - 20 ) / 720 * 100 ?>%; }
	.layout-sidebar-no .product.hentry > span.onsale { right:<?php echo 960 - ( yiw_shop_large_w() + 14 ) - 10 ?>px; left:auto; }
	.layout-sidebar-right .product.hentry > span.onsale, .layout-sidebar-left .product.hentry > span.onsale { right:<?php echo 720 - ( yiw_shop_large_w() + 14 ) - 10 ?>px; left:auto; }     
	<?php
}
add_action( 'yiw_custom_styles', 'yiw_size_images_style' );

/**
 * PRODUCT PAGE
 */     
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60);

function woocommerce_output_related_products() {
    echo '<div id="related-products">';
    echo '<h3>', __( 'Related Products', 'yiw' ), '</h3>';
    $cols = yiw_layout_page() == 'sidebar-no' ? 5 : 4;
    woocommerce_related_products( apply_filters('related_products_posts_per_page', $cols), apply_filters('related_products_columns', $cols) );
    echo '</div>';
}                   

// number of products
function yiw_items_list_pruducts() {
    return 8;
}
//add_filter( 'loop_shop_per_page', 'yiw_items_list_pruducts' );



/** NAV MENU
-------------------------------------------------------------------- */

add_action('admin_init', array('yiwProductsPricesFilter', 'admin_init'));

class yiwProductsPricesFilter {
	// We cannot call #add_meta_box yet as it has not been defined,
    // therefore we will call it in the admin_init hook
	function admin_init() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) || basename($_SERVER['PHP_SELF']) != 'nav-menus.php' ) 
			return;
			                                                    
		wp_enqueue_script('nav-menu-query', get_template_directory_uri() . '/inc/admin_scripts/metabox_nav_menu.js', 'nav-menu', false, true);
		add_meta_box('products-by-prices', 'Prices Filter', array(__CLASS__, 'nav_menu_meta_box'), 'nav-menus', 'side', 'low');
	}

	function nav_menu_meta_box() { ?>
	<div class="prices">        
		<input type="hidden" name="woocommerce_currency" id="woocommerce_currency" value="<?php echo get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ?>" />
		<input type="hidden" name="woocommerce_shop_url" id="woocommerce_shop_url" value="<?php echo get_option('permalink_structure') == '' ? site_url() . '/?post_type=product' : get_permalink( get_option('woocommerce_shop_page_id') ) ?>" />
		<input type="hidden" name="menu-item[-1][menu-item-url]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-title]" value="" />
		<input type="hidden" name="menu-item[-1][menu-item-type]" value="custom" />
		
		<p>
		    <?php _e( sprintf( 'The values are already expressed in %s', get_woocommerce_currency_symbol( get_option('woocommerce_currency') ) ), 'yiw' ) ?>
		</p>
		
		<p>
			<label class="howto" for="prices_filter_from">
				<span><?php _e('From'); ?></span>
				<input id="prices_filter_from" name="prices_filter_from" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('From'); ?>" />
			</label>
		</p>

		<p style="display: block; margin: 1em 0; clear: both;">
			<label class="howto" for="prices_filter_to">
				<span><?php _e('To'); ?></span>
				<input id="prices_filter_to" name="prices_filter_to" type="text" class="regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('To'); ?>" />
			</label>
		</p>

		<p class="button-controls">
			<span class="add-to-menu">
				<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				<input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" />
			</span>
		</p>

	</div>
<?php
	}
}     

/**
 * Add 'On Sale Filter to Product list in Admin
 */
add_filter( 'parse_query', 'on_sale_filter' );
function on_sale_filter( $query ) {
    global $pagenow, $typenow, $wp_query;

    if ( $typenow=='product' && isset($_GET['onsale_check']) && $_GET['onsale_check'] ) :

        if ( $_GET['onsale_check'] == 'yes' ) :
            $query->query_vars['meta_compare']  =  '>';
            $query->query_vars['meta_value']    =  0;
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

        if ( $_GET['onsale_check'] == 'no' ) :
            $query->query_vars['meta_value']    = '';
            $query->query_vars['meta_key']      =  '_sale_price';
        endif;

    endif;
}

add_action('restrict_manage_posts','woocommerce_products_by_on_sale');
function woocommerce_products_by_on_sale() {
    global $typenow, $wp_query;
    if ( $typenow=='product' ) :

        $onsale_check_yes = '';
        $onsale_check_no  = '';

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'yes' ) :
            $onsale_check_yes = ' selected="selected"';
        endif;

        if ( isset( $_GET['onsale_check'] ) && $_GET['onsale_check'] == 'no' ) :
            $onsale_check_no = ' selected="selected"';
        endif;

        $output  = "<select name='onsale_check' id='dropdown_onsale_check'>";
        $output .= '<option value="">'.__('Show all products (Sale Filter)', 'woothemes').'</option>';
        $output .= '<option value="yes"'.$onsale_check_yes.'>'.__('Show products on sale', 'woothemes').'</option>';
        $output .= '<option value="no"'.$onsale_check_no.'>'.__('Show products not on sale', 'woothemes').'</option>';
        $output .= '</select>';

        echo $output;

    endif;
}


// ADD IMAGE CATEGORY OPTION
function yiw_add_cateogry_image_size( $options ) {
    $tmp = $options[ count($options)-1 ];
    unset( $options[ count($options)-1 ] );
    
    $options[] = array(  
		'name' => __( 'Category Thumbnails', 'woocommerce' ),
		'desc' 		=> __('This size is usually used for the category list on the product page.', 'woocommerce'),
		'id' 		=> 'woocommerce_category_image',
		'css' 		=> '',
		'type' 		=> 'image_width',
		'std' 		=> '225',
		'desc_tip'	=>  true,
	);      
	
	$options[] = $tmp;
                        
    return $options;   
}
add_filter( 'woocommerce_catalog_settings', 'yiw_add_cateogry_image_size' );

function woocommerce_subcategory_thumbnail( $category  ) {
	global $woocommerce;

	$small_thumbnail_size  = apply_filters( 'single_product_small_thumbnail_size', 'shop_category' );
	$image_width     = $woocommerce->get_image_size( 'shop_category_image_width' );
	$image_height    = $woocommerce->get_image_size( 'shop_category_image_height' );

	$thumbnail_id  = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

	if ( $thumbnail_id ) {
		$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
		$image = $image[0];
	} else {
		$image = woocommerce_placeholder_img_src();
	}

	echo '<img src="' . $image . '" alt="' . $category->name . '" width="' . $image_width . '" height="' . $image_height . '" />';
}