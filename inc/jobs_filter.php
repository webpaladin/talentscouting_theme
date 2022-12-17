<?php 

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$industries = $_POST['industries'];
$location = $_POST['location'];
$worktype = $_POST['worktype'];

$salary_min = htmlspecialchars(trim($_POST['salary_min']));
$salary_max = htmlspecialchars(trim($_POST['salary_max']));

$curent_page = htmlspecialchars(trim($_POST['page']));
$perpage = get_option('posts_per_page');
$start_position = ($curent_page - 1) * $perpage;


$args = array( 
	'post_type' => 'jobs', 
	'posts_per_page' => $perpage, 
	'offset' => $start_position,
	'meta_query' => array(
		array(
			'key' => 'annual_salary',
			'value' => array($salary_min, $salary_max),
			'type'    => 'numeric',
			'compare' => 'BETWEEN'
		)
	),
	'tax_query' => array(
		'relation' => 'AND',
	),
);

if (!empty($industries)) {
	array_push($args['tax_query'], array(
		'taxonomy' => 'industries',
		'field'    => 'slug',
		'terms'    => $industries,
		'compare'   => '='
	));
}

if (!empty($location)) {
	array_push($args['tax_query'], array(
		'taxonomy' => 'locations',
		'field'    => 'slug',
		'terms'    => $location,
		'compare'   => '='
	));
}

if (!empty($worktype)) {
	array_push($args['tax_query'], array(
		'taxonomy' => 'worktypes',
		'field'    => 'slug',
		'terms'    => $worktype,
		'compare'   => '='
	));
}



$query = new WP_Query( $args );
?>

<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
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
<p><?php _e('Sorry, no jobs matched your criteria.'); ?></p>
<?php endif; ?>
<?php $count = $query->found_posts;
if ($count != 0) {
	$count_pages = ceil($count / $perpage); ?>
	<div class="navigation stoped filter-nav">
		<?php echo pagination($curent_page, $count_pages); ?>
	</div>
	<?php 	
}
wp_reset_postdata(); ?> 