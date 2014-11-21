<?php global $display_options; ?>

<?php if (!empty($display_options['lease_online'])) : ?>
	<a class="lease-online button round min-bp1" href="<?php echo $display_options['lease_online']; ?>">Lease Now!</a>
<?php endif; ?>