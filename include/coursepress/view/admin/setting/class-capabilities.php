<?php
/**
 * Admin view.
 *
 * @package CoursePress
 */

/**
 * Capabilities for Instructors.
 */
class CoursePress_View_Admin_Setting_Capabilities {

	public static function init() {
		add_filter(
			'coursepress_settings_tabs',
			array( __CLASS__, 'add_tabs' )
		);
		add_action(
			'coursepress_settings_process_capabilities',
			array( __CLASS__, 'process_form' ),
			10, 2
		);
		add_filter(
			'coursepress_settings_render_tab_capabilities',
			array( __CLASS__, 'return_content' ),
			10, 3
		);
	}

	public static function add_tabs( $tabs ) {
		if ( current_user_can( 'manage_options' ) ) {
			/*
			 * Instructors can be allowed to access the Settings submenu.
			 * But the "Instructor Capabilities" tab is only available to
			 * WordPress admins, so instructors cannot edit their own caps...
			 */
			$tabs['capabilities'] = array(
				'title' => __( 'Instruktor Berechtigungen', 'cp' ),
				'description' => sprintf(
					'%s %s',
					__( 'Hier kannst du entscheiden, was deine Lehrkräfte auf deiner Seite tun können. Das sind spezielle Funktionen, die nur für CoursePress relevant sind.', 'cp' ),
					__( 'HINWEIS: Aus Sicherheitsgründen ist diese Seite nur für WordPress-Administratoren zugänglich!', 'cp' )
				),
				'order' => 30,
			);
		}

		return $tabs;
	}

	public static function return_content( $content, $slug, $tab ) {
		$instructor_capabilities = CoursePress_Data_Capabilities::get_instructor_capabilities();
		$boxes = self::_capability_boxes();

		ob_start();
		?>
		<input type="hidden" name="page" value="' . esc_attr( $slug ) . '"/>
		<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '"/>
		<input type="hidden" name="action" value="updateoptions"/>
		<?php wp_nonce_field( 'update-coursepress-options', '_wpnonce' ); ?>

		<div class="capability-list">

		<?php foreach ( $boxes as $group => $data ) : ?>
			<div class="cp-content-box <?php echo esc_attr( $group ); ?>">
			<h3 class="hndle">
				<span><?php echo esc_html( $data['title'] ); ?></span>
			</h3>
			<div class="inside">
				<table class="form-table compressed">
					<tbody id="items">

						<?php foreach ( $data['items'] as $key => $value ) : ?>
							<?php $checked = ! empty( $instructor_capabilities[ $key ] ); ?>
							<?php $name = 'coursepress_settings[instructor][capabilities][' . $key . ']'; ?>

							<tr class="<?php echo esc_attr( $key ); ?>">
								<td>
									<label>
										<input type="checkbox"
											<?php checked( $checked ); ?>
											name="<?php echo esc_attr( $name ); ?>"
											value="1" />
										<?php echo esc_html( $value ); ?>
									</label>
								</td>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>
			</div>
		<?php endforeach; ?>

		</div>
		<?php

		$content = ob_get_clean();

		return $content;
	}

	private static function _capability_boxes() {
		$options = array(
			'general' => array(
				'title' => __( 'Allgemein', 'cp' ),
				'items' => self::_instructor_capabilities_general(),
			),
			'course' => array(
				'title' => __( 'Kurse', 'cp' ),
				'items' => self::_instructor_capabilities_courses(),
			),
			'course-category' => array(
				'title' => __( 'Kurskategorien', 'cp' ),
				'items' => self::_instructor_capabilities_course_categories(),
			),
			'course-unit' => array(
				'title' => __( 'Einheiten', 'cp' ),
				'items' => self::_instructor_capabilities_units(),
			),
			'instructor' => array(
				'title' => __( 'Trainer', 'cp' ),
				'items' => self::_instructor_capabilities_instructors(),
			),
			'facilitator' => array(
				'title' => __( 'Erleichterer', 'cp' ),
				'items' => self::_facilitator_capabilities(),
			),
			'student' => array(
				'title' => __( 'Teilnehmer', 'cp' ),
				'items' => self::_instructor_capabilities_students(),
			),
			'notification' => array(
				'title' => __( 'Benachrichtigungen', 'cp' ),
				'items' => self::_instructor_capabilities_notifications(),
			),
			'discussion' => array(
				'title' => __( 'Diskussionen', 'cp' ),
				'items' => self::_instructor_capabilities_discussions(),
			),
		);
		/**
		 * Add this capabilities only when MarketPress is acctive.
		 */
		$is_marketpress_active = apply_filters( 'coursepress_is_marketpress_active', false );
		if ( $is_marketpress_active ) {
			$options['wordpress'] = array(
				'title' => __( 'Gewährung von Standard-WordPress-Funktionen', 'cp' ),
				'items' => self::_instructor_capabilities_posts_and_pages(),
			);
		}
		return $options;
	}

	private static function _instructor_capabilities_general() {
		return array(
			'coursepress_dashboard_cap' => __( 'Siehe das Hauptmenü von CoursePress', 'cp' ),
			'coursepress_courses_cap' => __( 'Zugriff auf die Untermenüs der Kurse', 'cp' ),
			// 'coursepress_instructors_cap' => __( 'Access the Intructors submenu', 'cp' ),
			'coursepress_students_cap' => __( 'Zugriff auf das Untermenü Schüler', 'cp' ),
			'coursepress_assessment_cap' => __( 'Zugriff auf das Untermenü Bewertung', 'cp' ),
			'coursepress_reports_cap' => __( 'Zugriff auf das Untermenü Berichte', 'cp' ),
			'coursepress_notifications_cap' => __( 'Zugriff auf das Untermenü "Benachrichtigungen', 'cp' ),
			'coursepress_discussions_cap' => __( 'Zugriff auf das Untermenü Forum', 'cp' ),
			'coursepress_settings_cap' => __( 'Zugriff auf das Untermenü "Einstellungen', 'cp' ),
		);
	}

	private static function _instructor_capabilities_courses() {
		return array(
			'coursepress_create_course_cap' => __( 'Neuen Kurs anlegen', 'cp' ),
			'coursepress_view_others_course_cap' => __( 'Andere Ausbilderkurse ansehen', 'cp' ),
			'coursepress_update_my_course_cap' => __( 'Eigene Kurse aktualisieren', 'cp' ),
			'coursepress_update_course_cap' => __( 'Jeden Kurs aktualisieren', 'cp' ),
			// 'coursepress_update_all_courses_cap' => __( 'Update ANY course', 'cp' ),
			'coursepress_delete_my_course_cap' => __( 'Eigene Kurse löschen', 'cp' ),
			'coursepress_delete_course_cap' => __( 'Einen zugewiesenen Kurs löschen', 'cp' ),
			// 'coursepress_delete_all_courses_cap' => __( 'Delete ANY course', 'cp' ),
			'coursepress_change_my_course_status_cap' => __( 'Status der eigenen Kurse ändern', 'cp' ),
			'coursepress_change_course_status_cap' => __( 'Status eines zugewiesenen Kurses ändern', 'cp' ),
			// 'coursepress_change_all_courses_status_cap' => __( 'Change status of ALL course', 'cp' ),
		);
	}

	private static function _instructor_capabilities_course_categories() {
		return array(
			'coursepress_course_categories_manage_terms_cap' => __( 'Kategorien anzeigen und erstellen', 'cp' ),
			'coursepress_course_categories_edit_terms_cap' => __( 'Jede Kategorie bearbeiten', 'cp' ),
			'coursepress_course_categories_delete_terms_cap' => __( 'Jede Kategorie löschen', 'cp' ),
		);
	}

	private static function _facilitator_capabilities() {
		return array(
			'coursepress_assign_my_course_facilitator_cap' => __( 'Vermittler für eigenen Kurs zuweisen', 'cp' ),
			'coursepress_assign_facilitator_cap' => __( 'Vermittler einem beliebigen Kurs zuweisen', 'cp' ),
		);
	}

	private static function _instructor_capabilities_units() {
		return array(
			'coursepress_create_course_unit_cap' => __( 'Neue Kurslektionen anlegen', 'cp' ),
			'coursepress_view_all_units_cap' => __( 'Einheiten in jedem Kurs ansehen (auch von anderen Ausbildern)', 'cp' ),
			'coursepress_update_my_course_unit_cap' => __( 'Eigene Einheiten aktualisieren', 'cp' ),
			'coursepress_update_course_unit_cap' => __( 'Aktualisiere jede Einheit innerhalb der zugewiesenen Kurse', 'cp' ),
			// 'coursepress_update_all_courses_unit_cap' => __( 'Update units of ALL courses', 'cp' ),
			'coursepress_delete_my_course_units_cap' => __( 'Eigene Einheiten löschen', 'cp' ),
			'coursepress_delete_course_units_cap' => __( 'Jede Einheit innerhalb der zugewiesenen Kurse löschen', 'cp' ),
			// 'coursepress_delete_all_courses_units_cap' => __( 'Delete units of ALL courses', 'cp' ),
			'coursepress_change_my_course_unit_status_cap' => __( 'Status der eigenen Einheiten ändern', 'cp' ),
			'coursepress_change_course_unit_status_cap' => __( 'Änderung des Status einer Einheit innerhalb der zugewiesenen Kurse', 'cp' ),
			// 'coursepress_change_all_courses_unit_status_cap' => __( 'Change status of any unit of ALL courses', 'cp' ),
		);
	}

	private static function _instructor_capabilities_instructors() {
		return array(
			'coursepress_assign_and_assign_instructor_my_course_cap' => __( 'Weisen Sie anderen Ausbildern eigene Kurse zu', 'cp' ),
			'coursepress_assign_and_assign_instructor_course_cap' => __( 'Andere Lehrkräfte einem Kurs zuweisen', 'cp' ),
		);
	}

	private static function _instructor_capabilities_students() {
		return array(
			'coursepress_invite_my_students_cap' => __( 'Schüler zu eigenen Kursen einladen', 'cp' ),
			'coursepress_invite_students_cap' => __( 'Schüler zu jedem Kurs einladen', 'cp' ),
			'coursepress_withdraw_my_students_cap' => __( 'Schüler aus eigenen Kursen zurückziehen', 'cp' ),
			'coursepress_withdraw_students_cap' => __( 'Schüler aus einem Kurs zurückziehen', 'cp' ),
			'coursepress_add_move_my_students_cap' => __( 'Schüler zu eigenen Kursen hinzufügen', 'cp' ),
			'coursepress_add_move_students_cap' => __( 'Studenten zu allen Kursen hinzufügen', 'cp' ),
			'coursepress_add_move_my_assigned_students_cap' => __( 'Schüler zu zugewiesenen Kursen hinzufügen', 'cp' ),
			// 'coursepress_change_my_students_group_class_cap' => __( 'Change students group within own courses', 'cp' ),
			// 'coursepress_change_students_group_class_cap' => __( 'Change students group in any course', 'cp' ),
			//'coursepress_send_bulk_my_students_email_cap' => __( 'Send bulk email to students of own courses', 'cp' ),
			//'coursepress_send_bulk_students_email_cap' => __( 'Send bulk email to all students', 'cp' ),
			//'coursepress_add_new_students_cap' => __( 'Create new users with student role to the blog', 'cp' ),
			//'coursepress_delete_students_cap' => __( 'Delete students (deletes ALL associated course records)', 'cp' ),
		);
	}

	private static function _instructor_capabilities_notifications() {
		return array(
			'coursepress_create_my_notification_cap' => __( 'Neue Benachrichtigungen für eigene Kurse erstellen', 'cp' ),
			'coursepress_create_my_assigned_notification_cap' => __( 'Neue Benachrichtigungen für zugewiesene Kurse erstellen', 'cp' ),
			'coursepress_update_my_notification_cap' => __( 'Eigene veröffentlichte Meldung aktualisieren', 'cp' ),
			'coursepress_update_notification_cap' => __( 'Jede Benachrichtigung aktualisieren', 'cp' ),
			'coursepress_delete_my_notification_cap' => __( 'Eigene Benachrichtigungen löschen', 'cp' ),
			'coursepress_delete_notification_cap' => __( 'Jede Benachrichtigung löschen', 'cp' ),
			'coursepress_change_my_notification_status_cap' => __( 'Status der eigenen Benachrichtigungen ändern', 'cp' ),
			'coursepress_change_notification_status_cap' => __( 'Status jeder Benachrichtigung ändern', 'cp' ),
		);
	}

	private static function _instructor_capabilities_discussions() {
		return array(
			'coursepress_create_my_discussion_cap' => __( 'Neue Diskussionen für eigene Kurse erstellen', 'cp' ),
			'coursepress_create_my_assigned_discussion_cap' => __( 'Neue Diskussionen für zugewiesene Kurse erstellen', 'cp' ),
			'coursepress_update_my_discussion_cap' => __( 'Eigene veröffentlichte Diskussionen aktualisieren', 'cp' ),
			'coursepress_update_discussion_cap' => __( 'Jede Diskussion aktualisieren', 'cp' ),
			'coursepress_delete_my_discussion_cap' => __( 'Eigene Diskussionen löschen', 'cp' ),
			'coursepress_delete_discussion_cap' => __( 'Jede Diskussion löschen', 'cp' ),
			'coursepress_change_my_discussion_status_cap' => __( 'Status der eigenen Diskussionen ändern', 'cp' ),
			'coursepress_change_discussion_status_cap' => __( 'Status jeder Diskussion ändern', 'cp' ),
		);
	}

	private static function _instructor_capabilities_posts_and_pages() {
		return array(
			'edit_pages' => __( 'Seiten editieren', 'cp' ),
			'edit_published_pages' => __( 'Veröffentlichte Seiten editieren', 'cp' ),
			'edit_posts' => __( 'Beiträge bearbeiten', 'cp' ),
			'publish_pages' => __( 'Seiten veröffentlichen', 'cp' ),
			'publish_posts' => __( 'Beiträge veröffentlichen', 'cp' ),
		);
	}


	public static function process_form( $page, $tab ) {
		if ( ! isset( $_POST['action'] ) ) { return; }
		if ( 'updateoptions' != $_POST['action'] ) { return; }
		if ( 'capabilities' != $tab ) { return; }
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'update-coursepress-options' ) ) { return; }

		$settings = CoursePress_Core::get_setting( false ); // false: Get all settings.
		$post_settings = (array) $_POST['coursepress_settings'];

		// Sanitize $post_settings, especially to fix up unchecked checkboxes.
		$caps = array_keys( CoursePress_Data_Capabilities::$capabilities['instructor'] );
		$set_caps = array_keys( $post_settings['instructor']['capabilities'] );

		foreach ( $caps as $cap ) {
			$is_set = in_array( $cap, $set_caps );
			$post_settings['instructor']['capabilities'][ $cap ] = $is_set;
		}

		// Don't replace settings if there is nothing to replace.
		if ( ! empty( $post_settings ) ) {
			CoursePress_Core::update_setting(
				false, // False will replace all settings.
				CoursePress_Core::merge_settings( $settings, $post_settings )
			);
		}
	}
}