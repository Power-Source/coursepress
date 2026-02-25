<?php

class CoursePress_View_Admin_Setting_Setup {

	public static function init() {
		add_filter(
			'coursepress_settings_tabs',
			array( __CLASS__, 'add_tabs' )
		);
		add_action(
			'coursepress_settings_process_setup',
			array( __CLASS__, 'process_form' ), 10, 2
		);
		add_filter(
			'coursepress_settings_render_tab_setup',
			array( __CLASS__, 'return_content' ),
			10, 3
		);

		if ( isset( $_GET['tab'] ) && 'setup' == $_GET['tab'] ) {
			add_filter(
				'coursepress_settings_tabs_content',
				array( __CLASS__, 'remove_tabs' ),
				10, 2
			);
			add_filter(
				'coursepress_settings_page_main',
				array( __CLASS__, 'return_content' )
			);

			// TODO: This is premium only. move to premium folder!
			add_action(
				'coursepress_settings_page_pre_render',
				array( __CLASS__, 'remove_dashboard_notification' )
			);
		}
	}

	public static function add_tabs( $tabs ) {
		$tabs['setup'] = array(
			'title' => __( 'Setup Guide', 'cp' ),
			'description' => __( 'Dies ist eine Beschreibung dessen, was Du auf dieser Seite tun kannst.', 'cp' ),
			'order' => 70,
			'class' => 'setup_tab',
		);

		return $tabs;
	}

	public static function return_content( $content ) {
		ob_start();
?>
<div class="wrap about-wrap cp-wrap">
	<h1><?php _e( 'Willkommen bei', 'cp' ); ?> <?php echo CoursePress::$name; ?></h1>

	<div class="about-text">
<?php
		printf( __( '%s hat einige Dinge getan, um Dir den Einstieg zu erleichtern.', 'cp' ), CoursePress::$name );
?>
		<br/>
<?php
		_e( 'Es wurden ein paar dynamische Seiten mit den Bezeichnungen „Kurse“ und „Dashboard“ erstellt und zu Deiner Navigation hinzugefügt.', 'cp' );
?>
		<br/>
<?php
		printf( __( 'Wenn diese auf Deiner Webseite und Deinem Theme nicht sichtbar sind, musst Du möglicherweise Deine %s überprüfen.', 'cp' ), '<a href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Menüeinstellungen', 'cp' ) . '</a>' );
?>
		<br/>
<?php
		printf( __( '%s hat auch MarketPress installiert - aber nicht aktiviert.', 'cp' ), CoursePress::$name );
?>
		<br/>
		<?php _e( 'Für diejenigen unter Ihnen, die Ihre großartigen Kurse verkaufen möchten, musst Du ein Zahlungsgateway aktivieren und einrichten. Aber dazu später mehr.', 'cp' ); ?>
	</div>

	<h1><?php _e( 'Lass uns anfangen', 'cp' ); ?></h1>

	<div class="changelog">
		<h3><?php _e( 'Schritt 1. Erstelle einen Kurs', 'cp' ); ?></h3>

		<div class="about-text">
			<ul>
				<li><?php _e( 'Füge Kurstitel und Beschreibung hinzu', 'cp' ); ?></li>
				<li><?php _e( 'Weise einen Kursleiter zu', 'cp' ); ?></li>
				<li><?php _e( 'Konfiguriere Anwesenheits- und Zugriffseinstellungen', 'cp' ); ?></li>
				<li><?php _e( 'Richte Zahlungsgateways für kostenpflichtige Kurse ein', 'cp' ); ?></li>
			</ul>

		</div>
		<br/>
		<img alt="" src="<?php echo esc_attr_e( CoursePress::$url . 'asset/img/quick-setup/step-1.jpg' ); ?>" class="image-66">
	</div>

	<div class="changelog">
		<h3><?php _e( 'Schritt 2. Kursinhalte hinzufügen', 'cp' ); ?></h3>

		<div class="about-text">
<?php
		_e( 'Kurse sind in Einheiten strukturiert. Einheiten bestehen aus Elementen, die auf einer einzelnen Seite oder über mehrere Seiten hinweg präsentiert werden können. Elemente umfassen', 'cp' );
?>
			<ul>
				<li><?php _e( 'Text, Video & Audio', 'cp' ); ?></li>
				<li><?php _e( 'Datei-Upload und -Download', 'cp' ); ?></li>
				<li><?php _e( 'Multiple- und Single-Choice-Fragen', 'cp' ); ?></li>
				<li><?php _e( 'Testantwortfelder', 'cp' ); ?></li>
			</ul>

		</div>
		<img alt="" src="<?php echo esc_attr_e( CoursePress::$url . 'asset/img/quick-setup/step-2.jpg' ); ?>" class="image-66">

	</div>

	<div class="changelog">
		<h3><?php _e( 'Schritt 3. Studenten einschreiben', 'cp' ); ?></h3>

		<div class="about-text">
<?php
		_e( 'Konfiguriere die Einschreibung von Studenten, wähle entweder:', 'cp' );
?>
			<ul>
				<li><?php _e( 'Füge Studenten manuell hinzu, mit oder ohne Passcode-Beschränkung', 'cp' ); ?></li>
				<li><?php _e( 'Schreibe Studenten automatisch nach der Registrierung und/oder Zahlung ein', 'cp' ); ?></li>
			</ul>

		</div>

	</div>

	<div class="changelog">
		<h3><?php _e( 'Schritt 4. Veröffentliche deinen Kurs!', 'cp' ); ?></h3>

		<div class="about-text">
<?php
		_e( 'Es gibt viele weitere Funktionen in CoursePress, aber das sind die Grundlagen, um loszulegen. Jetzt ist es an der Zeit, den Kurs zu veröffentlichen und deinen Studenten beim Lernen zuzusehen.', 'cp' );
?>
			<br/><br/>

		</div>
		<img alt="" src="<?php esc_attr_e( CoursePress::$url . 'asset/img/quick-setup/step-3.jpg' ); ?>" class="image-66">

	</div>

	<div class="changelog">
		<h3><?php _e( 'Schritt 5. Kursverwaltung', 'cp' ); ?></h3>

		<div class="about-text">
			<ul>
				<li><?php _e( 'Verwalte Kursleiter und Studenten', 'cp' ); ?></li>
				<li><?php _e( 'Verwalte die Bewertung der eingereichten Arbeiten der Studenten', 'cp' ); ?></li>
				<li><?php _e( 'Erstelle Berichte auf Einheiten-/Kurs-/Seitenebene', 'cp' ); ?></li>
			</ul>
		</div>

<?php
if ( current_user_can( 'manage_options' ) && ! get_option( 'permalink_structure' ) ) {
	// toplevel_page_courses
	$screen = get_current_screen();

	$show_warning = false;

	if ( 'toplevel_page_courses' == $screen->id && isset( $_GET['quick_setup'] ) ) {
		$show_warning = true;
	}

	if ( $show_warning ) {
?>
		<div class="permalinks-error">
			<h4><?php _e( 'Pretty permalinks are required to use CoursePress.', 'cp' ); ?></h4>

			<p><?php _e( 'Klicke auf die Schaltfläche unten, um deine Permalinks einzurichten.', 'cp' ); ?></p>
			<a href="<?php echo admin_url( 'options-permalink.php' ); ?>" class="button button-units save-unit-button setup-permalinks-button"><?php _e( 'Permalinks einrichten', 'cp' ); ?></a>
		</div>
<?php
	}
} else {
	$url = admin_url('post-new.php?post_type=' . CoursePress_Data_Course::get_post_type_name());
?>
	<a href="<?php echo esc_url( $url ); ?>" class="button button-units save-unit-button start-course-button"><?php _e( 'Starte jetzt mit dem Erstellen deines eigenen Kurses &rarr;', 'cp' ); ?></a>
<?php
}
?>
	</div>
</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public static function remove_tabs( $wrapper, $content ) {
		$wrapper = $content;
		return $wrapper;
	}

	public static function remove_dashboard_notification() {
		if ( isset( $_GET['tab'] ) && 'setup' === $_GET['tab'] ) {
			global $wpmudev_notices;
			$wpmudev_notices = array();
		}
	}


	public static function process_form() {
	}
}