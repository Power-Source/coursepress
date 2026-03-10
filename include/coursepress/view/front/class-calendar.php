<?php

class CoursePress_View_Front_Calendar {

	public static function init() {
		add_action( 'wp_ajax_refresh_course_calendar', array( __CLASS__, 'refresh_course_calendar' ) );
		add_action( 'wp_ajax_nopriv_refresh_course_calendar', array( __CLASS__, 'refresh_course_calendar' ) );
	}

	public static function refresh_course_calendar() {
		$ajax_response = array();
		$ajax_status   = 1; //success

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'coursepress_calendar_refresh' ) ) {
			$ajax_status = 0;
		} elseif ( ! empty( $_POST['date'] ) && ! empty( $_POST['course_id'] ) ) {

			$course_id = (int) $_POST['course_id'];
			$date_raw = sanitize_text_field( wp_unslash( $_POST['date'] ) );

			if ( $course_id < 1 || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date_raw ) ) {
				$ajax_status = 0;
			} else {
				$course = get_post( $course_id );
				$course_post_type = CoursePress_Data_Course::get_post_type_name();

				if ( empty( $course ) || $course_post_type !== $course->post_type ) {
					$ajax_status = 0;
				} elseif ( 'publish' !== $course->post_status && ! current_user_can( 'edit_post', $course_id ) ) {
					$ajax_status = 0;
				} else {
					$date = getdate( strtotime( str_replace( '-', '/', $date_raw ) ) );
					$pre  = ! empty( $_POST['pre_text'] ) ? sanitize_text_field( wp_unslash( $_POST['pre_text'] ) ) : false;
					$next = ! empty( $_POST['next_text'] ) ? sanitize_text_field( wp_unslash( $_POST['next_text'] ) ) : false;

					$calendar = new CoursePress_Template_Calendar( array(
						'course_id' => $course_id,
						'month'     => $date['mon'],
						'year'      => $date['year'],
					) );

					$html = '';

					if ( $pre && $next ) {
						$html = $calendar->create_calendar( $pre, $next );
					} else {
						$html = $calendar->create_calendar();
					}

					$ajax_response['calendar'] = $html;
				}
			}
		}

		$response = array(
			'what'   => 'refresh_course_calendar',
			'action' => 'refresh_course_calendar',
			'id'     => $ajax_status,
			'data'   => json_encode( $ajax_response ),
		);

		ob_end_clean();
		ob_start();
		$xmlresponse = new WP_Ajax_Response( $response );
		$xmlresponse->send();
		ob_end_flush();

		exit;
	}
}