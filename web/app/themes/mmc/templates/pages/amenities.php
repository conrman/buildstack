<!-- Amenities -->
<?php 
$apartment_amenities = get_field('apartment_amenities');
$community_amenities = get_field('community_amenities');
?>

<section class="apartment-amenities">
	<div class="amenities-wrapper">
		<div class="container">
			<div class="row">
				<div class="content">
					<?php 
					if (!empty($apartments_amenities)) {
						echo $apartment_amenities;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="community-amenities">
	<div class="amenities-wrapper">
		<div class="container">
			<div class="row">
				<div class="content">
					<?php 
					if (!empty($community_amenities)) {
						echo $community_amenities; 
					}
					?>
				</div>
				<p class="disclaimer">Amenities subject to change.</p>
			</div>
		</div>
	</div>
</section>