<?php

require_once dirname( __FILE__ ) . '/class-settings.php';

class CoursePress_View_Admin_Setting_Pages extends CoursePress_View_Admin_Setting_Setting {

	public static function init() {

		add_action( 'coursepress_settings_process_pages', array( __CLASS__, 'process_form' ), 10, 2 );
		add_filter( 'coursepress_settings_render_tab_pages', array( __CLASS__, 'return_content' ), 10, 3 );
		add_filter( 'coursepress_settings_tabs', array( __CLASS__, 'add_tabs' ) );

	}

	public static function add_tabs( $tabs ) {

		self::$slug = 'pages';
		$tabs[ self::$slug ] = array(
			'title' => __( 'Seiten', 'cp' ),
			'description' => __( 'Konfiguriere die Seiten für CoursePress.', 'cp' ),
			'order' => 1,
		);

		return $tabs;

	}

	public static function return_content( $content, $slug, $tab ) {

		$page_dropdowns = array();

		$pages_args = array(
			'selected' => CoursePress_Core::get_setting( 'pages/enrollment', 0 ),
			'echo' => 0,
			'show_option_none' => __( '&mdash; Auswählen &mdash;', 'cp' ),
			'option_none_value' => 0,
			'name' => 'coursepress_settings[pages][enrollment]',
		);
		$page_dropdowns['enrollment'] = wp_dropdown_pages( $pages_args );

		$pages_args['selected'] = CoursePress_Core::get_setting( 'pages/login', 0 );
		$pages_args['name'] = 'coursepress_settings[pages][login]';
		$page_dropdowns['login'] = wp_dropdown_pages( $pages_args );

		$pages_args['selected'] = CoursePress_Core::get_setting( 'pages/signup', 0 );
		$pages_args['name'] = 'coursepress_settings[pages][signup]';
		$page_dropdowns['signup'] = wp_dropdown_pages( $pages_args );

		$pages_args['selected'] = CoursePress_Core::get_setting( 'pages/student_dashboard', 0 );
		$pages_args['name'] = 'coursepress_settings[pages][student_dashboard]';
		$page_dropdowns['student_dashboard'] = wp_dropdown_pages( $pages_args );

		$pages_args['selected'] = CoursePress_Core::get_setting( 'pages/student_settings', 0 );
		$pages_args['name'] = 'coursepress_settings[pages][student_settings]';
		$page_dropdowns['student_settings'] = wp_dropdown_pages( $pages_args );

		$pages_args['selected'] = CoursePress_Core::get_setting( 'pages/instructor', 0 );
		$pages_args['name'] = 'coursepress_settings[pages][instructor]';
		$page_dropdowns['instructor'] = wp_dropdown_pages( $pages_args );

		$content = '';

		$content .= self::page_start( $slug, $tab );
		$content .= self::table_start();

		/**
		 * Student Dashboard
		 */
		$content .= self::row(
			__( 'Studenten Dashboard', 'cp' ),
			$page_dropdowns['student_dashboard'],
			__( 'Wählen Sie die Seite aus, in der der Schüler Kurse ansehen können.', 'cp' )
		);

		/**
		 * Student Settings
		 */
		$content .= self::row(
			__( 'Studenten Einstellungen', 'cp' ),
			$page_dropdowns['student_settings'],
			__( 'Wählen Sie die Seite aus, auf der der Schüler die Einstellungen ändern können.', 'cp' )
		);

		/**
		 * login
		 */
		$content .= self::row(
			__( 'Anmelden', 'cp' ),
			$page_dropdowns['login'],
			__( 'Wähle die Seite aus, auf der sich der Schüler anmelden kann.', 'cp' )
		);

		/**
		 * Signup
		 */
		$content .= self::row(
			__( 'Registrieren', 'cp' ),
			$page_dropdowns['signup'],
			__( 'Wähle die Seite aus, auf der du ein Konto anlegen kannst.', 'cp' )
		);

		/**
		 * Instructor.
		 */
		$content .= self::row(
			__( 'Kursleiter', 'cp' ),
			$page_dropdowns['instructor'],
			__( 'Wähle die Seite aus, auf der wir das Profil der Lehrkraft anzeigen.', 'cp' )
		);

		/**
		 * Enrollment
		 */
		$content .= self::row(
			__( 'Seite zum Einschreibungsprozess', 'cp' ),
			$page_dropdowns['enrollment'],
			sprintf( __( 'Wähle die Seite aus, auf der wir den Anmeldeprozess anzeigen.', 'cp' ) . '</a>' )
		);
		$content .= self::table_end();
		return $content;

	}
}