<!-- Phone -->
<?php global $display_options; ?>

<?php if (!empty($display_options['phone'])) : ?>
	<?php if (device_detect('phone')) : ?>
		<a class="phone-number" href="tel:<?php echo $display_options['phone']; ?>">
			<?php echo $display_options['phone']; ?>
		</a>
	<?php else : ?>
		<span class="phone-number">
			<?php echo $display_options['phone']; ?>
		</span>
	<?php endif; ?>
<?php endif; ?>