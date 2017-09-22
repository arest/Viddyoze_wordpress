<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			<?php if (false && is_page('bootcamp-author-details')): ?>
				<?php $author = do_action('bootcamp_render_author') ?>
				<?php if ($author): ?>
					
				<article>
					<div class="entry-content">
						<h1>Php Approch</h1>
						<h3><?php echo $author['firstName'] ?> <?php echo $author['lastName'] ?></h3>
						<?php foreach ($author['quotes'] as $quote): ?>
							<p>
								<?php echo $quote['content'] ?>
							</p>
						<?php endforeach ?>
					</div>
				</article>
				<?php endif ?>
			<?php endif ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
