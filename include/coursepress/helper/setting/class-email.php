<?php

class CoursePress_Helper_Setting_Email {

	public static function get_defaults( $context = false ) {
		add_filter( 'coursepress_admin_setting_before_top_save', array( __CLASS__, 'add_buttons' ), 10, 2 );
		$defaults = apply_filters(
			'coursepress_default_email_settings',
			array(
				CoursePress_Helper_Email::BASIC_CERTIFICATE => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => CoursePress_View_Admin_Setting_BasicCertificate::default_email_subject(),
					'content' => CoursePress_View_Admin_Setting_BasicCertificate::default_email_content(),
					'auto_email' => true,
				),
				CoursePress_Helper_Email::REGISTRATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Registrierungs-Status', 'cp' ),
					'content' => self::_registration_email(),
				),
				CoursePress_Helper_Email::ENROLLMENT_CONFIRM => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Bestätigung', 'cp' ),
					'content' => self::_enrollment_confirmation_email(),
				),
				CoursePress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Neue Einschreibung In Deinem Kurs', 'cp' ),
					'content' => self::_instructor_enrollment_notification_email(),
				),
				CoursePress_Helper_Email::COURSE_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Einladung zu einem Kurs', 'cp' ),
					'content' => self::_course_invitation_email(),
				),
				CoursePress_Helper_Email::COURSE_INVITATION_PASSWORD => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Einladung zu einem Kurs ( Psss...nur für ausgewählte)', 'cp' ),
					'content' => self::_course_invitation_passcode_email(),
				),
				CoursePress_Helper_Email::INSTRUCTOR_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => sprintf( __( 'Einladung zur Ausbildertätigkeit bei %s', 'cp' ), get_option( 'blogname' ) ),
					'content' => self::_instructor_invitation_email(),
				),
				CoursePress_Helper_Email::FACILITATOR_INVITATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => sprintf( __( 'Einladung als Moderator für den Kurs %s', 'cp' ), get_option( 'blogname' ) ),
					'content' => self::_facilitator_invitation_email(),
				),
				CoursePress_Helper_Email::NEW_ORDER => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Eingangsbestätigung', 'cp' ),
					'content' => self::_new_order_email(),
				),
				CoursePress_Helper_Email::COURSE_START_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Kursstart-Benachrichtigung', 'cp' ),
					'content' => self::course_start_defaults(),
				),
				CoursePress_Helper_Email::DISCUSSION_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Diskussion Notifizierung', 'cp' ),
					'content' => self::discussion_defaults(),
				),
				CoursePress_Helper_Email::UNIT_STARTED_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( '[UNIT_TITLE] ist jetzt verfügbar', 'cp' ),
					'content' => self::unit_started_defaults(),
				),
				CoursePress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION => array(
					'enabled' => '1',
					'from' => get_option( 'blogname' ),
					'email' => get_option( 'admin_email' ),
					'subject' => __( 'Neues Feedback', 'cp' ),
					'content' => self::instructor_feedback_module_defaults(),
				),
			)
		);

		if ( $context && isset( $defaults[ $context ] ) ) {
			return $defaults[ $context ];
		} else {
			return $defaults;
		}
	}

	public static function get_settings_sections() {
		$basic_certificate_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::BASIC_CERTIFICATE,
			array(
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'COURSE_ADDRESS' => '',
				'FIRST_NAME' => '',
				'LAST_NAME' => '',
				'COURSE_NAME' => '',
				'COMPLETION_DATE' => '',
				'CERTIFICATE_NUMBER' => '',
				'CERTIFICATE_URL' => '',
				'UNIT_LIST' => '',
			),
			null
		);
		$registration_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::REGISTRATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'STUDENT_USERNAME' => '',
				'STUDENT_PASSWORD' => '',
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
			),
			null
		);
		$enrollment_confirm = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::ENROLLMENT_CONFIRM,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'BLOG_NAME' => '',
				'LOGIN_ADDRESS' => '',
				'COURSES_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'COURSE_ADDRESS' => '',
			),
			null
		);
		$instructor_enrollment_notification = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'COURSE_TITLE' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_ADMIN_ADDRESS' => '',
				'COURSE_STUDENTS_ADMIN_ADDRESS' => '',
				'WEBSITE_NAME' => '',
				'WEBSITE_ADDRESS' => ''
			)
		);
		$course_invitation_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::COURSE_INVITATION,
			array(
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'COURSE_NAME' => '',
				'COURSE_EXCERPT' => '',
				'COURSE_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'PASSCODE' => '',
			),
			null
		);
		$instructor_invitation_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::INSTRUCTOR_INVITATION,
			array(
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'INSTRUCTOR_EMAIL' => '',
				'CONFIRMATION_LINK' => '',
				'COURSE_NAME' => '',
				'COURSE_EXCERPT' => '',
				'COURSE_ADDRESS' => '',
				'WEBSITE_ADDRESS' => '',
				'WEBSITE_NAME' => '',
			),
			null
		);
		$course_start_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::COURSE_START_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_OVERVIEW' => '',
				'BLOG_NAME' => '',
				'WEBSITE_ADDRESS' => '',
				'UNSUBSCRIBE_LINK' => '',
			)
		);
		$discussion_fields = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::DISCUSSION_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'COURSE_OVERVIEW' => '',
				'BLOG_NAME' => '',
				'WEBSITE_ADDRESS' => '',
				'COMMENT_MESSAGE' => '',
				'COURSE_DISCUSSION_ADDRESS' => '',
				'UNSUBSCRIBE_LINK' => '',
				'COMMENT_AUTHOR' => '',
			)
		);
		$units_started = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::UNIT_STARTED_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'UNIT_TITLE' => '',
				'UNIT_OVERVIEW' => '',
				'UNIT_ADDRESS' => '',
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'UNSUBSCRIBE_LINK' => '',
			)
		);
		$instructor_module_feedback = apply_filters( 'coursepress_fields_' . CoursePress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION,
			array(
				'COURSE_NAME' => '',
				'COURSE_ADDRESS' => '',
				'CURRENT_UNIT' => '',
				'CURRENT_MODULE' => '',
				'STUDENT_FIRST_NAME' => '',
				'STUDENT_LAST_NAME' => '',
				'INSTRUCTOR_FIRST_NAME' => '',
				'INSTRUCTOR_LAST_NAME' => '',
				'INSTRUCTOR_FEEDBACK' => '',
				'COURSE_GRADE' => '',
			)
		);
		$basic_certificate_fields = array_keys( $basic_certificate_fields );
		$registration_fields = array_keys( $registration_fields );
		$enrollment_confirm = array_keys( $enrollment_confirm );
		$instructor_enrollment_notification = array_keys( $instructor_enrollment_notification );
		$course_invitation_fields = array_keys( $course_invitation_fields );
		$instructor_invitation_fields = array_keys( $instructor_invitation_fields );
		$course_start_fields = array_keys( $course_start_fields );
		$discussion_fields = array_keys( $discussion_fields );
		$units_started = array_keys( $units_started );
		$instructor_module_feedback = array_keys( $instructor_module_feedback );

		$defaults = apply_filters(
			'coursepress_default_email_settings_sections',
			array(
				CoursePress_Helper_Email::BASIC_CERTIFICATE => array(
					'title' => __( 'Basiszertifikat E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für E-Mails bei Verwendung der grundlegenden Zertifikatsfunktion (wenn der Kurs abgeschlossen ist).', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $basic_certificate_fields ),
					'order' => 7,
				),
				CoursePress_Helper_Email::REGISTRATION => array(
					'title' => __( 'E-Mail zur Benutzerregistrierung', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die Schüler/innen bei der Kontoanmeldung erhalten.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $registration_fields ),
					'order' => 1,
				),
				CoursePress_Helper_Email::ENROLLMENT_CONFIRM => array(
					'title' => __( 'E-Mail zur Bestätigung der Kursanmeldung', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die Schüler bei der Einschreibung erhalten.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $enrollment_confirm ),
					'order' => 2,
				),
				CoursePress_Helper_Email::INSTRUCTOR_ENROLLMENT_NOTIFICATION => array(
					'title' => __( 'Einschreibebenachrichtigung für Ausbilder E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die der/die Lehrer/in erhält, wenn sich ein/e neue/r Schüler/in anmeldet.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $instructor_enrollment_notification ),
					'order' => 3,
				),
				CoursePress_Helper_Email::COURSE_INVITATION => array(
					'title' => __( 'Schülereinladung zu einem Kurs E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die Schüler/innen erhalten, wenn sie eine Einladung zu einem Kurs erhalten.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $course_invitation_fields ),
					'order' => 3,
				),
				CoursePress_Helper_Email::COURSE_INVITATION_PASSWORD => array(
					'title' => __( 'Studenten Einladung zu einem Kurs E-Mail (mit Passcode)', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die Schüler/innen erhalten, wenn sie eine Einladung (mit Passcode) zu einem Kurs erhalten.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $course_invitation_fields ),
					'order' => 4,
				),
				CoursePress_Helper_Email::INSTRUCTOR_INVITATION => array(
					'title' => __( 'Ausbilder Einladungs-E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die ein/e Ausbilder/in nach Erhalt einer Einladung erhält.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $instructor_invitation_fields ),
					'order' => 5,
				),
				CoursePress_Helper_Email::FACILITATOR_INVITATION => array(
					'title' => __( 'Moderator Einladung E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-mail ein Moderator erhalten nach Erhalt der Einladung.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $instructor_invitation_fields ),
					'order' => 5,
				),
				CoursePress_Helper_Email::NEW_ORDER => array(
					'title' => __( 'Neue Bestellung E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die Schülerinnen und Schüler bei einer Bestellung erhalten.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt: CUSTOMER_NAME, BLOG_NAME, LOGIN_ADDRESS, COURSES_ADDRESS, WEBSITE_ADDRESS, COURSE_ADDRESS, ORDER_ID, ORDER_STATUS_URL', 'cp' ),
					'order' => 6,
				),
				CoursePress_Helper_Email::COURSE_START_NOTIFICATION => array(
					'title' => __( 'Kursbenachrichtigung E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die an Schüler/innen gesendet wird, wenn ein Kurs begonnen hat.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden mit diesen Daten ersetzt: ', 'cp' ) . implode( ', ', $course_start_fields ),
					'order' => 7,
				),
				CoursePress_Helper_Email::DISCUSSION_NOTIFICATION => array(
					'title' => __( 'Diskussion Benachrichtigung E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die an Schüler/innen und Lehrkräfte gesendet wird.', 'cp' ),
					'content_help_text' => __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $discussion_fields ),
					'order' => 7,
				),
				CoursePress_Helper_Email::UNIT_STARTED_NOTIFICATION => array(
					'title' => __( 'Kurseinheit Gestartet E-Mail', 'cp' ),
					'description' => __( 'Einstellungen für eine E-Mail, die an Schüler/innen gesendet wird, wenn eine Einheit begonnen hat.', 'cp' ),
					'content_help_text' => sprintf( __( '* Du kannst das %s Mail-Token in der Betreffzeile verwenden.', 'cp' ), 'UNIT_TITLE' ) .
						__( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $units_started ),
					'order' => 8,
				),
				CoursePress_Helper_Email::INSTRUCTOR_MODULE_FEEDBACK_NOTIFICATION => array(
					'title' => __( 'Feedback des Lehrers', 'cp' ),
					'description' => __( 'Vorlage für das Versenden von Ausbilder-Feedback an Schüler.', 'cp' ),
					'content_help_text' => sprintf( __( 'Diese Codes werden durch aktuelle Daten ersetzt:', 'cp' ) . implode( ', ', $instructor_module_feedback ) ),
					'order' => 9,
				),
			)
		);

		return $defaults;
	}

	private static function _registration_email() {
		return CoursePress_Core::get_setting(
			'email/registration/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Willkommen bei %3$s!

Du kannst dein Profil hier aufrufen: %4$s

Und hier kannst du dich über unsere Kurse informieren: %5$s

Mit freundlichen Grüßen,
Das %6$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'BLOG_NAME',
				'<a href="LOGIN_ADDRESS">LOGIN_ADDRESS</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _enrollment_confirmation_email() {
		return CoursePress_Core::get_setting(
			'email/enrollment_confirm/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Herzlichen Glückwunsch! Du hast dich für "%3$s" angemeldet.

Du kannst die Kurse, für die du eingeschrieben bist, hier einsehen: %4$s.

Und andere Kurse, die du besuchen kannst, findest du hier: %5$s

Herzliche Grüße,
Das %6$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'<a href="COURSE_ADDRESS">COURSE_TITLE</a>',
				'<a href="STUDENT_DASHBOARD">' . __( 'Dashboard', 'cp' ) . '</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	private static function _instructor_enrollment_notification_email() {
		return CoursePress_Core::get_setting(
			'email/instructor_enrollment_notification/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Ein neuer Schüler "%3$s %4$s" hat sich in deinem Kurs "%5$s" eingeschrieben.

Hier kannst du alle Schüler verwalten, die in diesem Kurs eingeschrieben sind: %6$s

Herzliche Grüße,
Das %7$s Team', 'cp' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'<a href="COURSE_ADMIN_ADDRESS">COURSE_TITLE</a>',
				'<a href="COURSE_STUDENTS_ADMIN_ADDRESS">COURSE_STUDENTS_ADMIN_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	private static function _course_invitation_email() {
		return CoursePress_Core::get_setting(
			'email/course_invitation/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Du wurdest eingeladen, dich anzumelden: "%3$s"

Hier findest du weitere Informationen über den Kurs:

%4$s

Auf der Kursseite findest du eine detaillierte Übersicht: %5$s

Wenn du Fragen hast, melde dich einfach bei mir!

Mit freundlichen Grüßen,
Das %6$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'COURSE_EXCERPT',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _course_invitation_passcode_email() {
		return CoursePress_Core::get_setting(
			'email/course_invitation_password/content',
			sprintf(
				__( 'Hi %1$s %2$s,

Du wurdest eingeladen, dich anzumelden: "%3$s"

Dieser Kurs ist nur für ausgewählte Teilnehmer/innen verfügbar, die einen Passcode haben.

Dein Passcode lautet: %7$s

Hier findest du weitere Informationen über den Kurs:

%4$s

Auf der Kursseite findest du eine detaillierte Übersicht: %5$s

Wenn du Fragen hast, melde dich einfach bei uns!

Mit freundlichen Grüßen,
Das %6$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'COURSE_EXCERPT',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>',
				'PASSCODE'
			)
		);
	}

	private static function _instructor_invitation_email() {
		return CoursePress_Core::get_setting(
			'email/instructor_invitation/content',
			sprintf(
				__('Hi %1$s %2$s,

Herzlichen Glückwunsch! Du wurdest eingeladen, als Ausbilder/in für den Kurs: %3$s

Klicke auf den untenstehenden Link, um zu bestätigen:

%4$s

Wenn du noch keinen Benutzernamen hast, musst du einen erstellen.

%5$s

Herzliche Grüße,
Das %5$s Team', 'cp' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'COURSE_NAME',
				'<a href="CONFIRMATION_LINK">CONFIRMATION_LINK</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _facilitator_invitation_email() {
		return CoursePress_Core::get_setting(
			'email/facilitator_invitation/content',
			sprintf(
				__('Hi %1$s %2$s,

Herzlichen Glückwunsch! Du wurdest eingeladen, als Facilitator bei %3$s mitzumachen.

Klicke auf den Link unten, um zu bestätigen:

%4$s

Wenn du noch keinen Benutzernamen erhalten hast, musst du einen erstellen. Das kannst du hier tun:

%5$s

Herzliche Grüße,
Das %5$s Team', 'cp' ),
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'COURSE_NAME',
				'<a href="CONFIRMATION_LINK">CONFIRMATION_LINK</a>',
				'<a href="WEBSITE_ADDRESS">WEBSITE_ADDRESS</a>'
			)
		);
	}

	private static function _new_order_email() {
		return CoursePress_Core::get_setting(
			'email/new_order/content',
			sprintf(
				__( 'Vielen Dank für deine Bestellung %1$s,

Deine Bestellung für den Kurs "%2$s" ist eingegangen!

Bitte gib deine Bestell-ID (ORDER_ID) an, wenn du uns kontaktierst.

Du kannst den aktuellen Status deiner Bestellung hier verfolgen: ORDER_STATUS_URL

mit freundlichen Grüßen,
%5$s Team', 'cp' ),
				'CUSTOMER_NAME',
				'<a href="COURSE_ADDRESS">COURSE_TITLE</a>',
				'<a href="STUDENT_DASHBOARD">' . __( 'Dashboard', 'cp' ) . '</a>',
				'<a href="COURSES_ADDRESS">COURSES_ADDRESS</a>',
				'BLOG_NAME'
			)
		);
	}

	public static function course_start_defaults() {
		return CoursePress_Core::get_setting(
			'email/course_start/content',
			sprintf(
				__( 'Hallo %1$s,

Dein Kurs %2$s hat begonnen!

Du kannst das Kursmaterial hier einsehen::

%3$s

Mit freundlichen Grüßen,
Das %4$s Team', 'cp' ),
				'FIRST_NAME',
				'COURSE_NAME',
				'<a href="COURSE_ADDRESS">COURSE_ADDRESS</a>',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function discussion_defaults() {
		return CoursePress_Core::get_setting(
			'email/discussion_notification/content',
			sprintf(
				__( 'Es wurde ein neuer Kommentar zu %1$s hinzugefügt:

%2$s

Beste Wünsche,
Das %3$s Team', 'cp' ),
				'COURSE_NAME',
				'COMMENT_MESSAGE',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function unit_started_defaults() {
		return CoursePress_Core::get_setting(
			'email/unit_started/content',
			sprintf(
				__( 'Howdy %1$s,

%2$s von %3$s ist jetzt verfügbar.

Du kannst dein Lernen fortsetzen, indem du auf den untenstehenden Link klickst:
%4$s

Mit freundlichen Grüßen,
Das %5$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'UNIT_TITLE',
				'COURSE_NAME',
				'UNIT_ADDRESS',
				'WEBSITE_ADDRESS'
			)
		);
	}

	public static function instructor_feedback_module_defaults() {
		return CoursePress_Core::get_setting(
			'email/instructor_feedback_module/content',
			sprintf( __(
				'Hi %1$s %2$s,

Eine neue Rückmeldung wird von deinem Ausbilder bei %3$s in %4$s bei %5$s gegeben

%6$s sagt
%7$s

Beste Wünsche,
Das %8$s Team', 'cp' ),
				'STUDENT_FIRST_NAME',
				'STUDENT_LAST_NAME',
				'COURSE_NAME',
				'CURRENT_UNIT',
				'CURRENT_MODULE',
				'INSTRUCTOR_FIRST_NAME',
				'INSTRUCTOR_LAST_NAME',
				'INSTRUCTOR_FEEDBACK',
				'WEBSITE_ADDRESS'
			)
		);
	}

	/**
	 * Add buttons: fold and unfold.
	 *
	 * @since 2.0.0
	 *
	 * @param string $content Current content to filter.
	 * @param string $active Current tab key.
	 * @return string Content after filter.
	 */
	public static function add_buttons( $content, $active ) {
		if ( 'email' != $active ) {
			return $content;
		}
		$content .= sprintf(
			'<input type="button" class="button %s disabled" value="%s" /> ',
			'hndle-items-fold',
			esc_attr__( 'Alle falten', 'cp' )
		);
		$content .= sprintf(
			'<input type="button" class="button %s" value="%s" /> ',
			'hndle-items-unfold',
			esc_attr__( 'Entfalte alle', 'cp' )
		);
		return $content;
	}
}