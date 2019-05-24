<?php if ( $neighborhoods->have_posts() ) : ?>
	<?php if($map): ?>
		<div id="wrap-neighborhood">
			<section id="neighborhood" class="scrooll-neighborhood">
				<section id="wrap-result-neighborhoods" class="gwr">
					<h2 class="title"><?php echo __("Neighborhoods", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div id="wrap-list-neighborhoods">
						<ul class="neighborhoods-list">
							<?php
							while ( $neighborhoods->have_posts() ) : $neighborhoods->the_post();
								$url = get_post_meta( get_the_id(), NEIGHBORHOOD_IDX_NAME . '_url', true );
							?>
								<li class="properties">
									<?php if( has_post_thumbnail() ): ?>
										<div class="wrap-image"><a href="<?php echo $url; ?>"><img src="<?php the_post_thumbnail_url( 'full' ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"><span class="link-responsive-ng"><?php the_title(); ?></span></a></div>
									<?php // else: ?>
									<?php endif; ?>
								</li>
							<?php endwhile; wp_reset_postdata(); ?>
						</ul>
					</div>
				</section>
			</section>
			<div id="wrap-map">
				<div id="code-map"></div>
			</div>
		</div>
	<?php else: ?>
		<div class="items">
			<?php
			while ( $neighborhoods->have_posts() ) : $neighborhoods->the_post();
				$url = get_post_meta( get_the_id(), NEIGHBORHOOD_IDX_NAME . '_url', true );
			?>
				<a href="<?php echo $url; ?>" class="item">
					<?php if( has_post_thumbnail() ): ?>
	                	<img alt="listing" src="<?php the_post_thumbnail_url( 'full' ); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
	            	<?php endif; ?>
	                <h2><?php echo get_the_title(); ?></h2>
	            </a>
            <?php endwhile; wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>