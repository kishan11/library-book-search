<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @version        Release: 1.1
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content-archive" class="archive-page-book">
	<?php if( have_posts() ) : ?>

		<h1 class="page-main-title"><?php echo get_the_archive_title(); ?></h1>

		<?php while( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="archive-book-item">
				<h1 class="book-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="book-item-sec">
					<?php if( has_post_thumbnail() ) : ?>
                    	<div class="book-img">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?>
                            </a>
                        </div>
					<?php endif; ?>
                    <div class="book-desc">
						<?php the_excerpt(); ?>
                    </div>
				</div>
				<!-- end of .post-entry -->

			</div><!-- end of #post-<?php the_ID(); ?> -->
            
		<?php
		endwhile;
?>
			<div class="navigation">
				<?php echo posts_nav_link(); ?>
			</div>
<?php
	else :
		echo __(' No more posts', '');

	endif;
	?>

</div><!-- end of #content-archive -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>