<?php get_header(); ?>

<main class="archive-jobs">
	<div class="search">
		<div class="container">
			<h1>Search for jobs</h1>
			<div class="form">
				<input type="text" name="keyword"  placeholder="Job title / Keyword">
				<input type="text" name="location"  placeholder="Location">
				<button class="search">Search</button>
			</div>
		</div>
	</div>
	<div class="content-block">
		<div class="container">
			<div class="filter-sidebar">
				<div class="sidebar-header">
					<h3>Filter</h3>
					<a href=/jobs/ class="reset">reset</a>
				</div>
				<div class="filter-sidebar-main">
					<div class="item industries-filter">
						<h4>Industries</h4>
						<div class="list">
							<?php $terms = get_terms( array(
								'taxonomy' => 'industries',
								'hide_empty' => false,
							) );
							foreach ($terms as $term) { ?>
								<div class="check-container">
									<input type="checkbox" id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" >
									<span class="checkmark"></span>
									<label for="<?php echo $term->slug; ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</label>
								</div>
							<?php }
							?>
						</div>
					</div>
					<div class="item location-filter">
						<h4>Location</h4>
						<div class="list">
							<?php $terms = get_terms( array(
								'taxonomy' => 'locations',
								'hide_empty' => false,
							) );
							foreach ($terms as $term) { ?>
								<div class="check-container">
									<input type="checkbox" id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" >
									<span class="checkmark"></span>
									<label for="<?php echo $term->slug; ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</label>
								</div>
							<?php }
							?>
						</div>
					</div>
					<div class="item worktype-filter">
						<h4>Work type</h4>
						<div class="list">
							<?php $terms = get_terms( array(
								'taxonomy' => 'worktypes',
								'hide_empty' => false,
							) );
							foreach ($terms as $term) { ?>
								<div class="check-container">
									<input type="checkbox" id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" >
									<span class="checkmark"></span>
									<label for="<?php echo $term->slug; ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</label>
								</div>
							<?php }
							?>
						</div>
					</div>
					<div class="item salary-filter">
						<h4>Salary</h4>
						<div class="list">
							<div class="price-range">
								<label for="amount">Price range:</label>
								<input type="text" id="salary_min" readonly>
								<p> - </p>
								<input type="text" id="salary_max" readonly>
							</div>
							<div id="slider-range"></div>
						</div>
					</div>
					<button class="submit-filter">Submit</button>
				</div>
			</div>
			<div class="content">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
			<?php if (function_exists('wp_corenavi')) wp_corenavi(); ?>
		</div>
	</div>
</div>
</main>

<?php get_footer(); ?>