<?php get_template_part('templates/modules/jumbotron'); ?>

<?php
global $display_options;
$locations = get_posts(array('post_type' => 'location', 'posts_per_page' => '100'));

$categories = Array();
foreach ($locations as $post) { setup_postdata($post);
	$post_category = get_field('category');
	if( !in_array( $post_category, $categories)) {
		$categories[] = $post_category;
	}
}
?>


<div id="map">
	<div class="map-nav-wrapper">
		<nav class="map-categories">
			<?php foreach ($categories as $category) : ?>
				<div class="map-nav-link">
					<div class="nav-item <?php echo $category; ?>" onclick="javascript:showCategory('<?php echo $category; ?>');"></div>
					<div class="hotspots <?php echo $category; ?>"></div>
				</div>
			<?php endforeach; ?>
		</nav>

		<nav class="map-navigation">
			<div class="icon-gfx_location_zoomin" onclick="javascript:mapZoom(1);"></div>
			<div class="icon-gfx_location_zoomout" onclick="javscript:mapZoom(-1);"></div>
			<div class="icon-gfx_location_return" onclick="javscript:mapReset();"></div>
			<a class="icon-gfx_location_getdirections" href="http://google.com/maps/place/<?php echo $display_options['address'] . ' ' . $display_options['city'] . ' ' . $display_options['state']; ?>" target="_blank"></a>
		</nav>
	</div>

	<div id="map-canvas"></div>
</div>


<script type="text/javascript">
	var templateDirectory = '<?php echo get_template_directory_uri(); ?>';

	jQuery(document).ready(function($) {
		loadMap();

		<?php
		$i = 1;
		foreach($locations as $location) :  setup_postdata($location); 
			$fields = get_fields($location->ID);
			?>
			window.marker<?php echo $i; ?> = drawPoint({"lat": "<?php echo $fields["latitude"]; ?>", "lng": "<?php echo $fields["longitude"]; ?>", "name": "<?php echo $location->post_title; ?>", "website": "<?php echo $fields['website']; ?>", "category": "<?php echo $fields['category']; ?>", "address": "<?php echo $fields['address']; ?>"});
			$('.hotspots.<?php echo $fields['category']; ?>').append("<div class='hotspot'><a href='javascript:showPOIDetail(window.marker<?php echo $i; ?>)' class='title'><?php echo $location->post_title; ?></a><a class='website' href='<?php echo $fields['website']; ?>'>website</a><a class='directions' href='http://google.com/maps/place/<?php echo $fields['address']; ?>' target='_blank'>directions</a></div>");
			// $('.hotspots.<?php echo $fields['category']; ?>').append("<div class='hotspot' onclick='showPOIDetail(window.marker<?php echo $i; ?>);' data-number='<?php echo $i; ?>'><div class='title'><?php echo $location->post_title; ?></div></div>");
		<?php
			$i++;
		endforeach;
		?>

		$('nav.categories div').click(function() {
			$('nav.categories .map-nav-link').removeClass('active');
			$(this).addClass('active');
		});
	});
</script>