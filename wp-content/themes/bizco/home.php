<?php get_header(); ?>
	
	<?php if (is_home() && !is_paged()) { get_template_part( 'includes/slider'); } ?>
	    
	<div id="body">

		<!-- layout -->
		<div id="layout" class="pagewidth clearfix <?php echo $layout; ?>">

			<?php get_template_part( 'includes/welcome-message'); ?>

			<?php get_template_part( 'includes/home-highlights'); ?>

			<?php get_template_part( 'includes/home-widgets'); ?>

		</div>
		<!--/layout --> 

	</div>
	<!--/body -->

<?php get_footer(); ?>
