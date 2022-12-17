<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon" />

	<?php wp_head(); ?>
</head>
<body>
	<header>
		<div class="container">
			<div class="logo">
				<?php $logo = get_field('header_logo', 'options'); ?>
				<?php if (is_front_page()) { ?>
					<img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" title="<?php echo $logo['title']; ?>">
				<?php } else { ?>
					<a href="/"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" title="<?php echo $logo['title']; ?>"></a>
				<?php } ?>
			</div>
			<?php if ( has_nav_menu( 'topmenu' ) ) { ?>
				<div class="header-menu">
					<?php wp_nav_menu(array(
						'container' 		=> 'nav',
						'container_class' 	=> 'topmenu',
						'theme_location' 	=> 'topmenu',
						'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					));
					?>
				</div>
			<?php } ?>
			<div class="mmenu">
				<div class="line1 line"></div>
				<div class="line2 line"></div>
				<div class="line3 line"></div>
			</div>
		</div>
	</header>

