<?php
/**
 * Course Edit Step - 5
 **/
?>
<div class="step-title step-5">
	<?php _e( 'Schritt 5 – Klassen, Diskussionen & Arbeitsmappe', 'cp' ); ?>
	<div class="status <?php echo $setup_class; ?>"></div>
</div>

<div class="cp-box-content step-content step-5">
	<input type="hidden" name="meta_setup_step_5" value="saved" />

	<div class="wide class-size">
		<label><?php _e( 'Klassengröße', 'cp' ); ?></label>
		<p class="description"><?php _e( 'Verwende diese Einstellung, um ein Limit für alle Klassen festzulegen. Deaktiviere für unbegrenzte Klassengrösse(n).', 'cp' ); ?></p>
		<label class="narrow col">
			<input type="checkbox" name="meta_class_limited" <?php checked( true, $class_limited ); ?> />
			<span><?php _e( 'Klassengrösse begrenzen', 'cp' ); ?></span>
		</label>

		<label class="num-students narrow col <?php echo ( $class_limited ? '' : 'disabled' ); ?>">
			<?php _e( 'Anzahl der Lernende', 'cp' ); ?>
			<input type="text" class="spinners" name="meta_class_size" value="<?php echo $class_size; ?>" <?php echo ( $class_limited ? '' : 'disabled="disabled"' ); ?> />
		</label>
	</div>

	<?php
	$checkboxes = array(
		array(
			'meta_key' => 'allow_discussion',
			'title' => __( 'Kurs Diskussion', 'cp' ),
			'description' => __( 'Wenn aktiviert, können die Schüler Fragen stellen und erhalten Antworten auf einen Kursstufe. A ‚Diskussion‘ Menüpunkt für die Schüler, um alle Gespräche auftretenden von allen Teilnehmern und Dozenten zu sehen gegeben.', 'cp' ),
			'label' => __( 'Kursdiskussion zulassen', 'cp' ),
			'default' => false,
		),
		array(
			'meta_key' => 'allow_workbook',
			'title' => __( 'Arbeitsbuch für Schüler', 'cp' ),
			'description' => __( 'Wenn diese Option aktiviert ist, können die Schüler ihre Fortschritte und Noten sehen.', 'cp' ),
			'label' => __( 'Schülerarbeitsheft zeigen', 'cp' ),
			'default' => false,
		),
		array(
			'meta_key' => 'allow_grades',
			'title' => __( 'Schüler Noten', 'cp' ),
			'description' => __( 'Wenn diese Option aktiviert, können Studenten ihre Noten sehen.', 'cp' ),
			'label' => __( 'Noten anzeigen', 'cp' ),
			'default' => false,
		),
	);

	foreach ( $checkboxes as $one ) {
		echo CoursePress_Helper_UI::course_edit_checkbox( $one, $course_id );
	}

	/**
	 * Trigger after printing fields at step 5.
	 *
	 * The dynamic portion of this hook is to allow additional course meta fields.
	 **/
	echo apply_filters( 'coursepress_course_setup_step_5', '', $course_id );

	/**
	 * Print button **/
	echo CoursePress_View_Admin_Course_Edit::get_buttons( $course_id, 5 );
	?>
</div>