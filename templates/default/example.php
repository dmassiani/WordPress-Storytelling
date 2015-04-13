<?php
/*
Template Name: Example default template
Description: Section with 2 titles, 2 contents and 2 illustrations
---------------------------------------------------------------------
{"type": "title", "name": "Left title", "slug": "left_title"}
{"type": "editor", "name": "Left content", "slug": "left_content"}
---------------------------------------------------------------------
*/
?>
<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_chapter_title( 'left_title' ) ?>
		</h1>
		<h2>Template Plugin</h2>
	</header>
	<div class="entry-content">
		<?php the_chapter( 'left_content' ) ?>
	</div>

</article>