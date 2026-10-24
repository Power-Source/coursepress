<?php
class CoursePress_Helper_JavaScript {
	protected static $is_cp_called = false;

	public static $scripts = array();
	public static $styles = array();

	// Depracated!!!
	public static function init() {}

	/**
	 * Check if current page is CP page.
	 **/
	public static function is_valid_page() {
		$course_js_pages = array(
			'coursepress_course',
			'coursepress_assessments',
			'coursepress_reports',
			'coursepress_notifications',
			'coursepress_discussions',
		);

		$valid_pages = array_merge( $course_js_pages, array(
			'coursepress_settings',
			'coursepress',
		) );

		if ( isset( $_GET['page'] ) && in_array( $_GET['page'], $valid_pages ) || 'course' == get_post_type() ) {
			if ( 'course' == get_post_type() ) {
				$_GET['page'] = $_REQUEST['page'] = 'coursepress_course';
			}
			return true;
		}

		return false;
	}

	public static function enqueue_admin_scripts() {
		if ( self::is_valid_page() ) {
			// Enqueue needed scripts for UI
			wp_enqueue_media();
		}
	}

	public static function enqueue_scripts() {
		global $pagenow;

		$is_valid_page = self::is_valid_page();

		if ( false === $is_valid_page ) {
			return;
		}

		$course_type = CoursePress_Data_Course::get_post_type_name();
		$script = CoursePress::$url . 'asset/js/coursepress.js';

		wp_enqueue_script( 'coursepress_object', $script, array(
			'jquery',
			'backbone',
			'underscore',
		), CoursePress::$version );

		// Create a dummy editor to by used by the CoursePress JS object
		ob_start();
		wp_editor( 'dummy_editor_content', 'dummy_editor_id', array(
			'wpautop' => true,
			'textarea_name' => 'dummy_editor_name',
		) );
		$dummy_editor = ob_get_clean();

		$is_super_admin = user_can( get_current_user_id(), 'manage_options' );

		$localize_array = array(
			'_ajax_url' => CoursePress_Helper_Utility::get_ajax_url(),
			'_dummy_editor' => $dummy_editor,
			'allowed_video_extensions' => wp_get_video_extensions(),
			'allowed_audio_extensions' => wp_get_audio_extensions(),
			'allowed_image_extensions' => CoursePress_Helper_Utility::get_image_extensions(),
			'allowed_extensions' => apply_filters( 'coursepress_custom_allowed_extensions', false ),
			'date_format' => get_option( 'date_format' ),
			'editor_visual' => __( 'Visuell', 'cp' ),
			'editor_text' => _x( 'Text', 'Name for the Text editor tab (formerly HTML)', 'cp' ),
			'invalid_extension_message' => __( 'Die Erweiterung der Datei ist nicht gültig. Bitte verwende eines der folgenden:', 'cp' ),
			'assessment_grid_url' => admin_url( 'admin.php?page=coursepress_assessments' ),
			'assessment_report_url' => admin_url( 'admin.php?page=coursepress_reports' ),
			'is_campus' => CP_IS_CAMPUS,
			'is_super_admin' => $is_super_admin,
			'user_caps' => CoursePress_Data_Capabilities::get_user_capabilities(),
			'server_error' => __( 'Bei der Bearbeitung Deiner Anfrage ist ein Fehler aufgetreten. Bitte versuche es später noch einmal!', 'cp' ),
			'labels' => array(
				'user_dropdown_placeholder' => __( 'Geben Deinen Benutzernamen, Vornamen und Nachnamen, oder E-Mail an', 'cp' ),
				'required_fields' => __( 'Dies ist ein Pflichtfeld!', 'cp' ),
			),
		);

		// Add course_id in edit page
		if ( $course_type == get_post_type() ) {
			$localize_array['course_id'] = get_the_ID();
		}

		// Models
		/** COURSEPRESS_COURSE */
		if ( $is_valid_page ) {

			// Load the plugin-bundled SortableJS for modern drag-drop.
			wp_enqueue_script( 'sortablejs', CoursePress::$url . 'asset/js/sortable.min.js', array(), '1.15.1', true );

			// Load fallback polyfills for jQuery UI components
			$fallback_js = CoursePress::$url . 'asset/js/jquery-ui-modern-fallback.js';
			wp_enqueue_script( 'jquery_ui_fallback', $fallback_js, array( 'jquery', 'sortablejs' ), CoursePress::$version, true );

			$coursepress_course_depends_array = array(
				'jquery',
				'backbone',
				'jquery_ui_fallback', // Must be loaded BEFORE coursepress_course.js
			);

			if ( apply_filters( 'coursepress_use_select2_student_selector', true ) ) {
				/**
				 * Deregister script to avoid conflicts, we can do it,we just
				 * load this on CP related pages.
				 */
				wp_deregister_script( 'jquery-select2' );
				wp_register_script(
					'jquery-select2',
					CoursePress::$url . 'asset/js/external/select2.min.js',
					array( 'jquery' ),
					'4.0.2',
					true
				);
				/**
				 * Deregister style to avoid conflicts, we can do it,we just
				 * load this on CP related pages.
				 */
				wp_deregister_style( 'select2' );
				$coursepress_course_depends_array[] = 'jquery-select2';
				$src = CoursePress::$url . 'asset/css/external/select2.min.css';
				wp_enqueue_style(
					'select2',
					$src,
					array(),
					'4.0.2'
				);
			}
			$script = CoursePress::$url . 'asset/js/coursepress-course.js';
			wp_enqueue_script( 'coursepress_course', $script, $coursepress_course_depends_array, CoursePress::$version );

			$script = CoursePress::$url . 'asset/js/external/jquery.treegrid.min.js';
			wp_enqueue_script( 'jquery-treegrid', $script, array(
				'jquery'
			), CoursePress::$version );

			$localize_array['instructor_role_defined'] = defined( 'COURSEPRESS_INSTRUCTOR_ROLE' );
			$localize_array['instructor_avatars'] = CoursePress_Helper_UI::get_user_avatar_array();
			$localize_array['instructor_delete_confirm'] = __( 'Bitte bestätige, dass Du den Instruktor aus diesem Kurs entfernen möchtest.', 'cp' );
			$localize_array['instructor_delete_invite_confirm'] = __( 'Bitte bestätige, dass du die Einladung der Lehrkraft aus diesem Kurs entfernen möchtest.', 'cp' );
			$localize_array['facilitator_delete_confirm'] = __( 'Bitte bestätige, dass Du den Moderator aus diesem Kurs entfernen möchtest.', 'cp' );
			$localize_array['facilitator_delete_invite_confirm'] = __( 'Bitte bestätige, dass Du die Moderatoreinladung aus diesem Kurs entfernen möchtest.', 'cp' );
			$localize_array['instructor_empty_message'] = __( 'Bitte weise einen Dozenten zu dem Kurs hinzu', 'cp' );
			$localize_array['facilitator_empty_message'] = __( 'Moderator zuordnen', 'cp' );
			$localize_array['instructor_pednding_status'] = __( 'Ausstehend', 'cp' );
			$localize_array['email_validation_pattern'] = __( '.+@.+', 'cp' );
			$localize_array['student_delete_confirm'] = __( 'Bitte bestätige, dass Du den Schüler aus diesem Kurs entfernen möchtest.', 'cp' );
			$localize_array['student_delete_all_confirm'] = __( 'Bitte bestätige, dass du ALLE Schüler aus diesem Kurs entfernen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden. Bitte vergewissere dich, dass du das auch wirklich willst.', 'cp' );

			// Discussion / Notification
			$localize_array['notification_bulk_delete'] = __( 'Bitte bestätige, dass du ALLE ausgewählten Benachrichtigungen löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden. Bitte vergewissere dich, dass du das auch wirklich willst.', 'cp' );
			$localize_array['notification_delete'] = __( 'Bitte bestätige, dass du diese Benachrichtigung löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden.', 'cp' );

			$localize_array['discussion_bulk_delete'] = __( 'Bitte bestätige, dass du ALLE ausgewählten Diskussionen löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden. Bitte stelle sicher, dass du das auch wirklich willst.', 'cp' );
			$localize_array['discussion_delete'] = __( 'Bitte bestätige, dass du diese Diskussion löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden.', 'cp' );

			if ( ! empty( $_REQUEST['id'] ) ) {
				$localize_array['course_id'] = (int) $_REQUEST['id'];
				$localize_array['course_title'] = get_the_title( $_REQUEST['id'] );
			}
		}

		// Timepicker removed - using HTML5 datetime-local input instead
		// $style_global = CoursePress::$url . 'asset/css/admin-global.css';
		// $timepicker_css = CoursePress::$url . 'asset/css/external/jquery-ui-timepicker-addon.min.css';
		// $timepicker_js = CoursePress::$url . 'asset/js/external/jquery-ui-timepicker-addon.min.js';
		// wp_enqueue_style( 'coursepress_admin_timepicker', $timepicker_css, false, CoursePress::$version );
		// wp_enqueue_script( 'coursepress_admin_timepicker', $timepicker_js, array( 'jquery-ui-slider', 'jquery-ui-datepicker' ), CoursePress::$version, true );
		// wp_enqueue_style( 'coursepress_admin_global', $style_global, array( 'jquery-datepicker' ), CoursePress::$version );

		/** COURSEPRESS_COURSE|UNIT BUILDER */
		if ( 'coursepress_course' == $_GET['page'] && isset( $_GET['tab'] ) && 'units' == $_GET['tab'] ) {
			$script = CoursePress::$url . 'asset/js/coursepress-unitsbuilder.js';

			wp_enqueue_script( 'coursepress_unit_builder', $script, array(
				'coursepress_course',
			), CoursePress::$version );

			$localize_array['unit_builder_templates'] = CoursePress_Helper_UI_Module::get_template( true );
			$localize_array['unit_builder_module_types'] = CoursePress_Helper_UI_Module::get_types();
			$localize_array['unit_builder_module_labels'] = CoursePress_Helper_UI_Module::get_labels();
			$localize_array['unit_builder_delete_module_confirm'] = __( 'Bitte bestätige, dass du dieses Modul und mögliche Schülerantworten entfernen möchtest.', 'cp' );
			$localize_array['unit_builder_delete_page_confirm'] = __( 'Bitte bestätige, dass du diese Seite entfernen möchtest. Alle Module werden auf die erste verfügbare Seite verschoben (oder du kannst sie zuerst auf anderen Seiten ablegen, bevor du diese Seite löschst).', 'cp' );
			$localize_array['unit_builder_delete_unit_confirm'] = __( 'Bitte bestätige, dass du diese Einheit und alle dazugehörigen Module und Schülerantworten entfernen möchtest.', 'cp' );
			$localize_array['unit_builder_new_unit_title'] = __( 'Unbenannte Einheit', 'cp' );
			$localize_array['unit_builder_add_answer_label'] = __( 'Antwort hinzufügen', 'cp' );
			$localize_array['unit_builder_form_pleaceholder_label'] = __( 'Platzhalter Text', 'cp' );
			$localize_array['unit_builder_form_pleaceholder_desc'] = __( 'Platzhaltertext, der in das Textfeld eingefügt wird (zusätzliche Informationen)', 'cp' );
			$localize_array['unit_builder_form']['messages']['required_fields'] = __( 'Antwortfelder dürfen nicht leer sein!
Bitte überprüfe die Module:', 'cp' );
			$localize_array['unit_builder_form']['messages']['saving_unit'] = __( 'Einheit wird gespeichert…', 'cp' );
			$localize_array['unit_builder_form']['messages']['successfully_saved'] = __( 'Die Einheit wurde erfolgreich gerettet!', 'cp' );
			$localize_array['unit_builder_form']['messages']['error_while_saving'] = __( 'Etwas ist schief gelaufen. Einheit wurde nicht gespeichert!', 'cp' );
			$localize_array['unit_builder']['question_type'] = array(
				'single' => __( 'Einfach-Auswahl', 'cp' ),
				'multiple' => __( 'Mehrfachauswahl', 'cp' ),
				'short' => __( 'Kurze Antwort', 'cp' ),
				'long' => __( 'Lange Antwort', 'cp' ),
				'selectable' => __( 'Wählbare Auswahl', 'cp' ),
			);
			$localize_array['unit_builder_form']['messages']['adding_module'] = __( 'Warte, Modul jetzt hinzufügen...', 'cp' );
			$localize_array['unit_l8n'] = array(
				'pre_answers' => array(
					'a' => __( 'Antwort A', 'cp' ),
					'b' => __( 'Antwort B', 'cp' ),
				),
			);
		}

		/** COURSE LIST */
		$screen = get_current_screen();
		if ( 'coursepress_course' === $_GET['page'] && 'edit.php' == $pagenow && 'edit-course' == $screen->id ) {
			$script = CoursePress::$url . 'asset/js/coursepress-courselist.js';
			wp_enqueue_script( 'coursepress_course_list', $script, array(
				'jquery',
				'backbone',
			), CoursePress::$version );

			$localize_array['courselist_bulk_delete'] = __( 'Bitte bestätige, dass du ALLE ausgewählten Kurse löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden. Bitte vergewissere dich, dass du das auch wirklich willst.', 'cp' );
			$localize_array['courselist_delete_course'] = __( 'Bitte bestätige, dass du diese Kurse löschen möchtest. Achtung! Dies kann nicht rückgängig gemacht werden.', 'cp' );
			$localize_array['courselist_duplicate_course'] = __( 'Bist du sicher, dass du eine Kopie dieses Kurses erstellen möchtest?', 'cp' );
			$localize_array['courselist_export'] = __( 'Bitte wähle mindestens einen Kurs zum Exportieren aus.', 'cp' );
		}

		if ( 'coursepress_assessments' === $_GET['page'] ) {
			$script = CoursePress::$url . '/asset/js/coursepress-assessment.js';
			wp_enqueue_script( 'coursepress_assessment',
				$script,
				null,
			CoursePress::$version );
			$localize_array['courseinstructor_id'] = get_current_user_id();
			$localize_array['instructor_name'] = CoursePress_Helper_Utility::get_user_name( get_current_user_id(), true );
			$localize_array['assessment_labels'] = array(
				'pass' => __( 'Bestanden', 'cp' ),
				'fail' => __( 'Fehlgeschlagen', 'cp' ),
				'add_feedback' => __( 'Feedback geben', 'cp' ),
				'edit_feedback' => __( 'Feedback bearbeiten', 'cp' ),
				'cancel_feedback' => __( 'Abbrechen', 'cp' ),
				'help_tooltip' => __( 'Wenn der Kurs bei Einreichung als erfolgreich abgeschlossen ist, wird eine E-Mail mit dem Zertifikat automatisch versendet.', 'cp' ),
				'minimum_help' => __( 'Du kannst die Mindestbewertung in den Kurseinstellungen ändern.', 'cp' ),
			);
		}

		/**
		 * save unit message.
		 */
			$localize_array['unit_builder_form']['messages']['setup']['saving'] = __( 'Schritt wird jetzt gespeichert…', 'cp' );
			$localize_array['unit_builder_form']['messages']['setup']['saved'] = __( 'Der Schritt wurde erfolgreich gespeichert!', 'cp' );
			$localize_array['unit_builder_form']['messages']['setup']['error'] = __( 'Etwas ist schief gelaufen. Schritt wurde nicht gespeichert!', 'cp' );

		wp_localize_script( 'coursepress_object', '_coursepress', $localize_array );
	}

	public static function enqueue_front_scripts() {
		global $wp_query;

		// See if we are inside a course.
		$is_cp = CoursePress_Helper_Utility::the_course( true );

		if ( ! $is_cp ) {
			// See if we are on a special CoursePress page.
			$post_type = get_post_type();
			$valid_cpt = array(
				CoursePress_Data_Course::get_post_type_name(),
				'course_notifications_archive',
				'course_workbook',
				'course_discussion_archive',
				'course_discussion',
				'course_archive',
				'coursepress_instructor', // virtual post type
				'coursepress_student_dashboard',
				'coursepress_student_login',
				'coursepress_student_signup',
				CoursePress_Data_Discussion::get_post_type_name(),
			);
			$is_cp = in_array( $post_type, $valid_cpt );
		}
		if ( ! $is_cp ) {
			// Check if there is a course object in wp_query.
			$is_cp = isset( $wp_query->query['course'] );
		}
		if ( ! $is_cp ) {
			// Check if there is a course object in wp_query.
			$is_cp = isset( $wp_query->query['coursename'] );
		}

		// Stop here, if front-end page does not contain CoursePress data!
		if ( ! $is_cp ) { return; }

		// CoursePress Object
		$script = CoursePress::$url . 'asset/js/coursepress.js';
		wp_enqueue_script(
			'coursepress_object',
			$script,
			array(
				'jquery',
				'backbone',
				'underscore',
			),
			CoursePress::$version
		);

		self::coursepress_front_js();

		$course_id = CoursePress_Helper_Utility::the_course( true );

		$localize_array = array(
			'_ajax_url' => CoursePress_Helper_Utility::get_ajax_url(),
			'allowed_video_extensions' => wp_get_video_extensions(),
			'allowed_audio_extensions' => wp_get_audio_extensions(),
			'allowed_image_extensions' => CoursePress_Helper_Utility::get_image_extensions(),
			'allowed_extensions' => apply_filters( 'coursepress_custom_allowed_extensions', false ),
			'allowed_student_extensions' => CoursePress_Helper_Utility::allowed_student_mimes(),
			'no_browser_upload' => __( 'Bitte versuche einen anderen Browser, um deine Datei hochzuladen.', 'cp' ),
			'invalid_upload_message' => __( 'Bitte laden Sie nur eine der folgenden Dateien hoch: ', 'cp' ),
			'file_uploaded_message' => __( 'Dein Beitrag wurde erfolgreich gesendet.', 'cp' ),
			'file_upload_fail_message' => __( 'Leider gab es ein Problem bei der Bearbeitung deiner Datei.', 'cp' ),
			'response_saved_message' => __( 'Deine Antwort wurde erfolgreich aufgezeichnet.', 'cp' ),
			'response_fail_message' => __( 'Es gab ein Problem beim Speichern Deiner Antwort. Bitte lade diese Seite neu und versuche es erneut.', 'cp' ),
			'current_course' => $course_id,
			'current_course_is_paid' => CoursePress_Data_Course::is_paid_course( $course_id )? 'yes':'no',
			'current_course_type' => CoursePress_Data_Course::get_setting( $course_id, 'enrollment_type', 'manually' ),
			'course_url' => get_permalink( CoursePress_Helper_Utility::the_course( true ) ),
			'home_url' => home_url(),
			'current_student' => get_current_user_id(),
			'workbook_view_answer' => __( 'Anzeigen', 'cp' ),
			'labels' => CoursePress_Helper_UI_Module::get_labels(),
			'signup_errors' => array(
				'all_fields' => __( 'Alle Felder müssen ausgefüllt werden.', 'cp' ),
				'email_invalid' => __( 'Ungültige E-Mail-Adresse.', 'cp' ),
				'email_exists' => __( 'Diese E-Mail-Adresse ist bereits vergeben.', 'cp' ),
				'user_exists' => __( 'Der Benutzername ist bereits vergeben.', 'cp' ),
				'weak_password' => __( 'Schwache Passwörter sind nicht erlaubt.', 'cp' ),
				'mismatch_password' => __( 'Passwörter stimmen nicht überein.', 'cp' ),
			),
			'comments' => array(
				'require_valid_comment' => __( 'Bitte gib einen Kommentar ein.', 'cp' ),
			),
		);

		/**
		 * add unit-not-available url
		 */
		$url = $localize_array['course_url'].CoursePress_Core::get_slug( 'units/' );
		$localize_array['course_url_unit_nor_available'] = CoursePress_Helper_Message::add_message_query_arg( $url, 'unit-not-available' );

		/**
		 * Filter localize script to allow data insertion.
		 *
		 * @since 2.0
		 *
		 * @param (array) $localize_array.
		 **/
		$localize_array = apply_filters( 'coursepress_localize_object', $localize_array );

		wp_localize_script(
			'coursepress_object',
			'_coursepress',
			$localize_array
		);

		$script = CoursePress::$url . 'asset/js/external/circle-progress.min.js';
		wp_enqueue_script(
			'circle-progress',
			$script,
			array( 'jquery' ),
			CoursePress::$version
		);

		$script = CoursePress::$url . 'asset/js/external/backbone.modal-min.js';
		wp_enqueue_script(
			'backbone-modal',
			$script,
			array(
				'backbone',
				'password-strength-meter',
			),
			CoursePress::$version
		);

		$fontawesome = CoursePress::$url . 'asset/css/external/font-awesome.min.css';
		wp_enqueue_style(
			'fontawesome',
			$fontawesome,
			array(),
			CoursePress::$version
		);

		$front_css = CoursePress::$url . 'asset/css/front.css';
		wp_enqueue_style( 'coursepress-front', $front_css, array(), CoursePress::$version );
	}

	public static function maybe_print_assets() {
		if ( CoursePress_Core::$is_cp_page ) {
			if ( false == self::$is_cp_called ) {
				// Load the script
				self::front_assets();
			}
		}

		if ( self::$is_cp_called && false === is_user_logged_in() ) {
			// Print enrollment templates
			echo do_shortcode( '[coursepress_enrollment_templates]' );
		}
	}

	public static function print_front_ajax_url() {
		printf(
			'<script>window.ajaxurl = window.ajaxurl || %s;</script>',
			wp_json_encode( CoursePress_Helper_Utility::get_ajax_url() )
		);
	}

	public static function front_assets() {
		$is_course = CoursePress_Data_Course::get_post_type_name() === get_post_type();
		if ( false === CoursePress_Core::$is_cp_page && ! $is_course ) {
			return;
		}

		self::$is_cp_called = true;
		$script_url = CoursePress::$url . 'asset/js/';
		$css_url = CoursePress::$url . 'asset/css/';
		$version = CoursePress::$version;
		$course_id = CoursePress_Helper_Utility::the_course( true );

		// Fontawesome
		$fontawesome = $css_url . 'external/font-awesome.min.css';
		wp_enqueue_style( 'fontawesome', $fontawesome, array(), $version );
		$bbm_modal_css = $css_url . 'bbm.modal.css';
		wp_enqueue_style( 'coursepress-modal-css', $bbm_modal_css, array(), $version );
		// Front CSS
		wp_enqueue_style( 'coursepress-front-css', $css_url . 'front.css', array( 'dashicons', 'wp-mediaelement' ), $version );

		wp_enqueue_script( 'comment-reply' );

		$script = $script_url . 'external/circle-progress.min.js';
		wp_enqueue_script( 'circle-progress', $script, array( 'jquery' ), $version );

		$modal_script_url = $script_url . 'external/backbone.modal-min.js';
		wp_enqueue_script( 'coursepress-backbone-modal', $modal_script_url, array( 'jquery', 'backbone', 'underscore', 'password-strength-meter' ) );

		$deps = array( 'underscore', 'wp-mediaelement' );
		wp_enqueue_script( 'coursepress-front-js', $script_url . 'front.js', $deps, $version );

		$localize_array = array(
			'_ajax_url' => CoursePress_Helper_Utility::get_ajax_url(),
			'cpnonce' => wp_create_nonce( 'coursepress_nonce' ),
			'allowed_video_extensions' => wp_get_video_extensions(),
			'allowed_audio_extensions' => wp_get_audio_extensions(),
			'allowed_image_extensions' => CoursePress_Helper_Utility::get_image_extensions(),
			'allowed_extensions' => apply_filters( 'coursepress_custom_allowed_extensions', false ),
			'allowed_student_extensions' => CoursePress_Helper_Utility::allowed_student_mimes(),
			'no_browser_upload' => __( 'Bitte versuche einen anderen Browser, um deine Datei hochzuladen.', 'cp' ),
			'invalid_upload_message' => __( 'Ungültiges Dateiformat!', 'cp' ),
			'file_uploaded_message' => __( 'Dein Beitrag wurde erfolgreich gesendet.', 'cp' ),
			'file_upload_fail_message' => __( 'Leider gab es ein Problem bei der Bearbeitung deiner Datei.', 'cp' ),
			'response_saved_message' => __( 'Deine Antwort wurde erfolgreich aufgezeichnet.', 'cp' ),
			'response_fail_message' => __( 'Es gab ein Problem beim Speichern Deiner Antwort. Bitte lade diese Seite neu und versuche es erneut.', 'cp' ),
			'current_course_is_paid' => CoursePress_Data_Course::is_paid_course( $course_id )? 'yes':'no',
			'current_course_type' => CoursePress_Data_Course::get_setting( $course_id, 'enrollment_type', 'manually' ),
			'course_url' => get_permalink( CoursePress_Helper_Utility::the_course( true ) ),
			'home_url' => home_url(),
			'current_student' => get_current_user_id(),
			'workbook_view_answer' => __( 'Anzeigen', 'cp' ),
			'labels' => CoursePress_Helper_UI_Module::get_labels(),
			'signup_errors' => array(
				'all_fields' => __( 'Alle Felder sind erforderlich.', 'cp' ),
				'email_invalid' => __( 'Ungültige E-Mail-Adresse.', 'cp' ),
				'email_exists' => __( 'Diese E-Mail-Adresse ist bereits vergeben.', 'cp' ),
				'user_exists' => __( 'Der Benutzername ist bereits vergeben.', 'cp' ),
				'weak_password' => __( 'Schwache Passwörter sind nicht erlaubt.', 'cp' ),
				'mismatch_password' => __( 'Passwörter stimmen nicht überein.', 'cp' ),
			),
			'login_errors' => array(
				'required' => __( 'Du brauchst deinen Benutzernamen und/oder dein Passwort!', 'cp' ),
			),
			'comments' => array(
				'require_valid_comment' => __( 'Ooops! Du hast noch nicht geschrieben!', 'cp' ),
			),
			'server_error' => __( 'Ein unerwarteter Fehler trat während der Verarbeitung auf. Bitte versuche es erneut.', 'cp' ),
			'module_error' => array(
				'required' => __( 'Du musst dieses Modul ausfüllen!', 'cp' ),
				'normal_required' => __( 'Du musst alle erforderlichen Module abschließen!', 'cp' ),
				'participate' => __( 'Deine Teilnahme an der Diskussion ist erforderlich!', 'cp' ),
				'passcode_required' => __( 'PASSCODE eingeben!', 'cp' ),
				'invalid_passcode' => __( 'Ungültiges Passwort', 'cp' ),
			),
			'confirmed_withdraw' => __( 'Bitte bestätige, dass Du dich vom Kurs austragen möchtest. Wenn Du dich zurückziehst, werden alle Unterlagen und der Zugang zu diesem Kurs entfernt.', 'cp' ),
			'confirmed_edit' => __( 'Bitte bestätige, dass Du diesen Kurs bearbeiten möchtest.', 'cp' ),
			'buttons' => array(
				'ok' => __( 'OK', 'cp' ),
				'cancel' => __( 'Abbrechen', 'cp' ),
			),
			'password_strength_meter_enabled' => CoursePress_Helper_Utility::is_password_strength_meter_enabled()
		);

		/**
		 * Filter localize script to allow data insertion.
		 *
		 * @since 2.0
		 *
		 * @param (array) $localize_array.
		 **/
		$localize_array = apply_filters( 'coursepress_localize_object', $localize_array );

		wp_localize_script( 'coursepress-front-js', '_coursepress', $localize_array );

		$script = CoursePress::$url . 'asset/js/external/video.min.js';
		wp_enqueue_script(
			'coursepress-video-js',
			$script,
			array('jquery'),
			CoursePress::$version
		);

		$script = CoursePress::$url . 'asset/js/external/video-youtube.min.js';
		wp_enqueue_script(
			'coursepress-video-youtube-js',
			$script,
			array('jquery', 'coursepress-video-js'),
			CoursePress::$version
		);

		$script = CoursePress::$url . 'asset/js/external/videojs-vimeo.min.js';
		wp_enqueue_script(
			'coursepress-videojs-vimeo-js',
			$script,
			array('jquery', 'coursepress-video-js'),
			'3.0.0'
		);

		$video_js = CoursePress::$url . 'asset/css/external/video-js.min.css';
		wp_enqueue_style(
			'coursepress-video-js-style',
			$video_js,
			array(),
			CoursePress::$version
		);
	}

	/**
	 * coursepress-front_js
	 *
	 * @since 2.0.7
	 */
	public function coursepress_front_js() {
		$script = CoursePress::$url . 'asset/js/coursepress-front.js';
		wp_enqueue_script(
			'coursepress_front',
			$script,
			array(
				'jquery',
				'underscore',
				'backbone',
			),
			CoursePress::$version,
			true
		);

		$dependencies = array( 'jquery' );
		if ( function_exists( 'wp_enqueue_code_editor' ) ) {
			wp_enqueue_code_editor( array( 'type' => 'text/plain' ) );
			$dependencies[] = 'wp-codemirror';
		}

		wp_enqueue_script(
			'coursepress-code-editor',
			CoursePress::$url . 'asset/js/coursepress-code-editor.js',
			$dependencies,
			CoursePress::$version,
			true
		);
	}
}