<!-- Floorplan Info -->
<div class="floorplan-info">
	<span class="name"><?php the_title(); ?></span>
	<span class="beds"><?php echo get_field('bedrooms'); ?> Bedroom</span>
	<span class="baths"><?php echo get_field('bathrooms'); ?> Bedroom</span>
	<span class="sqft"><?php echo get_field('square_feet'); ?> Sq. Ft.</span>
	<span class="price">$<?php echo get_field('price'); ?></span>
</div>
