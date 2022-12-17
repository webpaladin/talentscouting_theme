
<footer>
	<div class="container">
		<div class="left">
			<h1><?php the_field('footer_title', 'options'); ?></h1>
			<p><?php the_field('footer_text', 'options'); ?></p>
			<?php $logo = get_field('footer_logo', 'options'); ?>
			<img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" title="<?php echo $logo['title']; ?>">
			<p><?php the_field('copyright', 'options'); ?></p>
		</div>
		<div class="right">
			<div class="social-links">			
				<?php $links = get_field('socials_links', 'options');
				foreach ($links as $link) { ?>
					<a href="<?php echo $link['link']; ?>">
						<img src="<?php echo $link['image']['url']; ?>" alt="<?php echo $link['image']['alt']; ?>">
					</a>
				<?php } ?>
			</div>
			<?php if ( has_nav_menu( 'footermenu' ) ) { ?>
				<div class="footer-menu">
					<?php wp_nav_menu(array(
						'container' 		=> 'nav',
						'container_class' 	=> 'footermenu',
						'theme_location' 	=> 'footermenu',
						'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					));
					?>
				</div>
			<?php } ?>
		</div>
	</div>
</footer>
<div id="popup-bg">
	<div class="mail-popup">
		<?php echo do_shortcode('[contact-form-7 id="145" title="Contact form 1"]'); ?>
		<div class="close">&times;</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>