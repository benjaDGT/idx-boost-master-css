<?php get_header();
$data = dgt_load_communities_fn(false);
$metadata = $data['metadata'];
$params = $metadata['params'];
$result = $data['items'];
?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="wrap-neighborhood">
	<section id="neighborhood" class="scrooll-neighborhood">
		<header>
			<div class="gwr">
				<div class="title-header">
					<h1> <?php echo __('Miami Featured Communities', IDXBOOST_DOMAIN_THEME_LANG);?></h1>
				</div>
				<?php get_template_part('pages-idx/blocks/block-bottom-request-more-info'); ?>
				<div id="wrap-breacrumb">
					<div class="gwr">
						<ol id="breacrumb">
							<li><a href="#"><?php echo __('Home', IDXBOOST_DOMAIN_THEME_LANG);?></a></li>
							<li><?php echo __('Communities', IDXBOOST_DOMAIN_THEME_LANG);?></li>
						</ol>
					</div>
				</div>
			</div>
		</header>
		<section id="wrap-result-neighborhoods" class="gwr">
			<h2 class="title"><?php echo __('Miami Beach Properties', IDXBOOST_DOMAIN_THEME_LANG);?></h2>
			<div id="wrap-list-neighborhoods">
				<ul class="neighborhoods-list">
					<?php foreach($result as $row):
						$silos = $row['silos']; ?>
					<li class="properties">
						<h2><a href="<?php bloginfo('url'); ?>/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a></h2>
						<ul class="nav-list">
							<?php foreach($silos as $silo => $_permalink):
								if($silo != 'Properties'){
								?>
							<li><a href="<?php echo $_permalink; ?>" title="<?php echo sprintf('%s in %s', $silo, $row['name']); ?>"><?php echo $silo; ?></a></li>
							<?php }
							endforeach; ?>
						</ul>
						<div class="wrap-image"><img src="<?php echo $row['image']; ?>" title="<?php echo $row['name']; ?>" alt="<?php echo $row['name']; ?>" class="<?php echo $row['class']; ?>"><a class="link-responsive-ng" href="<?php bloginfo('url'); ?>/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a></div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
		</footer>
	</section>
	<div id="wrap-map">
		<div id="code-map"></div>
	</div>
</div>
<?php
endwhile;
get_footer();