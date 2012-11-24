<?php 
	global $wp_query, $post;

        $already_looped = false;  // controllo in più per evitare che il contenuto di una pagina venga ripetuto due volte erroneamente
	
	//$tmp_query = $wp_query;
	
	if ( have_posts() ) : 

	    while ( have_posts() && ! $already_looped ) : the_post();
	    	
			add_filter( 'the_title', 'yiw_get_convertTags' ); 
			
			$wpautop = get_post_meta( get_the_ID(), '_page_remove_wpautop', true );
			
			if( $wpautop )
				remove_filter( 'the_content', 'wpautop' );
			
			$_active_title = get_post_meta( $post->ID, '_show_title_page', true );
			
			if( $_active_title == 'yes' || !$_active_title ) 
				the_title( '<h2>', '</h2>' );     
			?>	
			
			<?php if ( ! empty( $post->post_content ) ) : ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>><?php
				the_content();?>
			</div><?php
			endif;

                        $already_looped = true;
		
			if( $wpautop )
				add_filter( 'the_content', 'wpautop' ); 
		
		endwhile; 
	
	endif; 
	
	//$wp_query = $tmp_query;      
	wp_link_pages();
	wp_reset_query();
?>                    