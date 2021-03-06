<?php query_posts("post_type=slider&showposts=-1"); ?>	
<?php if (have_posts()) : ?>
 
<div id="sliderwrap" class="clearfix">

		<?php themify_slider_before(); //hook ?>
		<div id="slider" class="pagewidth">
        	<?php themify_slider_start(); //hook ?>
			<ul class="slides">
			
			<?php while (have_posts()) : the_post(); ?>
				 
				<li class="<?php echo themify_get('layout'); ?>"> 
				
				<?php if ( themify_get('external_link') != ''): ?>
					<?php $link = themify_get("external_link"); ?>
				<?php elseif ( themify_get('lightbox_link') != ''): ?>
					<?php $link = themify_get("lightbox_link").'" class="lightbox" rel="prettyPhoto[slider]'; ?>
				<?php else: ?>
					<?php $link = ''; ?>
				<?php endif; ?>

				<?php 
				if( $link != '') {
					$before = '<a href="' . $link . '" title="' . get_the_title() . '">';
					$after  = '</a>';
				} else {
					$before = '';
					$after  = '';
				} ?>

				<?php 
								  
				if(themify_get('layout') == 'slider-image-only') {
				
					echo $before . themify_get_image('w=978&h=400') . $after;
				
				} else if(themify_get('layout') == 'slider-content-only') {
				
					the_content();
				
				} else if(themify_get('layout') == 'slider-image-caption') {
				
					echo '<div class="image-caption-wrap">';
						echo $before . themify_get_image('w=978&h=400') . $after;
						echo '<div class="caption">';
							echo '<h3>' . $before . get_the_title() . $after . '</h3>';
							the_content();
						echo '</div>';
					echo '</div>';
				
				} else {
				
					echo $before . themify_get_image('w=470&h=400&class=slide-feature-image') . $after;
					echo '<div class="slide-content">';
						echo '<h3>' . $before . get_the_title() . $after . '</h3>';
						the_content();
					echo '</div>';
				}
				?>

			</li>
				<?php endwhile; ?>
		</ul>
        <?php themify_slider_end(); //hook ?>
	</div>
	<!--/slider -->
    <?php themify_slider_after(); //hook ?>
</div>
<!--/sliderwrap -->
<?php endif; ?>
<?php wp_reset_query(); ?>

