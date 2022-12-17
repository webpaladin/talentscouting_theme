<?php 

require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

$keyword = htmlspecialchars(trim($_POST['keyword']));
$location = htmlspecialchars(trim($_POST['location']));
$curent_page = htmlspecialchars(trim($_POST['page']));
$perpage = get_option('posts_per_page');
$start_position = ($curent_page - 1) * $perpage;





global $wpdb;
$value = '%'.$wpdb->esc_like($location).'%';
$sql = $wpdb->prepare("SELECT p.ID
	FROM {$wpdb->prefix}posts p
	LEFT JOIN {$wpdb->prefix}postmeta m ON m.post_id = p.ID
	LEFT JOIN {$wpdb->prefix}term_relationships r ON r.object_id = p.ID
	LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tt.term_taxonomy_id = r.term_taxonomy_id AND tt.taxonomy = 'locations'
	LEFT JOIN {$wpdb->prefix}terms t ON t.term_id = tt.term_id
	WHERE p.post_status = 'publish' AND p.post_type = 'jobs'
	AND ((m.meta_key = 'address' AND m.meta_value LIKE %s) 
		OR (t.name LIKE %s))
	GROUP BY p.ID ", $value, $value);
	$ids = $wpdb->get_col($sql);
if (is_array($ids) && count($ids) > 0) {
	$output = array_slice($ids, $start_position, 7);
	$posts = (array_map('get_post', $output));
	foreach ($posts as $post) { ?>
		<div class="job">
			<p class="date"><?php echo get_the_date('m/d/Y', $post->ID); ?></p>
			<h2><a href="<?php echo get_post_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h2>
			<div class="description"><?php the_field('small_job_description',$post->ID); ?></div>
			<div class="job-parameters">
				<?php $location = wp_get_post_terms($post->ID, 'locations',  array("fields" => "names")) ?>
				<p class="address"><?php the_field('address',$post->ID); ?>, <?php echo $location[0]; ?></p>

				<?php 
				$salary = get_field('annual_salary',$post->ID); 
				if ($salary != 0) { ?>
					<p class="salary"><?php echo $salary; ?> Annual Salary</p>
				<?php } ?>

				<?php $worktypes = wp_get_post_terms($post->ID, 'worktypes',  array("fields" => "names")) ?>
				<p class="worktypes"><?php echo $worktypes[0]; ?></p>
			</div>
			<div class="job-footer">
				<p><a href="<?php echo get_post_permalink($post->ID); ?>">See job description</a></p>
				<a href="<?php echo get_post_permalink($post->ID); ?>">
					<img src="<?php bloginfo('template_url'); ?>/img/arrow-back.svg" alt="arrow">
				</a>
			</div>
		</div>
	<?php }
} else { ?>
	<p><?php _e('Sorry, no jobs matched your criteria.'); ?></p>
<?php }

$count = count($ids);
$count_pages = ceil($count / $perpage); ?>
<div class="navigation stoped search-nav">
	<?php echo pagination($curent_page, $count_pages); ?>
</div>