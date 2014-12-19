<!-- Footer -->
<?php global $display_options; ?>
<?php global $social_options; ?>
<footer id="app-footer" class="app-footer">
	<div class="footer-wrapper">
		<div class="row">
			<div class="span-3">
				<div class="icon-logo_greystar"></div>
			</div>
			<div class="span-6">
				<p class="disclaimer"></p>
			</div>
			<div class="span-3">
				<a class="icon-logo_mmc" href="http://mixedmediacreations.com" target="_blank"></a>
			</div>
		</div>
	</div>
</footer>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.1&sensor=false"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	var defaultAddress = '<?php echo $display_options['address'] .', '. $display_options['city'] .', '. $display_options['state']; ?>';
	var defaultLat = '<?php echo $display_options['latitude']; ?>';
	var defaultLng = '<?php echo $display_options['longitude']; ?>';
</script>
<?php wp_footer(); ?>