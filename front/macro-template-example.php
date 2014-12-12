<?php
/*

Template Name: powerfullmacro
Description: 2 columns with 2 content and 2 images

-----------------------------------------------------------------------------------
{"type": "editeur", "name": "left content", "slug": "left_content"}
{"type": "image", "name": "left illustration", "slug": "left_illustration"}
{"type": "editeur", "name": "right content", "slug": "right_content"}
{"type": "image", "name": "right illustration", "slug": "right_illustration"}
-----------------------------------------------------------------------------------

*/
?>

<h2>Powerfull Macro Content Exemple</h2>

<h3>Left content</h3>
<?php the_chapter('left_content') ?>

<h3>Left image</h3>
<?php the_illustration('left_illustration') ?>

<h3>Right content</h3>
<?php the_chapter('right_content') ?>

<h3>Right illustration</h3>
<?php the_illustration('right_illustration') ?>