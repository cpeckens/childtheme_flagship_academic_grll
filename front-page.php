<?php get_header(); ?>
<?php
	/********SET VARIABLES**************/
	$theme_option = flagship_sub_get_global_options();
	$program_slug = get_the_program_slug($post);
	$all_programs = get_terms('program', array('orderby' => 'slug', 'fields' => 'ids'));
	$all_programs = implode(",", $all_programs);
	$program_names = get_terms('program', array('orderby' => 'names', 'fields' => 'all', 'hide_empty' => false));
	if ( $program_names && ! is_wp_error( $program_names ) ) { 
		$program_slugs = array();
			foreach ( $program_names as $program_name ) {
				$program_slugs[] = $program_name->slug;
			}
	}
	/********SLIDER QUERY**************/
		$slider_query = new WP_Query(array(
			'post_type' => 'slider',
			'tax_query' => array(array(
					'taxonomy' => 'program',
					'field' => 'slug',
					'id' => array($all_programs),
					'operator' => 'NOT IN'
					)),			
			'posts_per_page' => '1'));
	/********NEWS QUERY**************/		
		$news_query_cond = $theme_option['flagship_sub_news_query_cond'];
		$news_quantity = $theme_option['flagship_sub_news_quantity']; 
			if ( false === ( $news_query = get_transient( 'news_mainpage_query' ) ) ) {
				if ($news_query_cond === 1) {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => array( 'books' ),
								'operator' => 'NOT IN'
							)
						),
						'posts_per_page' => $news_quantity)); 
				} else {
					$news_query = new WP_Query(array(
						'post_type' => 'post',
						'posts_per_page' => $news_quantity)); 
				}
			set_transient( 'news_mainpage_query', $news_query, 2592000 );
			} 	
/********BEGIN SLIDER**************/
if ( $slider_query->have_posts() ) : ?>
	<div class="row hide-for-mobile">
	<div id="slider" class="twelve columns no-gutter">

	<?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
		<div class="slide row">
		<summary class="four columns offset-by-eight vertical" id="caption">
				<div class="middle">
					<h3 class="white"><?php the_title(); ?></h3>
					<h5 class="white italic"><?php echo get_the_content(); ?></h5>
				</div>
		</summary>
		</div>
	<?php endwhile; ?>
	</div>
	</div>
<?php endif; ?>

<div class="row homepage_bg">
	<div class="twelve columns">
		<div class="row">
			<div class="three columns radius-top" id="program-tab">
				<h4>Programs of Study</h4>
			</div>
		</div>
	</div>
	<div class="eight columns wrapper toplayer">
		<div class="row">
			<div class="twelve columns">
				<?php foreach ($program_slugs as $program_slug) { ?>
					<div class="button <?php echo $program_slug; ?>"><a href="<?php echo site_url() . '/' . $program_slug; ?>"><?php echo $program_slug; ?></a></div>
				<?php } ?>
			</div>
		</div>
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<section>
				<?php the_content(); ?>			
			</section>
		<?php endwhile; endif; ?>
		<?php if ( $news_query->have_posts() ) : ?>
		<h4><?php echo $theme_option['flagship_sub_feed_name']; ?></h4>
		<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
		<div class="row">		
		<section class="twelve columns">
				<a href="<?php the_permalink(); ?>">
					<h6><?php the_date(); ?></h6>
					<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php the_excerpt(); ?>
				</a>
				<hr>
		</section>
		</div>
		
		<?php endwhile; ?>
		<div class="row">
		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><h5 class="black">View More <?php echo $theme_option['flagship_sub_feed_name']; ?></h5></a>
		</div>
		<?php endif; ?>
	</div>	<!-- End main content (left) section -->
	
	<aside class="four columns hide-for-print" id="sidebar">
		<?php dynamic_sidebar( 'homepage-sb' ); ?>
	</aside>
</div> <!-- End #landing -->
<?php get_footer(); ?>