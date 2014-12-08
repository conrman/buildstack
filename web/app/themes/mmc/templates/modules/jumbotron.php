<!-- Jumbotron -->
<?php
$jumbotron_text = get_field('jumbotron_text');
$jumbotron_image = get_field('jumbotron_image');
?>

<div class="jumbotron">
	<?php if (!empty($jumbotron_image)) {
		echo "<img src=" . $jumbotron_image['url'] . " title=" . $jumbotron_image['title'] . " alt=" . $jumbotron_image['alt'] .  ">";
	} ?>
	<div class="container">
		<?php echo $jumbotron_text; ?>
	</div>
</div>