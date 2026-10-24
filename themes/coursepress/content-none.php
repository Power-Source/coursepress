<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CoursePress
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Keine Kurse gefunden', 'cp' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php
			printf(
				__( 'Sind Sie bereit Ihren ersten Beitrag zu veröffentlichen?  <a href="%1$s">Starten Sie hier</a>.', 'cp' ),
				esc_url( admin_url( 'post-new.php' ) )
			);
			?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php
			_e( 'Es tut uns leid. Ihre Suche ergab keinen Treffer. Bitte versuchen Sie es mit einem anderen Begriff.', 'cp' );
			?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php
			_e( 'Es scheint, dass wir nicht finden können, was du suchst. Vielleicht kann die Suche helfen.', 'cp' );
			?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->