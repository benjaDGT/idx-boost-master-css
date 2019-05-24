<?php if ( $neighborhoods->have_posts() ) : ?>
	<?php if($map): ?>

		<div id="wrap-neighborhood">
			<section id="neighborhood" class="scrooll-neighborhood">
				<section id="wrap-result-neighborhoods" class="gwr">
					<h2 class="title">Areas</h2>
					<div id="wrap-list-neighborhoods">
						<ul class="neighborhoods-list">
							<?php
							while ( $neighborhoods->have_posts() ) : $neighborhoods->the_post();
								$url = get_post_meta( get_the_id(), BUILDINGS_IDX_NAME . '_url', true );
								$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
								$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
								if (empty($url_thumbdefault)) { if (file_exists(BUILDINGS_IDX_PATH.'/images/default.jpg'))  $url_thumbdefault = BUILDINGS_IDX_URI.'/images/default.jpg'; else $url_thumbdefault = '//idxboost.com/i/default_thumbnail.jpg'; }
								if (empty($post_thumbnail_url)) $post_thumbnail_url= $url_thumbdefault;
								?>									
								<li class="properties">
										<div class="wrap-image"><a href="<?php echo $url; ?>"><img src="<?php echo $post_thumbnail_url; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"><span class="link-responsive-ng"><?php the_title(); ?></span></a></div>
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
				$url = get_post_meta( get_the_id(), BUILDINGS_IDX_NAME . '_url', true );
				$post_thumbnail_id = get_post_thumbnail_id(get_the_id());
				$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
				$url_thumbdefault = 'http://idxb031.staging.wpengine.com/wp-content/themes/millenniumib/images/coming-soon_02.jpg';
				if (empty($post_thumbnail_url)) $post_thumbnail_url= $url_thumbdefault;
				?>
				<a href="<?php echo $url; ?>" class="item">
	                	<img alt="listing" src="<?php echo $post_thumbnail_url; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
	                <h2><?php echo get_the_title(); ?></h2>
	            </a>
            <?php endwhile; wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>