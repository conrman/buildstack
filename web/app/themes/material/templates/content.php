<article class="project  card col s12 m6 l6">
	<a href="<?php echo the_permalink(); ?>" class="card-image project-image">
		<?php the_post_thumbnail('', array('class' => 'responsive')); ?>
	</a>
	<div class="project-title">
		<a class="grey-text" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
	</div>
</article>