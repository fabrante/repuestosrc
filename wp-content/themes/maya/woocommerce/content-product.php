<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @package WooCommerce
 * @since WooCommerce 1.6
 */
 
global $product, $woocommerce_loop;

if ( get_post_type() != 'product' ) remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering' );

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) 
	$woocommerce_loop['loop'] = 0;
                                           
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) 
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibilty
if ( ! $product->is_visible() ) 
	return;                       

// Increase loop count
$woocommerce_loop['loop']++;           

if ( isset( $woocommerce_loop['style'] ) )
    $style = $woocommerce_loop['style'];
else
    $style = yiw_get_option( 'shop_products_style', 'ribbon' );
$class_li = array('product');       

if ( ! yiw_get_option( 'shop_show_price' ) )
   $class_li[] = 'hide-price';

if ( $style == 'traditional' ) {
    if ( yiw_get_option( 'shop_border_thumbnail' ) )
       $class_li[] = 'border';
    if ( yiw_get_option( 'shop_shadow_thumbnail' ) )
       $class_li[] = 'shadow';
    if ( ! yiw_get_option( 'shop_show_button_details' ) )
       $class_li[] = 'hide-details-button';
    if ( ! yiw_get_option( 'shop_show_button_add_to_cart' ) )
       $class_li[] = 'hide-add-to-cart-button';
}

$loop_class_li = $class_li;
                                                                        
if ( ! isset( $woocommerce_loop['setLast'] ) && $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ==0 )
    $loop_class_li[] = 'last';      
    
if ( ! isset( $woocommerce_loop['setFirst'] ) && ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 )
    $loop_class_li[] = 'first';                 
    
if ( ! empty( $loop_class_li ) )
    $class = ' class="' . implode( ' ', $loop_class_li ) . '"';
else
    $class = '';

$title_position = yiw_get_option( 'shop_title_position' );    
if ( $style == 'ribbon' )
    $title_position = 'below-thumb';
?>
<li<?php echo $class ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
	<a href="<?php the_permalink(); ?>">
		
        <div class="thumbnail">		
    		<?php
    			/** 
    			 * woocommerce_before_shop_loop_item_title hook
    			 *
    			 * @hooked woocommerce_show_product_loop_sale_flash - 10
    			 * @hooked woocommerce_template_loop_product_thumbnail - 10
    			 */	  
    			do_action( 'woocommerce_before_shop_loop_item_title' ); 
    		?>
    		
    		<div class="thumb-shadow"></div>
    			
    		<?php if ( yiw_get_option( 'shop_show_name' ) ) : ?><strong class="<?php echo $title_position ?>"><?php the_title(); ?></strong><?php endif ?>
    	</div>

		<?php
			/** 
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */	  
			do_action( 'woocommerce_after_shop_loop_item_title' ); 
		?>
	
	</a>
	
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			
</li>