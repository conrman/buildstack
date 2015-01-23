<?php
/*
* Template Name: Projects Page Template
*/

$args = array( 'post_type' => 'project', 'orderby' => 'menu_order', 'posts_per_page' => 100);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();  ?>

<div class="col s12 m6 l6">
	<div class="project card">
		<a href="<?php echo the_permalink(); ?>" class="card-image project-image">
			<?php the_post_thumbnail('', array('class' => 'responsive')); ?>
		</a>
		<div class="project-title card-title activator">
			<?php the_title(); ?> <i class="mdi-navigation-more-vert right"></i>
		</div>
		<div class="card-reveal">
			<a class="grey-text" href="<?php echo the_permalink(); ?>">
				<i class="mdi-navigation-close right"></i>
				<p><?php the_excerpt(); ?></p>
			</a>
		</div>
	</div>
</div>

<?php
endwhile;
?>

