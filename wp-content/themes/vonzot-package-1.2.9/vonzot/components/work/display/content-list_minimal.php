<?php
/**
 * Template part for displaying posts with the "list" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<li <?php vonzot_post_attr(); ?>>
	<h2 class="entry-title"><a class="entry-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
</li>