<?php global $display_options;?>

<?php if (!empty($display_options)) : ?>
	<address class="min-bp2">
		<a href="http://google.com/maps/place/<?php echo $display_options['address'] . ' ' . $display_options['city'] . ' ' . $display_options['state']; ?>" target="_blank">
			<?php if (!empty($display_options['address'])) : ?>
				<span class="street-address">
					<?php echo $display_options['address']; ?> 
				</span>
			<?php endif; ?>
			<?php if (!empty($display_options['city'])) : ?>
				<span class="city">
					<?php echo $display_options['city']; ?> 
				</span>
			<?php endif; ?>
			<?php if (!empty($display_options['state'])) : ?>
				<span class="state">
					<?php echo $display_options['state']; ?> 
				</span>
			<?php endif; ?>
			<?php if (!empty($display_options['zip'])) : ?>
				<span class="zip">
					<?php echo $display_options['zip']; ?>
				</span>
			<?php endif; ?>
		</a>
	</address>
<?php endif; ?>