<?php get_header(); $program_slug = get_the_program_slug($post);?>
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns">	
		<?php $theme_option = flagship_sub_get_global_options(); $news_query_cond = $theme_option['flagship_sub_news_query_cond']; ?>	
		<section class="content">
		<h2 class="capitalize"><?php echo $program_slug . ' ' . $theme_option['flagship_sub_feed_name']; ?> Archive</h2>
		
		<?php if ($news_query_cond === 1) { while (have_posts()) : the_post(); if(!has_term('books','category') && 'post' == get_post_type()) { ?>
		<div class="ten columns">
			<a href="<?php the_permalink(); ?>">	
				<h6><?php the_date(); ?></h6>
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php the_excerpt(); ?>
			</a>
		</div>
				<hr>
		<?php } endwhile; } else { ?>

		
		
		<?php while (have_posts()) : the_post(); if('post' == get_post_type()) { ?>
		<div class="ten columns">
			<a href="<?php the_permalink(); ?>">	
				<h6><?php the_date(); ?></h6>
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php the_excerpt(); ?>
			</a>
		</div>
				<hr>
		<?php } endwhile; } ?>
			
			
			
		<div class="row">
			<?php flagship_pagination(); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
</div> <!-- End #landing -->
<?php get_footer(); ?>