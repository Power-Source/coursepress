<?php

class CoursePress_View_Admin_Setting_Shortcodes {

	public static function init() {
		add_filter(
			'coursepress_settings_tabs',
			array( __CLASS__, 'add_tabs' )
		);
		add_action(
			'coursepress_settings_process_shortcodes',
			array( __CLASS__, 'process_form' ),
			10, 2
		);
		add_filter(
			'coursepress_settings_render_tab_shortcodes',
			array( __CLASS__, 'return_content' ),
			10, 3
		);
	}

	public static function add_tabs( $tabs ) {
		$tabs['shortcodes'] = array(
			'title' => __( 'Shortcodes', 'cp' ),
			'description' => __( 'Mit Shortcodes kannst du dynamische Inhalte in Beiträge und Seiten auf deiner Website einfügen. Tippe sie einfach ein oder füge sie an der Stelle in deinen Beitrag oder deine Seite ein, an der sie erscheinen sollen. Optionale Attribute können in einem Format wie <em>[shortcode attr1="Wert" attr2="Wert"]</em> hinzugefügt werden.', 'cp' ),
			'order' => 50,
			'buttons' => 'none',
		);

		return $tabs;
	}

	public static function return_content( $content, $slug, $tab ) {
		$content = 'shortcodes!';
		$boxes = self::_boxes();

		ob_start();
		?>
		<div class="shortcodes-list">
			<?php foreach ( $boxes as $group => $data ) : ?>
            <div class="cp-content-box <?php echo esc_attr( $group ); ?>" id="shortcode-<?php echo esc_attr( $group ); ?>">
				<h3 class="hndle">
					<span><?php echo esc_html( $data['title'] ); ?></span>
				</h3>
				<div class="inside"><?php echo $data['content']; ?></div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public static function process_form() {
	}

	private static function _boxes() {
		$boxes = array(
			'course_instructors' => array(
				'title' => __( 'Ausbilderliste', 'cp' ),
				'content' => self::_box_course_instructors(),
			),
			'course_instructor_avatar' => array(
				'title' => __( 'Instruktor-Avatar', 'cp' ),
				'content' => self::_box_course_instructor_avatar(),
			),
			'instructor_profile_url' => array(
				'title' => __( 'URL des Ausbilderprofils', 'cp' ),
				'content' => self::_box_instructor_profile_url(),
			),
			'course' => array(
				'title' => __( 'Kurs', 'cp' ),
				'content' => self::_box_course(),
			),
			'course_details' => array(
				'title' => __( 'Kursdetails', 'cp' ),
				'content' => self::_box_course_details(),
			),
			'course_title' => array(
				'title' => __( 'Kurstitel', 'cp' ),
				'content' => self::_box_course_title(),
			),
			'course_summary' => array(
				'title' => __( 'Kurszusammenfassung', 'cp' ),
				'content' => self::_box_course_summary(),
			),
			'course_description' => array(
				'title' => __( 'Kurs Beschreibung', 'cp' ),
				'content' => self::_box_course_description(),
			),
			'course_start' => array(
				'title' => __( 'Kurs Startdatum', 'cp' ),
				'content' => self::_box_course_start_date(),
			),
			'course_end' => array(
				'title' => __( 'Datum des Kursendes', 'cp' ),
				'content' => self::_box_course_end_date(),
			),
			'course_dates' => array(
				'title' => __( 'Kurstermine', 'cp' ),
				'content' => self::_box_course_dates(),
			),
			'course_enrollment_start' => array(
				'title' => __( 'Beginn der Kurseinschreibung', 'cp' ),
				'content' => self::_box_course_enrollment_start(),
			),
			'course_enrollment_end' => array(
				'title' => __( 'Kurseinschreibung Ende', 'cp' ),
				'content' => self::_box_course_enrollment_end(),
			),
			'course_enrollment_dates' => array(
				'title' => __( 'Termine für die Kurseinschreibung', 'cp' ),
				'content' => self::_box_course_enrollment_dates(),
			),
			'course_enrollment_type' => array(
				'title' => __( 'Paar Einschreibeart', 'cp' ),
				'content' => self::_box_course_enrollment_type(),
			),
			'course_class_size' => array(
				'title' => __( 'Kurs Klassengröße', 'cp' ),
				'content' => self::_box_course_class_size(),
			),
			'course_cost' => array(
				'title' => __( 'Kurskosten', 'cp' ),
				'content' => self::_box_course_cost(),
			),
			'course_time_estimation' => array(
				'title' => __( 'Schätzung der Kursdauer', 'cp' ),
				'content' => self::_box_course_time_estimation(),
			),
			'course_language' => array(
				'title' => __( 'Kurssprache', 'cp' ),
				'content' => self::_box_course_language(),
			),
			'course_list_image' => array(
				'title' => __( 'Bild der Kursliste', 'cp' ),
				'content' => self::_box_course_list_image(),
			),
			'course_featured_video' => array(
				'title' => __( 'Kurs Featured Video', 'cp' ),
				'content' => self::_box_course_featured_video(),
			),
			'course_media' => array(
				'title' => __( 'Arbeitsdateien & Vorlagen zu diesem Kurs', 'cp' ),
				'content' => self::_box_course_media(),
			),
			'course_join_button' => array(
				'title' => __( 'Schaltfläche "Kurs beitreten', 'cp' ),
				'content' => self::_box_course_join_button(),
			),
			'course_action_links' => array(
				'title' => __( 'Kurs Aktion Links', 'cp' ),
				'content' => self::_box_course_action_links(),
			),
			'course_calendar' => array(
				'title' => __( 'Kurskalender', 'cp' ),
				'content' => self::_box_course_calendar(),
			),
			'course_list' => array(
				'title' => __( 'Kursliste', 'cp' ),
				'content' => self::_box_course_list(),
			),
			'course_featured' => array(
				'title' => __( 'Empfohlener Kurs', 'cp' ),
				'content' => self::_box_course_featured(),
			),
			'course_structure' => array(
				'title' => __( 'Kursstruktur', 'cp' ),
				'content' => self::_box_course_structure(),
			),
			'course_signup' => array(
				'title' => __( 'Kurs Registrierung/Login Seite', 'cp' ),
				'content' => self::_box_course_signup(),
			),
			'courses_student_dashboard' => array(
				'title' => __( 'Schüler Dashboard Vorlage', 'cp' ),
				'content' => self::_box_courses_student_dashboard(),
			),
			'courses_student_settings' => array(
				'title' => __( 'Vorlage für Schülereinstellungen', 'cp' ),
				'content' => self::_box_courses_student_settings(),
			),
		);
		ksort( $boxes );
		return $boxes;
	}

	/**
	 * Produce help box for course_instructors.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_instructors() {
		$data = array(
			'shortcode' => 'course_instructors',
			'content' => __( 'Zeige eine Liste oder Anzahl der Ausbilder an (Gravatar, Name und Link zur Profilseite)', 'cp' ),
			'parameters' => array(
				'optional' => array(
					'course_id' => array(
						'content' => __( 'ID des Kurses, dem die Lehrkräfte zugeordnet sind (erforderlich, wenn sie außerhalb einer Schleife verwendet wird)', 'cp' ),
					),
					'style' => array(
						'content' => __( 'Wie man die Lehrkräfte anzeigt.', 'cp' ),
						'options' => array( 'block', 'default', 'list', 'list-flat', 'count' ),
						'options_description' => __( 'Zählen - Zähle Instruktoren für den Kurs.', 'cp' ),
					),
					'label' => array(
						'content' => __( 'Beschriftung, die für die Ausgabe angezeigt werden soll.', 'cp' ),
					),
					'label_plural' => array(
						'content' => __( 'Plural, wenn es mehr als einen Ausbilder gibt.', 'cp' ),
						'default' => __( 'Trainer', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol, das hinter dem Etikett stehen soll.', 'cp' ),
						'default' => ':',
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag, um die Beschriftung einzuschließen (ohne Klammern, z. B. <em>h3</em>).', 'cp' ),
						'default' => __( 'leer', 'cp' ),
					),
					'link_text' => array(
						'content' => __( 'Text zum Anklicken für den Link zu den vollständigen Profilen.', 'cp' ),
						'default' => __( 'Gesamtes Profil anzeigen', 'cp' ),
					),
					'show_label' => array(
						'content' => __( 'Etikett zeigen.', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
					'summary_length' => array(
						'content' => __( 'Länge der Kursleiter Bio zu zeigen, wenn Stil "block".', 'cp' ),
						'default' => __( 50, 'cp' ),
					),
					'list_separator' => array(
						'content' => __( 'Symbol zur Trennung von Lehrkräften, wenn der Stil "Liste" oder "Liste-flach" ist.', 'cp' ),
						'default' => ',',
					),
					'avatar_size' => array(
						'content' => __( 'Pixelgröße der Avatare bei der Anzeige im Blockmodus.', 'cp' ),
						'default' => __( 80, 'cp' ),
					),
					'default_avatar' => array(
						'content' => __( 'URL zu einem Standardbild, wenn der Benutzeravatar nicht gefunden werden kann.', 'cp' ),
					),
					'show_divider' => array(
						'content' => __( 'Setze eine Trennlinie zwischen die Lehrerprofile, wenn der Stil "Block" ist.', 'cp' ),
					),
					'link_all' => array(
						'content' => __( 'Mache das gesamte Ausbilderprofil zu einem Link zum vollständigen Profil.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_instructors]',
				'[course_instructors course_id="5"]',
				'[course_instructors style="list"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_instructor_avatar.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_instructor_avatar() {
		$data = array(
			'shortcode' => 'course_instructor_avatar',
			'content' => __( 'Zeige den Avatar einer Lehrkraft an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'instructor_id' => array(
						'content' => __( 'Die Benutzerkennung des Lehrers.', 'cp' ),
					),
				),
				'optional' => array(
					'force_display' => array(
						'content' => __( 'Ob immer das Standardbild und nie der Gravatar angezeigt werden soll.', 'cp' ),
					),
					'thumb_size' => array(
						'content' => __( 'Größe der Avatar-Miniaturansicht.', 'cp' ),
						'default' => 80,
					),
					'class' => array(
						'content' => __( 'CSS-Klasse, die für den Avatar verwendet werden soll.', 'cp' ),
						'default' => 'small-circle-profile-image',
					),
				),
			),
			'examples' => array(
				'[course_instructor_avatar instructor_id="1"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for instructor_profile_url.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_instructor_profile_url() {
		$data = array(
			'shortcode' => 'instructor_profile_url',
			'content' => __( 'Gibt die URL zum Profil der Lehrkraft zurück.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'instructor_id' => array(
						'content' => __( 'Die Benutzerkennung des Lehrers.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[instructor_profile_url instructor_id="1"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course() {
		$data = array(
			'shortcode' => 'course',
			'content' => __( 'Dieser Shortcode erlaubt es dir Kursdetails anzuzeigen.', 'cp' ),
		   'note' => __( 'Die gleichen Informationen kannst du mit den folgenden spezifischen Kurs-Shortcodes abrufen.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
					'show' => array(
						'content' => __( 'Alle Felder, die du anzeigen möchtest.', 'cp' ),
						'default' => 'summary',
						'options' => array( 'title', ' summary', ' description', ' start', ' end', ' dates', ' enrollment_start', ' enrollment_end', ' enrollment_dates', ' enrollment_type', ' class_size', ' cost', ' language', ' instructors', ' image', ' video', ' media', ' button', ' action_links', ' calendar', ' thumbnail' ),
					),
				),
				'optional' => array(
					'show_title' => array(
						'content' => __( 'Erforderlich, wenn das Feld "Titel" angezeigt wird.', 'cp' ),
						'defulat' => 'no',
						'options' => array( 'yes', 'no' ),
					),
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'defulat' => 'WP',
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'defulat' => 'strong',
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'defulat' => ':',
					),
				),
			),
			'examples' => array(
				'[course show="title,summary,cost,button" course_id="5"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course details.
	 *
	 * @since 2.0.2
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_details() {
		$data = array(
			'shortcode' => 'course_details',
			'content' => __( 'This shortcode is an alias to [course] shortcode. see section [course] shortcode for details.', 'cp' ),
			'examples' => array(
				'[course show="title,summary,cost,button" course_id="5"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_title.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_title() {
		$data = array(
			'shortcode' => 'course_title',
			'content' => __( 'Zeigt den Kurstitel.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'title_tag' => array(
						'content' => __( 'HTML tag (ohne Klammern) für den Kurstitel.', 'cp' ),
						'default' => 'h3',
					),
					'link' => array(
						'content' => __( '.', 'cp' ),
						'default' => 'empty',
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_title course_id="4"]',
				'[course_title]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_summary.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_summary() {
		$data = array(
			'shortcode' => 'course_summary',
			'content' => __( 'Zeigt die Kurszusammenfassung/den Kursauszug an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
			),
			'examples' => array(
				'[course_summary course_id="4"]',
				'[course_summary]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_description.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_description() {
		$data = array(
			'shortcode' => 'course_description',
			'content' => __( 'Zeigt die längere Kursbeschreibung (Post-Inhalt) an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'label' => array(
						'content' => __( 'Ein zusätzliches Etikett wird vor der Beschreibung angezeigt.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_description course_id="4"]<br />[course_description]'
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_description.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_start_date() {
		$data = array(
			'shortcode' => 'course_start',
			'content' => __( 'Zeigt das Datum des Kursbeginns an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => 'wp',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => __( 'stark', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_start]',
				'[course_start label="Awesomeness begins on" label_tag="h3"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_end.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_end_date() {
		$data = array(
			'shortcode' => 'course_end',
			'content' => __( 'Zeigt den Kurs Endtermin.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => 'wp',
						'description' => __( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date and time formatting</a>.' ),
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => __( 'stark', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'no_date_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs kein Enddatum hat.', 'cp' ),
						'default' => __( 'Kein Enddatum', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_end]',
				'[course_end label="The End." label_tag="h3" course_id="5"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_dates.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_dates() {
		$data = array(
			'shortcode' => 'course_dates',
			'content' => __( 'Zeigt den Datumsbereich für Kursbeginn und -ende an. Normalerweise als [Kurs_Start] - [Kurs_Ende].', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => 'wp',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'no_date_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs kein Enddatum hat.', 'cp' ),
						'default' => __( 'Kein Enddatum', 'cp' ),
					),
					'alt_display_text' => array(
						'content' => __( 'Wechselnde Anzeige, wenn es kein Enddatum gibt.', 'cp' ),
						'default' => __( 'Offenes Ende', 'cp' ),
					),
					'show_alt_display' => array(
						'content' => __( 'Wenn du "ja" einstellst, verwende den alt_display_text. Wenn du "no" einstellst, verwende den "no_date_text".', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_dates course_id="42"]',
				'[course_dates course_id="42" show_alt_display="yes" alt_display_text="Learn Anytime!"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_enrollment_start.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_enrollment_start() {
		$data = array(
			'shortcode' => 'course_enrollment_start',
			'content' => __( 'Zeigt das Datum an, an dem die Einschreibung in den Kurs beginnt.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => 'wp',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => __( 'stark', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'no_date_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs kein festgelegtes Einschreibedatum hat.', 'cp' ),
						'default' => __( 'Jederzeit einschreiben', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_enrollment_start]',
				'[course_enrollment_start label="Signup from" label_tag="em"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_enrollment_end.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_enrollment_end() {
		$data = array(
			'shortcode' => 'course_enrollment_end',
			'content' => __( 'Zeigt das Enddatum der Kurseinschreibung an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => __( 'WordPress-Einstellung.', 'cp' ),
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'no_date_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn es kein Enddatum für die Einschreibung gibt.', 'cp' ),
						'default' => __( 'Jederzeit einschreiben', 'cp' ),
					),
					'show_all_dates' => array(
						'content' => __( 'Bei "ja" wird der no_date_text angezeigt, auch wenn es kein Datum gibt. Wenn "nein", wird nichts angezeigt.', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_end]',
				'[course_end label="End" label_delimeter="-"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_enrollment_dates.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_enrollment_dates() {
		$data = array(
			'shortcode' => 'course_enrollment_dates',
			'content' => __( 'Zeigt den Datumsbereich für Beginn und Ende der Kurseinschreibung an. Normalerweise als [kurs_einschreibung_start] - [kurs_einschreibung_ende].', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'alt_display_text' => array(
						'content' => __( 'Wechselnde Anzeige, wenn es kein Start- oder Enddatum für die Einschreibung gibt.', 'cp' ),
						'default' => __( 'Offenes Ende', 'cp' ),
					),
					'date_format' => array(
						'content' => __( 'Datumsformat im PHP-Stil.', 'cp' ),
						'default' => 'wp',
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => 'wp',
					),
					'label_enrolled' => array(
						'content' => __( 'Etikett, das für das Anmeldedatum angezeigt wird.', 'cp' ),
						'default' => __( 'Du bist eingeschrieben in:', 'cp' ),
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => __( 'stark', 'cp' ),
					),
					'no_date_text' => array(
						'content' => __( 'Text, der angezeigt werden soll, wenn es kein Start- oder Enddatum für die Einschreibung gibt.', 'cp' ),
						'default' => __( 'Jederzeit einschreiben', 'cp' ),
					),
					'show_alt_display' => array(
						'content' => __( 'Wenn du "ja" einstellst, verwende den alt_display_text. Wenn du "no" einstellst, verwende den "no_date_text".', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
					'show_enrolled_display' => array(
						'content' => __( 'Anzeige des Startetiketts für die Einschreibung.', 'cp' ),
						'default' => __( 'ja', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_enrollment_dates]',
				'[course_enrollment_dates no_date_text="No better time than now!"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_enrollment_type.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_enrollment_type() {
		$data = array(
			'shortcode' => 'course_enrollment_type',
			'content' => __( 'Zeigt die Art der Einschreibung an (manuell, Voraussetzung, Passcode oder jeder).', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'anyone_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn sich jemand anmelden kann.', 'cp' ),
						'default' => __( 'Jeder', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'manual_text' => array(
						'content' => __( 'Text, der bei manuellen Anmeldungen angezeigt wird.', 'cp' ),
						'default' => __( 'Teilnehmer werden vom Dozenten freigegeben.', 'cp' ),
					),
					'passcode_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn ein Passcode erforderlich ist.', 'cp' ),
						'default' => __( 'Ein Passwort ist erforderlich, zum Einschreiben.', 'cp' ),
					),
					'prerequisite_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn es eine Voraussetzung gibt. Verwende %s als Platzhalter für den Titel des vorausgesetzten Kurses.', 'cp' ),
						'default' => __( 'Teilnehmer müssen zuerst "%s" abschließen.', 'cp' ),
					),
					'registered_text' => array(
						'content' => __( 'Text, der für registrierte Benutzer angezeigt wird.', 'cp' ),
						'default' => __( 'Registrierte Benutzer.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_enrollment_type]',
				'[course_enrollment_type course_id="42"]',
				'[course_enrollment_type passcode_text="Whats the magic word?"',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_class_size.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_class_size() {
		$data = array(
			'shortcode' => 'course_class_size',
			'content' => __( 'Zeigt die Klassengröße, die Grenzen und die verbleibenden Plätze an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'no_limit_text' => array(
						'content' => __( 'Text zur Anzeige für unbegrenzte Klassengrößen.', 'cp' ),
						'default' => __( 'Unbegrenzt', 'cp' ),
					),
					'remaining_text' => array(
						'content' => __( 'Text, der für die verbleibenden Plätze angezeigt werden soll. Verwende %d für die verbleibende Zahl.', 'cp' ),
						'default' => __( '(%d Plätze links)', 'cp' ),
					),
					'show_no_limit' => array(
						'content' => __( 'Wenn "ja", wird der no_limit_text angezeigt. Wenn "nein", wird bei unbegrenzten Kursen nichts angezeigt.', 'cp' ),
						'default' => 'no',
						'options' => array( 'yes', 'no' ),
					),
					'show_remaining' => array(
						'content' => __( 'Wenn "ja" zeige verbleibenden_Text. Wenn "nein", zeige die verbleibenden Orte nicht an.', 'cp' ),
						'default' => 'yes',
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_class_size]',
				'[course_class_size course_id="42" no_limit_text="The more the merrier"]',
				'[course_class_size remaining_text="Only %d places remaining!"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_cost.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_cost() {
		$data = array(
			'shortcode' => 'course_cost',
			'content' => __( 'Zeigt den Preis für den Kurs an oder ist bei unbezahlten Kursen kostenlos.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'no_cost_text' => array(
						'content' => __( 'Text, der bei unbezahlten Kursen angezeigt wird.', 'cp' ),
						'default' => __( 'KOSTENLOS', 'cp' ),
					),
					'show_icon' => array(
						'content' => __( 'Füge einen zusätzlichen Span mit der Klasse "product_price" um no_cost_text hinzu.', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_cost]',
				'[course_cost no_cost_text="'. __( 'Frei wie ein Bier.', 'cp' ) .'"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_time_estimation.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_time_estimation() {
		$data = array(
			'shortcode' => 'course_time_estimation',
			'content' => __( 'Zeigt die geschätzte Gesamtzeit basierend auf der Berechnung der Einheitselemente an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'wrapper' => array(
						'content' => __( 'Wickeln Sie innerhalb eines Div-Tags (ja | nein).', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_time_estimation course_id="42" wrapper="yes"]',
				'[course_time_estimation course_id="42"]',
				'[course_time_estimation wrapper="yes"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_language.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_language() {
		$data = array(
			'shortcode' => 'course_language',
			'content' => __( 'Zeigt die Sprache des Kurses an (falls eingestellt).', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'label' => array(
						'content' => __( 'Label to display for the output. Set label to "" to hide the label completely.', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_language]',
				'[course_language label="Delivered in"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_list_image.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_list_image() {
		$data = array(
			'shortcode' => 'course_list_image',
			'content' => __( 'Zeigt das Bild der Kursliste an. (Siehe [course_media]).', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'width' => array(
						'content' => __( 'Breite des Bildes.', 'cp' ),
						'default' => __( 'Ursprüngliche Breite', 'cp' ),
					),
					'height' => array(
						'content' => __( 'Höhe des Bildes.', 'cp' ),
						'default' => __( 'Ursprüngliche Höhe', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_list_image]',
				'[course_list_image width="100" height="100"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_featured_video.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_featured_video() {
		$data = array(
			'shortcode' => 'course_featured_video',
			'content' => __( 'Bettet einen Videoplayer mit dem Video des Kurses ein. (Siehe [course_media]).', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'width' => array(
						'content' => __( 'Breite des Videoplayers.', 'cp' ),
						'default' => __( 'Standardbreite des Spielers', 'cp' ),
					),
					'height' => array(
						'content' => __( 'Höhe des Videoplayers.', 'cp' ),
						'default' => __( 'Standardhöhe des Spielers', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_featured_video]',
				'[course_featured_video width="320" height="240"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_media.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_media() {
		$data = array(
			'shortcode' => 'course_media',
			'content' => __( 'Zeigt entweder das Listenbild oder das vorgestellte Video an (mit der anderen Option als möglichem Fallback).', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'width' => array(
						'content' => __( 'Breite der Medien.', 'cp' ),
						'default' => __( 'CoursePress-Einstellungen.', 'cp' ),
					),
					'height' => array(
						'content' => __( 'Höhe der Medien.', 'cp' ),
						'default' => __( 'CoursePress-Einstellungen.', 'cp' ),
					),
					'list_page' => array(
						'content' => __( 'Verwende "ja", um die CoursePress-Einstellungen für "Kurslisten" zu verwenden. Verwende "nein", um die CoursePress-Einstellungen für die "Kursdetailseite" zu verwenden.', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
					'priority' => array(
						'content' => __( 'Verwende "Bild", um zu versuchen, das Listenbild zuerst anzuzeigen. Wenn es nicht verfügbar ist, dann versuche, das vorgestellte Video zu verwenden.  Verwende "video", um zu versuchen, das vorgestellte Video zuerst zu zeigen. Wenn es nicht verfügbar ist, versuche, das Listenbild zu verwenden.', 'cp' ),
						'default' => __( 'CoursePress Einstellungen', 'cp' ),
						'options' => array( 'image', 'video', 'default' ),
					),
					'type' => array(
						'content' => __( 'Verwende "Bild", um nur das Listenbild anzuzeigen, wenn es verfügbar ist. Verwende "video", um nur das Video anzuzeigen, wenn es verfügbar ist. Verwende "thumbnail", um die Miniaturansicht des Kurses anzuzeigen (Abkürzung für type="image" und priority="image"). Verwende "default", um den Prioritätsmodus zu aktivieren (siehe Attribut priority).', 'cp' ),
						'default' => __( 'CoursePress Einstellungen', 'cp' ),
						'options' => array( 'image', 'video', 'thumbnail', 'default' ),
					),
					'wrapper' => array(
						'content' => __( 'Wickeln Sie innerhalb Tags.', 'cp' ),
						'default' => __( 'leerer String, aber wenn Höhe oder Breite definiert sind, ist der Wrapper ein "div"-Tag.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_media]',
				'[course_media list_page="yes"]',
				'[course_media type="video"]',
				'[course_media priority="image"]',
				'[course_media type="thumbnail"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_join_button.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_join_button() {
		$data = array(
			'shortcode' => 'course_join_button',
			'content' => __( 'Zeigt die Schaltfläche Beitreten/Anmelden/Einschreiben für den Kurs an. Was angezeigt wird, hängt von den Kurseinstellungen und dem Status bzw. der Einschreibung des Nutzers ab.<br />Siehe die Attribute für mögliche Schaltflächenbeschriftungen.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'access_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der/die Nutzer/in eingeschrieben und bereit zum Lernen ist.', 'cp' ),
						'default' => __( 'Lernen beginnen', 'cp' ),
					),
					'continue_learning_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs fortgesetzt werden kann.', 'cp' ),
						'default' => __( 'Weiter lernen', 'cp' ),
					),
					'course_expired_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs abgelaufen ist.', 'cp' ),
						'default' => __( 'Nicht verfügbar', 'cp' ),
					),
					'course_full_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs voll ist.', 'cp' ),
						'default' => __( 'Kurs voll', 'cp' ),
					),
					'details_text' => array(
						'content' => __( 'Text für die Schaltfläche, die dich zur vollständigen Kursseite führt.', 'cp' ),
						'default' => __( 'Kursdetails', 'cp' ),
					),
					'enrollment_closed_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn die Anmeldungen noch nicht begonnen haben.', 'cp' ),
						'default' => __( 'Einschreibung geschlossen', 'cp' ),
					),
					'enrollment_finished_text' => array(
						'content' => __( 'Text, der angezeigt werden soll, wenn Anmeldungen beendet werden (abgelaufen sind).', 'cp' ),
						'default' => __( 'Beendete Einschreibungen', 'cp' ),
					),
					'enroll_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs für Einschreibungen bereit ist.', 'cp' ),
						'default' => __( 'Jetzt anmelden', 'cp' ),
					),
					'instructor_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der/die aktuelle Nutzer/in ein/e Lehrkraft dieses Kurses ist.', 'cp' ),
						'default' => __( 'Den Kurs betreten', 'cp' ),
					),
					'list_page' => array(
						'content' => __( 'Schaltfläche zum Anzeigen der Kursdetails.', 'cp' ),
						'default' => 'false',
					),
					'not_started_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn ein Schüler eingeschrieben ist, der Kurs aber noch nicht begonnen hat.', 'cp' ),
						'default' => __( 'Nicht verfügbar', 'cp' ),
					),
					'passcode_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs ein Passwort erfordert.', 'cp' ),
						'default' => __( 'Passwort erforderlich', 'cp' ),
					),
					'prerequisite_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs eine Voraussetzung hat.', 'cp' ),
						'default' => __( 'Voraussetzungen', 'cp' ),
					),
					'signup_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Kurs für Einschreibungen bereit ist, der Nutzer aber nicht angemeldet ist (Besucher).', 'cp' ),
						'default' => __( 'Bitte erst anmelden', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_join_button]',
				'[course_join_button course_id="11" course_expired_text="'. __( 'Du hast etwas verpasst!', 'cp' ).'"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_action_links.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_action_links() {
		$data = array(
			'shortcode' => 'course_action_links',
			'content' => __( 'Zeigt den Schülern die Links "Kursdetails" und "Zurücktreten" an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_action_links]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_calendar.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_calendar() {
		$data = array(
			'shortcode' => 'course_calendar',
			'content' => __( 'Zeigt den Kurskalender an (die Grenzen sind durch das Start- und Enddatum des Kurses begrenzt). Es wird immer versucht, zuerst das heutige Datum im Kalender anzuzeigen.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'date_indicator' => array(
						'content' => __( 'Klassen String hinzugefügt Kalender Tabelle Tag Halter.', 'cp' ),
						'default' => __( 'blinker_licht_block', 'cp' ),
					),
					'month' => array(
						'content' => __( 'Monat, der als Zahl angezeigt werden soll (z. B. 03 für März).', 'cp' ),
						'default' => __( 'Heutiges Datum', 'cp' ),
					),
					'next' => array(
						'content' => __( 'Text, der für den Link zum nächsten Monat angezeigt werden soll.', 'cp' ),
						'default' => __( 'Nächste &raquo;', 'cp' ),
					),
					'pre' => array(
						'content' => __( 'Text, der für den Link zum Vormonat angezeigt werden soll.', 'cp' ),
						'default' => __( '&laquo; Zurück', 'cp' ),
					),
					'year' => array(
						'content' => __( 'Jahr, das als 4-stellige Zahl angezeigt werden soll (z. B. 2014).', 'cp' ),
						'default' => __( 'Heutiges Datum', 'cp' ),
					),
				),
			),
			'examples' => array(
				'[course_calendar]',
				'[course_calendar pre="< Previous" next="Next >"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_list.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_list() {
		$data = array(
			'shortcode' => 'course_list',
			'content' => __( 'Zeigt eine Liste von Kursen an. Kann für alle Kurse oder nach Lehrkräften oder Schülern eingeschränkt werden (nur das eine oder das andere; wenn beides angegeben wird, werden nur Schüler angezeigt).', 'cp' ),
			'parameters' => array(
				'optional' => array(
					'categories' => array(
						'content' => __( 'Ein kommagetrennter Kategorie-Slug, um Kurse zu bestimmten Kurskategorien anzuzeigen.', 'cp' ),
						'default' => 'empty',
					),
					'completed_label' => array(
						'content' => __( 'Etikett für die Liste der abgeschlossenen Kurse.', 'cp' ),
						'default' => __( 'Abgeschlossene Kurse', 'cp' ),
					),
					'context' => array(
						'content' => __( 'Kontext für die Kursliste. Mögliche Werte: .', 'cp' ),
						'default' => 'all',
						'options' => array( 'enrolled', 'future', 'incomplete', 'completed', 'past', 'manage', 'facilitator', 'all' ),
					),
					'current_label' => array(
						'content' => __( 'Etikett für aktuelle Kurse.', 'cp' ),
						'default' => __( 'Aktuelle Kurse', 'cp' ),
					),
					'dashboard' => array(
						'content' => __( 'Wenn wahr oder "ja", dann schalte den Kontext auf "Dashboard" um.', 'cp' ),
						'default' => 'empty',
					),
					'facilitator_label' => array(
						'content' => __( 'Etikett vor der Kursliste für den Kontext "Vermittler".', 'cp' ),
						'default' => __( 'Erleichterte Kurse', 'cp' ),
					),
					'facilitator' => array(
						'content' => __( 'Wenn dies zutrifft oder "ja", schalte den Inhalt auf "Vermittler" um.', 'cp' ),
						'default' => 'empty',
					),
					'future_label' => array(
						'content' => __( 'Etikett für zukünftige Kurse.', 'cp' ),
						'default' => __( 'Beginnt bald', 'cp' ),
					),
					'incomplete_label' => array(
						'content' => __( 'Etikett für unvollständige Kurse.', 'cp' ),
						'default' => __( 'Unvollständige Kurse', 'cp' ),
					),
					'instructor_msg' => array(
						'content' => __( 'Meldung auf der Dozentenseite, wenn der Dozent keine zugewiesenen Kurse hat.', 'cp' ),
						'default' => __( 'Der/die Ausbilder/in hat noch keine Kurse zugewiesen.', 'cp' ),
					),
					'instructor' => array(
						'content' => __( 'Die Ausbilderkennung, um die Kurse eines bestimmten Ausbilders aufzulisten. Du kannst auch mehrere Lehrkräfte mit Kommas angeben. (z. B. lehrer="1,2,3").', 'cp' ),
						'default' => 'empty',
						'description' => __( 'Wenn sowohl Schüler als auch Ausbilder angegeben werden, wird nur der Schüler verwendet.', 'cp' ),
					),
					'limit' => array(
						'content' => __( 'Schränke die Anzahl der Kurse ein. Verwende -1, um alle anzuzeigen.', 'cp' ),
						'default' => __( '-1', 'cp' ),
					),
					'manage_label' => array(
						'content' => __( 'Etikett vor beartbaren Kursen.', 'cp' ),
						'default' => __( 'Kurse verwalten', 'cp' ),
					),
					'order' => array(
						'content' => __( 'Ordne die Kurse. "ASC" für aufsteigende Reihenfolge. "DESC" für absteigende Reihenfolge.', 'cp' ),
						'default' => __( 'Aufsteigend', 'cp' ),
						'options' => array( 'ASC', 'DESC' ),
					),
					'orderby' => array(
						'content' => __( 'Ordne die Kurse nach Kursdatum oder nach Kurstitel.', 'cp' ),
						'default' => __( 'Meta', 'cp' ),
                        'options' => array( 'meta', 'title' ),
                        'description' => __('Es funktioniert nur mit dem Standard-"Kontext".', 'cp' ),
					),
					'past_label' => array(
						'content' => __( 'Etikett vor vergangenen Kursen.', 'cp' ),
						'default' => __( 'Vergangene Kurse', 'cp' ),
					),
					'show_labels' => array(
						'content' => __( 'Labels anzeigen.', 'cp' ),
						'default' => 'false',
					),
					'status' => array(
						'content' => __( 'Der Status der Kurse, die angezeigt werden sollen (verwendet den WordPress-Status).', 'cp' ),
						'default' => __( 'veröffentlicht', 'cp' ),
					),
					'student_msg' => array(
						'content' => __( 'Diese Meldung wird angezeigt, wenn ein Schüler nicht für einen Kurs eingeschrieben ist.', 'cp' ),
						'default' => sprintf(
							__( 'Du bist in keinem Kurs eingeschrieben. %s', 'cp' ),
							htmlentities(
								sprintf(
									__( '<a href="%s">Siehe verfügbare Kurse.</a>', 'cp' ),
									esc_attr( '/'.CoursePress_Core::get_setting( 'slugs/course', 'courses' ) )
								)
							)
						),
					),
					'student' => array(
						'content' => __( 'Die Schüler-ID, um die Kurse für einen bestimmten Schüler aufzulisten. Du kannst auch mehrere Schüler mit Kommas angeben. (z. B. student="1,2,3").', 'cp' ),
						'default' => 'empty',
						'description' => __( 'Wenn sowohl Schüler als auch Ausbilder angegeben werden, wird nur der Schüler verwendet.', 'cp' ),
						'suggested_label' => array(
							'content' => __( 'Etikett vor den vorgeschlagenen Kursen.', 'cp' ),
							'default' => __( 'Vorgeschlagene Kurse', 'cp' ),
						),
						'suggested_msg' => array(
							'content' => __( 'Es wird eine Meldung angezeigt, wenn der/die Schüler/in für keinen Kurs eingeschrieben ist, aber wir haben einige Kursvorschläge.', 'cp' ),
							'default' => sprintf(
								__( 'You are not enrolled in any courses.<br />Here are a few you might like, or %s' ),
								htmlentities( __( ' <a href="%s">siehe alle verfügbaren Kurse.</a>', 'cp' ) )
							),
						),
					),
					'show_withdraw_link' => array(
						'content' => __( 'Erlaube es, den Link zum Zurückziehen anzuzeigen, aber es funktioniert nur, wenn es ein Schüler ist und der Status auf "unvollständig" gesetzt ist.', 'cp' ),
						'default' => 'false',
					),
				),
			),
			'examples' => array(
				'[course_list]',
				'[course_list instructor="2"]',
				'[course_list student="3"]',
				'[course_list instructor="2,4,5"]',
				'[course_list show="dates,cost" limit="5"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_featured.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_featured() {
		$data = array(
			'shortcode' => 'course_featured',
			'content' => __( 'Zeigt einen empfohlenen Kurs.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'featured_title' => array(
						'content' => __( 'Der Titel, der für den vorgestellten Kurs angezeigt werden soll.', 'cp' ),
						'default' => __( 'Empfohlener Kurs', 'cp' ),
					),
					'button_title' => array(
						'content' => __( 'Text, der auf dem Call-to-Action-Button angezeigt werden soll.', 'cp' ),
						'default' => __( 'Erfahren Sie mehr.', 'cp' ),
					),
					'media_type' => array(
						'content' => __( 'Medientyp, der für den vorgestellten Kurs verwendet werden soll. Siehe [course_media].', 'cp' ),
						'default' => 'default',
						'options' => array( 'image', 'video', 'thumbnail', 'default' ),
					),
					'media_priority' => array(
						'content' => __( 'Medienpriorität, die für den vorgestellten Kurs verwendet werden soll. Siehe [course_media].', 'cp' ),
						'default' => __( 'Video', 'cp' ),
						'options' => array( 'image', 'video', 'default' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_featured course_id="42"]',
				'[course_featured course_id="11" featured_title="The best we got!"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_structure.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_structure() {
		$data = array(
			'shortcode' => 'course_structure',
			'content' => __( 'Zeigt eine Baumansicht der Kursstruktur an.', 'cp' ),
			'parameters' => array(
				'required' => array(
					'course_id' => array(
						'content' => __( 'Wenn außerhalb der WordPress-Schleife.', 'cp' ),
					),
				),
				'optional' => array(
					'deep' => array(
						'content' => __( 'Alle Kursmodule anzeigen.', 'cp' ),
						'default' => 'false',
					),
					'free_class' => array(
						'content' => __( 'Zusätzliche CSS-Klassen für die Gestaltung von kostenlosen Vorschaubildern.', 'cp' ),
						'default' => __( 'kostenlos', 'cp' ),
					),
					'free_show' => array(
						'content' => __( 'Für KOSTENLOSE Vorschauobjekte anzeigen.', 'cp' ),
						'default' => 'true',
					),
					'free_text' => array(
						'content' => __( 'Text zum Anzeigen für KOSTENLOSE Vorschauartikel.', 'cp' ),
						'default' => __( 'Vorschau', 'cp' ),
					),
					'label_delimeter' => array(
						'content' => __( 'Symbol für die Verwendung nach dem Etikett.', 'cp' ),
						'default' => ':',
					),
					'label' => array(
						'content' => __( 'Beschriftung, die für die Ausgabe angezeigt werden soll.', 'cp' ),
						'default' => __( 'Kursstruktur', 'cp' ),
					),
					'label_tag' => array(
						'content' => __( 'HTML-Tag (ohne Klammern), der für die einzelnen Beschriftungen verwendet werden soll.', 'cp' ),
						'default' => 'strong',
					),
					'show_divider' => array(
						'content' => __( 'Zeige eine Trennlinie zwischen den wichtigsten Elementen im Baum, "ja" oder "nein".', 'cp' ),
						'default' => __( 'ja', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
					'show_label' => array(
						'content' => __( 'Beschriftungstext als Baumüberschrift anzeigen, "ja" oder "nein".', 'cp' ),
						'default' => __( 'nein', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
					'show_title' => array(
						'content' => __( 'Zeige den Kurstitel in der Struktur an, "ja" oder "nein".', 'cp' ),
						'default' => __( '"Nein"', 'cp' ),
						'options' => array( 'yes', 'no' ),
					),
				),
			),
			'add_class_to_optional' => true,
			'examples' => array(
				'[course_structure]',
				'[course_structure course_id="42" free_text="'.__( 'Gratis!', 'cp' ).'" show_title="no"]',
				'[course_structure show_title="no" label="'.__( 'Lehrplan', 'cp' ).'"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for course_signup.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_course_signup() {
		$data = array(
			'shortcode' => 'course_signup',
			'content' => __( 'Zeigt eine benutzerdefinierte Login- oder Anmeldeseite für die Benutzerregistrierung und -anmeldung im Frontend an.', 'cp' ),
		   'note' => __( 'Dies ist bereits Teil von CoursePress und kann in den CoursePress-Einstellungen festgelegt werden. Links zu den Standardseiten findest du unter Erscheinungsbild > Menüs > CoursePress.', 'cp' ),
			'parameters' => array(
				'optional' => array(
					'failed_login_class' => array(
						'content' => __( 'CSS-Klasse, die für ungültige Anmeldungen verwendet wird.', 'cp' ),
						'default' => 'red',
					),
					'failed_login_text' => array(
						'content' => __( 'Text, der angezeigt wird, wenn der Benutzer sich nicht authentifiziert.', 'cp' ),
						'default' => __( 'Ungültige Anmeldung.', 'cp' ),
					),
					'login_tag' => array(
						'content' => __( 'Title Tag Wrapper.', 'cp' ),
						'default' => 'h3',
					),
					'login_title' => array(
						'content' => __( 'Titel für den Login-Bereich.', 'cp' ),
						'default' => __( 'Anmelden', 'cp' ),
					),
					'login_url' => array(
						'content' => __( 'URL, zu der du weitergeleitet wirst, wenn du auf "Hast du schon ein Konto?" klickst.', 'cp' ),
						'default' => __( 'Plugin-Standardwerte.', 'cp' ),
					),
					'logout_url' => array(
						'content' => __( 'URL, zu der weitergeleitet wird, wenn sich der Benutzer abmeldet.', 'cp' ),
						'default' => __( 'Plugin-Standardwerte.', 'cp' ),
					),
					'page' => array(
						'content' => __( 'Wenn der Seitenparameter nicht gesetzt ist, versucht CoursePress, die Variable "page" aus $_REQUEST zu verwenden.', 'cp' ),
						'default' => 'empty',
					),
					'signup_tag' => array(
						'content' => __( 'Title Tag Wrapper.', 'cp' ),
						'default' => 'h3',
					),
					'signup_title' => array(
						'content' => __( 'Titel für den Anmeldebereich.', 'cp' ),
						'default' => __( 'Registrieren', 'cp' ),
					),
					'signup_url' => array(
						'content' => __( 'URL, zu der du weitergeleitet wirst, wenn du auf "Du hast noch kein Konto? Gehe zur Anmeldung!"', 'cp' ),
						'default' => 'empty',
					),
				),
			),
			'examples' => array(
				'[course_signup]',
				'[course_signup signup_title="&lt;h1&gt;'.__( 'Jetzt registrieren', 'cp' ).'&lt;/h1&gt;"]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for courses_student_dashboard.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_courses_student_dashboard() {
		$data = array(
			'shortcode' => 'courses_student_dashboard',
			'content' => __( 'Lädt die Dashboard-Vorlage für Schüler.', 'cp' ),
			'examples' => array(
				'[courses_student_dashboard]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce help box for courses_student_settings.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private static function _box_courses_student_settings() {
		$data = array(
			'shortcode' => 'courses_student_settings',
			'content' => __( 'Lädt die Vorlage für die Schülereinstellungen.', 'cp' ),
			'examples' => array(
				'[courses_student_settings]',
			),
		);
		$content = self::_prepare_box( $data );
		return $content;
	}

	/**
	 * Produce Box.
	 *
	 * @since 2.0.2
	 * @access private
	 *
	 * @return string
	 */
	private static function _prepare_box( $data ) {
		$content = sprintf( '<span class="cp-shortcode-code">[%s]</span><br />', $data['shortcode'] );
		$content .= sprintf( '<p class="description">%s</p>', $data['content'] );
		if ( isset( $data['note'] ) ) {
			$content .= sprintf( __( '<p class="description"><strong>Hinweis</strong>: %s</p>', 'cp' ), $data['note'] );
		}
		if ( isset( $data['parameters'] ) ) {
			$kinds = array(
				'required' => __( 'Erforderliche Eigenschaften:', 'cp' ),
				'optional' => __( 'Optionale Attribute:', 'cp' ),
			);
			if ( isset( $data['add_class_to_optional'] ) && $data['add_class_to_optional'] ) {
				if ( ! isset( $data['parameters'] ) ) {
					$data['parameters'] = array();
				}
				if ( ! isset( $data['parameters']['optional'] ) ) {
					$data['parameters']['optional'] = array();
				}
				$data['parameters']['optional']['class'] = array( 'content' => __( 'Zusätzliche CSS-Klassen, die du für weiteres Styling verwenden kannst.', 'cp' ) );
			}
			foreach ( $kinds as $kind => $kind_label ) {
				if ( isset( $data['parameters'][ $kind ] ) && is_array( $data['parameters'][ $kind ] ) && ! empty( $data['parameters'][ $kind ] ) ) {
					$content .= sprintf( '<div class="cp-shortcode-attributes cp-shortcode-attributes-%s">', esc_attr( $kind ) );
					$content .= sprintf( '<p class="cp-shortcode-subheading">%s</p>', esc_html( $kind_label ) );
					$content .= '<ul class="cp-shortcode-options">';
					$attributes = $data['parameters'][ $kind ];
					ksort( $attributes );
					foreach ( $attributes as $attr_name => $attr_data ) {
                        $content .= sprintf( '<li class="shortcode-%s">', esc_attr( $attr_name ) );
                        $content .= '<p>';
						$content .= sprintf( '<span>%s</span>', esc_html( $attr_name ) );
						if ( isset( $attr_data['content'] ) ) {
							$content .= ' &ndash; ';
							$content .= $attr_data['content'];
						}
						if ( isset( $attr_data['options'] ) ) {
							$content .= '<p class="options">';
							$options = '<em>'.implode( '</em>, <em>', $attr_data['options'] ).'</em>';
                            $content .= sprintf( __( 'Optionen: %s.', 'cp' ), $options );
                            $content .= '</p>';
							if ( isset( $attr_data['options_description'] ) && ! empty( $attr_data['options_description'] ) ) {
								$content .= sprintf( '<p class="description">%s</p>', esc_html( $attr_data['options_description'] ) );
							}
                        }
                        $content .= '</p>';
						if ( isset( $attr_data['default'] ) && ! empty( $attr_data['default'] ) ) {
							$content .= '<p class="default">';
							switch ( $attr_data['default'] ) {
								case ':':
									$content .= __( 'Standard ist der Doppelpunkt (<em>:</em>)', 'cp' );
								break;
								case ',':
									$content .= __( 'Standard ist das Komma (<em>,</em>)', 'cp' );
								break;
								case 'WP':
										$content .= sprintf( __( 'Standard: <em>%s</em>.', 'cp' ), __( 'WordPress Settings' ) );
								break;
								case 'empty':
										$content .= sprintf( __( 'Standard: <em>%s</em>.', 'cp' ), __( 'empty string' ) );
								break;
								default:
									if ( is_numeric( $attr_data['default'] ) ) {
										$content .= sprintf( __( 'Standard: <em>%s</em>.', 'cp' ), htmlentities( $attr_data['default'] ) );
									} else {
										$content .= sprintf( __( 'Standard: "<em>%s</em>"', 'cp' ), htmlentities( $attr_data['default'] ) );
									}
                            }
                            $content .= '</p>';
                        }
                            if ( isset( $attr_data['description'] ) ) {
                                $content .= sprintf( '<p class="description">%s</p>', $attr_data['description'] );
                            }
							$content .= '</li>';
					}
						$content .= '</ul>';
						$content .= '</div>';

				}
			}
		} else {
			$content .= wpautop( __( 'Dieser Shortcode hat keine Parameter.', 'cp' ) );
		}
		if ( isset( $data['examples'] ) && is_array( $data['examples'] ) && ! empty( $data['examples'] ) ) {
			$content .= '<div class="cp-shortcode-examples">';
			$content .= sprintf( '<p class="cp-shortcode-subheading">%s</p>', esc_attr__( 'Beispiele:', 'cp' ) );
			$content .= '<code>';
			$content .= join( '<br />', $data['examples'] );
			$content .= '</code>';
			$content .= '</div>';
		}
		return $content;
	}
}