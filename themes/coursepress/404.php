<?php
/**
 * The template for displaying 404 pages ( Not Found ).
 *
 * @package CoursePress
 */

get_header();
?>

<div id="primary" class="content-area page-404">
	<main id="main" class="site-main" role="main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title">
					<?php _e( 'Oje! Die Seite wurde nicht gefunden.', 'cp' ); ?>
				</h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p>
					<?php _e( 'Es sieht so aus, als wäre hier nichts. Vielleicht einen der folgenden Links oder eine Suche probieren?', 'cp' ); ?>
				</p>

				<?php get_search_form(); ?>

				<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

				<?php // Only show the widget if site has multiple categories. ?>
				<?php if ( coursepress_categorized_blog() ) : ?>
				<div class="widget widget_categories">
					<h2 class="widgettitle">
						<?php _e( 'Meistgenutzte Kategorien', 'cp' ); ?>
					</h2>
					<ul>
						<?php
						wp_list_categories(
							array(
							'orderby' => 'count',
							'order' => 'DESC',
							'show_count' => 1,
							'title_li' => '',
							'number' => 10,
							)
						);
						?>
					</ul>
				</div><!-- .widget -->
				<?php endif; ?>

				<?php
				// Translators: %1$s: smiley.
				$archive_content = '<p>' .
				sprintf(
					__( 'Versuchen Sie es mal im monatlichen Archiv. %1$s', 'cp' ),
					convert_smilies( ':)' )
				) .
				'</p>';
				the_widget(
					'WP_Widget_Archives',
					'dropdown=1',
					'after_title=</h2>' . $archive_content
				);
				the_widget( 'WP_Widget_Tag_Cloud' );
				?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer();