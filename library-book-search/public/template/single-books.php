<?php

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Single Books Posts Template
 *
 *
 * @file           single-books.php
 * @version        Release: 1.0.0
 */

get_header(); ?>

<div id="content">

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<h1 class="page-title"><?php the_title(); ?></h1>
                <ul class="single-page-book-info">
                <li><strong><?php echo __('Author','library-book-search'); ?> </strong><div class="book-info-val"><?php 
								$b_authors = wp_get_post_terms(get_the_ID(),'book_author');								
								if(!empty($b_authors)){
									foreach($b_authors as $b_author){
										echo '<a href="'.get_term_link($b_author).'">'.$b_author->name.'</a>';
									}
								}
							?></div></li>
                <li><strong><?php echo __('Publisher','library-book-search'); ?> </strong><div class="book-info-val"><?php 
								$b_publishers = wp_get_post_terms(get_the_ID(),'book_publisher');								
								if(!empty($b_publishers)){
									foreach($b_publishers as $b_publisher){										
										echo '<a href="'.get_term_link($b_publisher).'">'.$b_publisher->name.'</a>';
									}
								}
							?></div></li>
                <li><strong><?php echo __('Rating','library-book-search'); ?> </strong><span class="rating-star-<?php echo get_post_meta(get_the_ID(),'book_rating', true); ?>"></span></li>
                <li><strong><?php echo __('Price','library-book-search'); ?> </strong>$<?php echo get_post_meta(get_the_ID(),'book_price', true); ?></li>
                </ul>
                
				<div class="post-entry">
                	<div class="book-single-desc-sec">
                    <?php 
						if(has_post_thumbnail()){
							echo '<div class="book-img">';
								echo get_the_post_thumbnail(); 	
							echo '</div>';
						}
					?>
                    	<div class="book-single-img">
                        	
                        </div>
                        <div class="book-single-desc">
							<?php the_content( __( 'Read more &#8250;', 'library-book-search' ) ); ?>
                    	</div>

					
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'library-book-search' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<div class="navigation">
					<div class="previous"><?php previous_post_link( '&#8249; %link' ); ?></div>
					<div class="next"><?php next_post_link( '%link &#8250;' ); ?></div>
				</div>
				<!-- end of .navigation -->

				

			</div><!-- end of #post-<?php the_ID(); ?> -->
		<?php
		endwhile;
	endif;
	?>

</div><!-- end of #content -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
