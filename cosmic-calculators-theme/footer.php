<?php
/**
 * Site footer — `footer.php`
 *
 * Closes the <main>, includes the Cosmic footer partial, then closes
 * the page wrapper, fires `wp_footer` and closes <body> / <html>.
 *
 * @package Cosmic_Calculators
 */
?>
	</main><!-- #cosmic-content -->

	<?php get_template_part( 'template-parts/cosmic-footer' ); ?>

</div><!-- #cosmic-page -->

<?php wp_footer(); ?>
</body>
</html>
