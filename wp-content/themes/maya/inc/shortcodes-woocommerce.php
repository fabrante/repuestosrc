<?php
/**
 * Additional shortcodes for the theme.
 * 
 * To create new shortcode, get for example the shortcode [sample] already written.
 * Replace it with your code for shortcode and for other shortcodes, duplicate the first
 * and continue following.
 * 
 * CONVENTIONS: 
 * - The name of function MUST be: yiw_sc_SHORTCODENAME_func.
 * - All html output of shortcode, must be passed by an hook: apply_filters( 'yiw_sc_SHORTCODENAME_html', $html ).
 * NB: SHORTCODENAME is the name of shortcode and must be written in lowercase.    
 * 
 * For example, we'll add new shortcode [sample], so:
 * - the function must be: yiw_sc_sample_func().
 * - the hooks to use will be: apply_filters( 'yiw_sc_sample_html', $html ).   
 * 
 * @package WordPress
 * @subpackage YIW Themes
 * @since 1.0 
 */                                          


/** 
 * BEST SELLERS 
 * 
 * @description
 *    show a box with best sellers
 * 
 * @example
 *   [best_sellers per_page="" columns=""]
 * 
 * @attr  
 *   title  - the title of the box
 *   description - the text below title  
**/
function yiw_sc_best_sellers_func($atts, $content = null) 
{
	global $woocommerce_loop;
	                            
	extract(shortcode_atts(array(
		'per_page' 	=> 12,
		'columns' 	=> 4
	), $atts));                            
	                         
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering' ); 
	
	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => $per_page,
		'meta_key' 		=> 'total_sales',
		'orderby' 		=> 'meta_value'
	);
	
	ob_start();
	
	$products = new WP_Query( $args );
	
	$woocommerce_loop['loop'] = 0;
	$woocommerce_loop['columns'] = $columns;

	if ( $products->have_posts() ) : ?>
		
		<ul class="products <?php echo yiw_get_option( 'shop_products_style', 'ribbon' ); ?>">
			
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
		
				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
	
			<?php endwhile; // end of the loop. ?>
				
		</ul>
		
	<?php endif; 

	wp_reset_query();             
      
	$woocommerce_loop['loop'] = 0;
	
	return apply_filters( 'yiw_sc_yiw_best_sellers_html', ob_get_clean() );        
}
add_shortcode('best_sellers', 'yiw_sc_best_sellers_func');                              


/** 
 * ITEMS 
 * 
 * @description
 *    show the products
 * 
 * @example
 *   [items per_page="" columns="" orderby="" order=""]
 * 
 * @attr  
 *   per_page  - the title of the box
 *   description - the text below title  
**/
function yiw_sc_items_func($atts){
	global $woocommerce_loop;
	
  	if (empty($atts)) return;
  
	extract(shortcode_atts(array(
		'columns' 	=> 12,
		'per_page' 	=> 4,
	  	'orderby'   => 'title',
	  	'order'     => 'asc'
		), $atts));
	
  	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'posts_per_page' => $per_page,
		'ignore_sticky_posts'	=> 1,
		'orderby' => $orderby,
		'order' => $order,
		'meta_query' => array(
			array(
				'key' 		=> '_visibility',
				'value' 	=> array('catalog', 'visible'),
				'compare' 	=> 'IN'
			)
		)
	);
	
	if(isset($atts['skus'])){
		$skus = explode(',', $atts['skus']);
	  	$skus = array_map('trim', $skus);
    	$args['meta_query'][] = array(
      		'key' 		=> '_sku',
      		'value' 	=> $skus,
      		'compare' 	=> 'IN'
    	);
  	}
	
	if(isset($atts['ids'])){
		$ids = explode(',', $atts['ids']);
	  	$ids = array_map('trim', $ids);
    	$args['post__in'] = $ids;
	}                 
    
    if(!empty( $category )) {
        $tax = 'product_cat';
        $category = array_map( 'trim', explode( ',', $category ) );
        if ( count($category) == 1 ) $category = $category[0];
        $args['tax_query'] = array(
            array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => $category
            )
        );
    }
	
	ob_start();
	
	$products = new WP_Query( $args );
	
	$woocommerce_loop['loop'] = 0;
	$woocommerce_loop['columns'] = $columns;

	if ( $products->have_posts() ) : ?>
		
		<ul class="products <?php echo yiw_get_option( 'shop_products_style', 'ribbon' ); ?>">
			
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
		
				<?php woocommerce_get_template_part( 'content', 'product' ); ?>
	
			<?php endwhile; // end of the loop. ?>
				
		</ul>
		
	<?php endif; 

	wp_reset_query();       
	                       
	$woocommerce_loop['loop'] = 0;
	
	return ob_get_clean();
}                  
add_shortcode('items', 'yiw_sc_items_func');   

/** 
 * ADD TO CART     
 * 
 * @description
 *    Add a simple add to cart of a product   
 * 
 * @example
 *   [add_to_cart id=""]
 * 
 * @attr                          
 *   id - the id of product
**/
function yiw_sc_add_to_cart_func($atts, $content = null) {      
  	if (empty($atts)) return;
  	
  	global $wpdb, $woocommerce, $post;
  	
  	if ($atts['id']) :
  		$product_data = get_post( $atts['id'] );
	elseif ($atts['sku']) :
		$product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $atts['sku']));
		$product_data = get_post( $product_id );
	else :
		return;
	endif;
	
	if ($product_data->post_type!=='product') return;
	
	$product = $woocommerce->setup_product_data( $product_data );
		
	if (!$product->is_visible()) continue; 
	
	ob_start();
	
	// do not show "add to cart" button if product's price isn't announced
	if( $product->get_price() === '') return;
	
	switch ($product->product_type) :
		case "variable" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('variable_add_to_cart_text', __('Select options', 'woocommerce'));
		break;
		case "grouped" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('grouped_add_to_cart_text', __('View options', 'woocommerce'));
		break;
		case "external" :
			$link 	= get_permalink($post->ID);
			$label 	= apply_filters('external_add_to_cart_text', __('Read More', 'woocommerce'));
		break;
		default :
			$link 	= esc_url( $product->add_to_cart_url() );
			$label 	= apply_filters('add_to_cart_text', yiw_get_option( 'shop_button_addtocart_label', __('Add to cart', 'woocommerce')));
		break;
	endswitch;
	
	?><a href="<?php echo $link; ?>" class="button"><?php echo $label; ?></a><?php
    
    $html = ob_get_clean(); 
	
	return apply_filters( 'yiw_sc_add_to_cart_html', $html );
}     
add_shortcode( 'add_to_cart', 'yiw_sc_add_to_cart_func' );

/** 
 * PRODUCT SLIDER     
 * 
 * @description
 *    Add a product slider   
 * 
 * @example
 *   [product_slider cat=""]
 * 
 * @attr                          
 *   id - the id of product
**/
function yiw_sc_product_slider_func($atts, $content = null) {  
	
  	//if (empty($atts)) return;
  
	extract(shortcode_atts(array(
	  	'orderby'   => 'date',
	  	'order'     => 'desc',
	  	'cat'       => '',
	  	'category'  => '',
	  	'style'     => '',
		), $atts));
  	
  	global $wpdb, $woocommerce, $woocommerce_loop; 
      
    if ( ! empty( $category ) && empty( $cat ) )
        $cat = $category;  
  	
  	if ( isset( $atts['latest'] ) && $atts['latest'] ) {
        $orderby = 'date';
        $order = 'desc'; 
    }
	
  	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'ignore_sticky_posts'	=> 1,
		'orderby' => $orderby,
		'order' => $order,
		'meta_query' => array(
			array(
				'key' 		=> '_visibility',
				'value' 	=> array('catalog', 'visible'),
				'compare' 	=> 'IN'
			)
		)
	);
	
	if(isset( $atts['featured']) && $atts['featured']){
    	$args['meta_query'][] = array(
      		'key' 		=> '_featured',
      		'value' 	=> 'yes'
    	);
  	}
	
	if(isset( $atts['best_sellers']) && $atts['best_sellers']){
    	$args['meta_key'] = 'total_sales';
    	$args['orderby'] = 'meta_value';
    	$args['order'] = 'desc';
  	}
	
	if(isset($atts['skus'])){
		$skus = explode(',', $atts['skus']);
	  	$skus = array_map('trim', $skus);
    	$args['meta_query'][] = array(
      		'key' 		=> '_sku',
      		'value' 	=> $skus,
      		'compare' 	=> 'IN'
    	);
  	}
	
	if(isset($atts['ids'])){
		$ids = explode(',', $atts['ids']);
	  	$ids = array_map('trim', $ids);
    	$args['post__in'] = $ids;
	}           
    
    if ( ! empty( $cat ) ) {
        $tax = 'product_cat';
        $cat = array_map( 'trim', explode( ',', $cat ) );
        if ( count($cat) == 1 ) $cat = $cat[0];
        $args['tax_query'] = array(
            array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => $cat
            )
        );
    }
    
    $woocommerce_loop['setLast'] = true;
    
    if ( empty( $style ) )
        $style = yiw_get_option( 'shop_products_style', 'ribbon' );
    
    //$style = yiw_get_option( 'shop_products_style', 'ribbon' );
    $woocommerce_loop['style'] = $style;  
	
	$products_per_page = yiw_layout_page() == 'layout-sidebar-no' ? 5 : 4;
	
	$products = new WP_Query( $args );
	
	$woocommerce_loop['columns'] = $products_per_page;

    $i = 0;
	if ( $products->have_posts() ) :
	    $html = $html_not_mobile = '';
        
        while ( $products->have_posts() ) : $products->the_post(); 
		
		    ob_start();
			woocommerce_get_template_part( 'content', 'product' );
			$item = ob_get_clean();
	        $html .= $item;
	        
	        if ( $i < $products_per_page )
	           $html_not_mobile .= $item;   
	
	        $i++;
		endwhile; // end of the loop.
		
	endif; 

	wp_reset_query();
	                         
	ob_start();
	echo '<div class="'.$style.'">';
	echo '<div class="products-slider '.$style.'"><ul class="products '.$style.'">'.$html.'</ul></div>';
	echo '<div class="for-mobile products-slider '.$style.'"><ul class="products '.$style.'">'.$html_not_mobile.'</ul></div>';    
	echo '</div>';
    $html = ob_get_clean(); 
	                                  
	$woocommerce_loop['loop'] = 0;        
	unset( $woocommerce_loop['setLast'] ); 
	
	return apply_filters( 'yiw_sc_product_slider_html', $html );
}     
add_shortcode( 'product_slider', 'yiw_sc_product_slider_func' );    

/**
 * List all (or limited) product categories
 **/
function yiw_sc_product_categories_slider_func( $atts ) { 
	global $woocommerce_loop;

	extract( shortcode_atts( array (
		//'number'     => null,
		'orderby'    => 'name',
		'order'      => 'ASC',
		'columns' 	 => '4',
		'hide_empty' => 1,
		'style'      => yiw_get_option( 'shop_products_style', 'ribbon' )
		), $atts ) );

	if ( isset( $atts[ 'ids' ] ) ) {
		$ids = explode( ',', $atts[ 'ids' ] );
	  	$ids = array_map( 'trim', $ids );
	} else {
		$ids = array();
	}                              
    
    $woocommerce_loop['setLast'] = true;
                                                       
    $woocommerce_loop['style'] = $style;  
	$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;
	
  	$args = array(
  		//'number'     => $number,
  		'orderby'    => $orderby,
  		'order'      => $order,
  		'hide_empty' => $hide_empty,
		'include'    => $ids
	);
	
  	$terms = get_terms( 'product_cat', $args );           
	
	$products_per_page = yiw_layout_page() == 'layout-sidebar-no' ? 5 : 4;

  	$woocommerce_loop['columns'] = $columns;
	
  	ob_start();
  	  	
  	if ( $terms ) {
  	    $html = $html_mobile = '';
		
		$i = 0;
		foreach ( $terms as $category ) {
			
			ob_start();
			woocommerce_get_template( 'content-product_cat.php', array(
				'category' => $category
			) );
			$item = ob_get_clean();
	        $html .= $item;
	        
	        if ( $i < $products_per_page )
	           $html_not_mobile .= $item; 
			
		}               

	}

	wp_reset_query();         
	                         
	ob_start();
	echo '<div class="products-slider categories '.$style.'"><ul class="products '.$style.'">'.$html.'</ul></div>';
	echo '<div class="for-mobile products-slider categories '.$style.'"><ul class="products '.$style.'">'.$html_mobile.'</ul></div>';    
    $html = ob_get_clean();     
	                                  
	$woocommerce_loop['loop'] = 0;
	unset( $woocommerce_loop['setLast'] ); 
	
	return apply_filters( 'yiw_sc_product_categories_slider_html', $html );
}                 
add_shortcode( 'product_categories_slider', 'yiw_sc_product_categories_slider_func' );    

/**
 * List all (or limited) product categories
 **/
function yiw_product_categories( $atts ) { 
	global $woocommerce_loop;

	extract( shortcode_atts( array (
		'number'     => null,
		'orderby'    => 'name',
		'order'      => 'ASC',
		'columns' 	 => '4',
		'hide_empty' => 1
		), $atts ) );

	if ( isset( $atts[ 'ids' ] ) ) {
		$ids = explode( ',', $atts[ 'ids' ] );
	  	$ids = array_map( 'trim', $ids );
	} else {
		$ids = array();
	}

	$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;
	
  	$args = array(
  		'number'     => $number,
  		'orderby'    => $orderby,
  		'order'      => $order,
  		'hide_empty' => $hide_empty,
		'include'    => $ids
	);
	
  	$terms = get_terms( 'product_cat', $args );

  	$woocommerce_loop['columns'] = $columns;
	
  	ob_start();
  	  	
  	if ( $terms ) {
  	
  		echo '<ul class="products">';
		
		foreach ( $terms as $category ) {
			
			woocommerce_get_template( 'content-product_cat.php', array(
				'category' => $category
			) );
			
		}
		
		echo '</ul>';

	}

	wp_reset_query();
	
	return ob_get_clean();
}
add_shortcode( 'product_categories', 'yiw_product_categories' );

?>