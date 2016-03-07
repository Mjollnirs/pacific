<?php
/**
 * The template for displaying the footer
 *
 * @package Pacific
 */

# Prevent direct access to this file
if ( 1 == count( get_included_files() ) ) {
	header( 'HTTP/1.1 403 Forbidden' );
	return;
}
?>
				<?php pacific_hook_footer_before(); ?>
			<?php if ( apply_filters( 'pacific_show_footer', true ) ) : ?>
				<footer role="contentinfo" class="site-info" itemscope itemtype="http://schema.org/WPFooter">
					<?php pacific_hook_footer(); ?>
				</footer>
			<?php endif; ?>
				<?php pacific_hook_footer_after(); ?>
				<?php pacific_hook_content_bottom(); ?>
			</div>
			<?php pacific_hook_content_after(); ?>
		</div>
	</div>
</div>
<?php pacific_hook_body_bottom(); ?>
<?php wp_footer(); ?>
</body>
</html>