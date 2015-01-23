<?php 
$slide_imgs = get_field('slider_images');
if ($slide_imgs != "") {
  $slides = '<div id="' . $post->post_name . '-slider" class="slider">';
  foreach ($slide_imgs as $img) {
    $slides .= '<div><img src="' . $img['url'] .'" class="responsive">';
    $slides .= '<div class="caption">';
    $slides .= '<h6><em>' . $img['caption'] . '</em></h6>';
    $slides .= '</div>';
    $slides .= '</div>';
  }
  $slides .= '</div>';
  $slides .='</div>';

  print($slides);
}
?>