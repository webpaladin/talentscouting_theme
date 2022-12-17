<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<main>
		<?php the_content(); ?>
	</main>


<?php endwhile; else: ?>
<main>
	<div class="container">
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	</div>
</main>
<?php endif; ?>



<?php get_footer(); ?>