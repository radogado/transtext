<?php query_posts("post_type=highlights&showposts=-1"); ?>	
<?php if (have_posts()) : ?>

		<div class="home-highlightswrap">
			<div class="home-highlights clearfix">
		
				<?php
				$x = 1; 
				while (have_posts()) : the_post();
					if( 1 == $x ){
						$class = 'first';
						$x++; 
					} else {
						$class = '';
						if( 3 == $x ){
							$x = 1;
						}
						else {
							$x++;
						}
					}
					?>
					<div class="col3-1 <?php echo $class; ?>"> 
						<div class="icon">

							<?php if ( themify_get('external_link') != ''): ?>
								<?php $link = themify_get("external_link"); ?>
							<?php elseif ( themify_get('lightbox_link') != ''): ?>
								<?php $link = themify_get("lightbox_link")."' class='lightbox' rel='prettyPhoto[highlights]"; ?>
							<?php else: ?>
								<?php $link = ''; ?>
							<?php endif; ?>
			
							<?php 
							if( $link != ''){
								$before = "<a href='". $link ."' title='". get_the_title() ."'>";
								$after = "</a>";
							} else {
								$before = "";
								$after = "";
							} ?>

							<?php echo $before; ?>
							<?php themify_image('field_name=feature_image&w=70&h=70'); ?>
							<?php echo $after; ?>

						</div>
						<div class="home-highlights-content">
							<h4 class="home-highlights-title"><?php echo $before ?><?php the_title(); ?></a></h4>
							<?php the_content(); ?>
							<?php edit_post_link('Edit', '[', ']'); ?>
						</div>
					</div>
					
				<?php endwhile; ?>
		
			</div>
		</div>
		<!-- /.home-highlightswrap -->
		
<?php endif; ?>
<?php wp_reset_query(); ?>
