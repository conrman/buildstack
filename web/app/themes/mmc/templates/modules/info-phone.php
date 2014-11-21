<?php global $display_options; ?>

<?php if (!empty($display_options['phone'])) : ?>
	<a class="phone-number font-1 text-brand-1 large" href="tel:<?php echo $display_options['phone']; ?>">
		<?php echo $display_options['phone']; ?>
	</a>
<?php endif; ?>