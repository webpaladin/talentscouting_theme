<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<main class="jobs-single archive-jobs">
		<div class="container">
			<div class="job-header">
				<a href="/jobs/">Back to results</a>
				<button class="apply">Apply with Adecco</button>
			</div>
			<p class="date"><?php the_time('m/d/Y'); ?></p>
			<h1><?php the_title(); ?></h1>
			<div class="job-parameters">
				<?php $location = wp_get_post_terms($post->ID, 'locations',  array("fields" => "names")) ?>
				<p class="address"><?php the_field('address'); ?>, <?php echo $location[0]; ?></p>

				<?php 
				$salary = get_field('annual_salary'); 
				if ($salary != 0) { ?>
					<p class="salary"><?php echo $salary; ?> Annual Salary</p>
				<?php } ?>

				<?php $worktypes = wp_get_post_terms($post->ID, 'worktypes',  array("fields" => "names")) ?>
				<p class="worktypes"><?php echo $worktypes[0]; ?></p>
			</div>
			<div class="description"><?php the_field('small_job_description'); ?></div>
			<?php the_content(); ?>
		</div>
		<div class="content-block">
			<div class="container">
				<div class="title">
					<h2>Similar jobs</h2>
				</div>
				<div class="content">
				<?php $industries = wp_get_post_terms($post->ID, 'industries',  array("fields" => "names"));
				$query = new WP_Query( array( 'posts_per_page' => 3, 'industries' => $industries[0] ) );
				?>
				<?php if ( $query->have_posts() ) : ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<div class="job">
						<p class="date"><?php the_time('m/d/Y'); ?></p>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="description"><?php the_field('small_job_description'); ?></div>
						<div class="job-parameters">
							<?php $location = wp_get_post_terms($post->ID, 'locations',  array("fields" => "names")) ?>
							<p class="address"><?php the_field('address'); ?>, <?php echo $location[0]; ?></p>

							<?php 
							$salary = get_field('annual_salary'); 
							if ($salary != 0) { ?>
								<p class="salary"><?php echo $salary; ?> Annual Salary</p>
							<?php } ?>

							<?php $worktypes = wp_get_post_terms($post->ID, 'worktypes',  array("fields" => "names")) ?>
							<p class="worktypes"><?php echo $worktypes[0]; ?></p>
						</div>
						<div class="job-footer">
							<p><a href="<?php the_permalink(); ?>">See job description</a></p>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php bloginfo('template_url'); ?>/img/arrow-back.svg" alt="arrow">
							</a>
						</div>
					</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'No similar vacancies' ); ?></p>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</main>


<?php endwhile; else: ?>
<main>
	<div class="container">
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	</div>
</main>
<?php endif; ?>

<?php get_footer(); ?>