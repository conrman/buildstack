<?php
$jumbotron_image = get_field('jumbotron_image');
?>

<div class="jumbotron">
	<img src="<?php echo $jumbotron_image['url']; ?>" alt="<?php echo $jumbotron_image['alt']; ?>">
	<div class="container">
		<h1 class="jumbotron-heading"><?php echo $jumbotron_image['title'] ?></h1>
		<p class="jumbotron-text min-bp2"><?php echo $jumbotron_image['caption']; ?></p>
	</div>
</div>
