<?php
/**
 * Plugin load class.
 *
 * @author   ThimPress
 * @package  LearnPress/Co-Instructor/Classes
 * @version  3.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_Co_Instructor' ) ) {
	/**
	 * Class LP_Addon_Co_Instructor
	 */
	class LP_Addon_Co_Instructor extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_CO_INSTRUCTOR_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_CO_INSTRUCTOR_REQUIRE_VER;

		/**
		 * Path file addon.
		 *
		 * @var string
		 */
		public $plugin_file = LP_ADDON_CO_INSTRUCTOR_FILE;

		/**
		 * LP_Addon_Co_Instructor constructor.
		 */
		public function __construct() {
			parent::__construct();

			// Prepare user data
			$this->user = get_current_user_id();

			add_action( 'plugins_loaded', array( $this, 'backward_add_co_instructor_emails' ) );

			$current_user = wp_get_current_user();
			if ( in_array( 'lp_teacher', $current_user->roles ) || in_array( 'administrator', $current_user->roles ) ) {
				add_filter( 'learn-press/profile-tabs', array( $this, 'add_profile_instructor_tab' ) );
			}
		}

		/**
		 * Define Learnpress Co-Instructor constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			define( 'LP_ADDON_CO_INSTRUCTOR_PATH', dirname( LP_ADDON_CO_INSTRUCTOR_FILE ) );
			define( 'LP_ADDON_CO_INSTRUCTOR_INC', LP_ADDON_CO_INSTRUCTOR_PATH . '/inc/' );
			define( 'LP_ADDON_CO_INSTRUCTOR_TEMPLATE', LP_ADDON_CO_INSTRUCTOR_PATH . '/templates/' );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 3.0.0
		 */
		protected function _includes() {
			include_once LP_ADDON_CO_INSTRUCTOR_INC . 'functions.php';
			include_once LP_ADDON_CO_INSTRUCTOR_INC . 'class-lp-co-instructor-database.php';
		}

		/**
		 * Hook into actions and filters.
		 */
		protected function _init_hooks() {
			// add_action( 'wp_before_admin_bar_render', array( $this, 'before_admin_bar_render' ) );
			add_filter( 'learn-press/edit-admin-bar-button', array( $this, 'before_admin_bar_course_item' ), 10, 2 );

			$current_user = wp_get_current_user();

			if ( $current_user && in_array( LP_TEACHER_ROLE, $current_user->roles ) ) {
				add_filter( 'learnpress/get-post-type-lp-on-backend', array( $this, 'get_items_of_co_instructor' ),
					11 );
			}


			add_action(
				'learnpress/course-settings/after-author',
				function () {
					global $thepostid;

					if ( LP()->settings()->get( 'enable_course_co_instructor' ) !== 'yes' && ! current_user_can( 'administrator' ) ) {
						return;
					}

					$class       = '';
					$post_author = '';

					if ( isset( $_GET['post'] ) && isset( get_post( $_GET['post'] )->post_author ) ) {
						$post_author = get_post( $_GET['post'] )->post_author;

						if ( $post_author != get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
							$class = 'hidden';
						}
					}

					$instructor_roles = apply_filters( 'learn-press/co-instructor/instructor-roles',
						array( 'administrator', 'lp_teacher' ) );
					$users            = array();
					$instructors      = get_users(
						array(
							'role__in' => $instructor_roles,
							'exclude'  => $post_author,
						)
					);
					foreach ( $instructors as $instructor ) {
						$users[ $instructor->ID ] = $instructor->user_login;
					}

					$values = get_post_meta( $thepostid, '_lp_co_teacher', false ) ?? array();

					lp_meta_box_select_field(
						array(
							'id'            => '_lp_co_teacher',
							'label'         => esc_html__( 'Co-Instructors', 'learnpress-co-instructor' ),
							'options'       => $users,
							'value'         => $values,
							'multiple'      => true,
							'style'         => 'min-width:200px',
							'class'         => $class,
							'wrapper_class' => 'lp-select-2',
							'placeholder'   => esc_html__( 'Instructors', 'learnpress-co-instructor' ),
							'description'   => sizeof( $users ) ? __(
								'Colleagues will work with you.',
								'learnpress-co-instructor'
							) : wp_kses(
								__(
									'There is no instructor to select. Create <a href="' . admin_url( 'user-new.php' ) . '" target="_blank">here</a>.',
									'learnpress-co-instructor'
								),
								array(
									'a' => array(
										'href'   => array(),
										'target' => array(),
									),
								)
							),
						)
					);
				}
			);

			add_action(
				'learnpress_save_lp_course_metabox',
				function ( $post_id = 0 ) {
					if ( LP()->settings()->get( 'enable_course_co_instructor' ) !== 'yes' && ! current_user_can( 'administrator' ) ) {
						return;
					}

					$values     = get_post_meta( $post_id, '_lp_co_teacher', false ) ?? array();
					$co_teacher = isset( $_POST['_lp_co_teacher'] ) ? (array) wp_unslash( $_POST['_lp_co_teacher'] ) : array();

					$array_values = ! empty( $values ) ? array_values( $values ) : array();
					$co_values    = ! empty( $co_teacher ) ? array_values( $co_teacher ) : array();

					$del_val = array_diff( $array_values, $co_values );
					$new_val = array_diff( $co_values, $array_values );

					foreach ( $del_val as $level_id ) {
						delete_post_meta( $post_id, '_lp_co_teacher', $level_id );
					}

					foreach ( $new_val as $level_id ) {
						add_post_meta( $post_id, '_lp_co_teacher', $level_id, false );
					}
				}
			);

			add_filter(
				'learn-press/course-settings-fields/general',
				function ( $settings ) {
					$co_instructor = array(
						'title'   => esc_html__( 'Enable Co-Instructor', 'learnpress' ),
						'id'      => 'enable_course_co_instructor',
						'default' => 'no',
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'Instructor can set Co-Instructor in course setting?',
							'learnpress' ),
					);

					foreach ( $settings as $index => $setting ) {
						$new_settings[] = $setting;

						if ( isset( $setting['id'] ) && $setting['id'] === 'course_thumbnail_dimensions' ) {
							$new_settings[] = $co_instructor;
							$co_instructor  = false;
						}
					}

					if ( $co_instructor ) {
						$new_settings[] = $co_instructor;
					}

					return $new_settings;
				}
			);

			// add_filter( 'learn_press_valid_courses', array( $this, 'get_available_courses' ) );
			// add_filter( 'learn_press_valid_lessons', array( $this, 'co_instructor_valid_lessons' ) );
			// add_filter( 'learn_press_valid_quizzes', array( $this, 'co_instructor_valid_quizzes' ) );
			// add_filter( 'learn_press_valid_questions', array( $this, 'co_instructor_valid_questions' ) );

			// add_action( 'admin_head-post.php', array( $this, 'process_teacher' ) );

			// add co-instructor settings in admin settings page
			add_filter( 'learn-press/profile-settings-fields/sub-tabs', array( $this, 'co_instructor_settings' ), 10,
				2 );

			// update post author for items in course, quiz
			add_filter( 'learnpress_course_insert_item_args', array( $this, 'course_insert_item_args' ) );
			add_filter( 'learnpress_quiz_insert_item_args', array( $this, 'quiz_insert_question_args' ), 10, 2 );

			add_filter( 'learn_press_excerpt_duplicate_post_meta', array( $this, 'excerpt_duplicate_post_meta' ), 10,
				3 );

			add_action( 'learn-press/after-single-course-instructor', array( $this, 'single_course_instructors' ) );
		}

		/**
		 * Add email classes.
		 */
		public function add_co_instructor_emails( &$emails ) {
			$emails['LP_Email_Enrolled_Course_Co_Instructor'] = include 'emails/class-lp-co-instructor-email-enrolled-course.php';
			$emails['LP_Email_Finished_Course_Co_Instructor'] = include 'emails/class-lp-co-instructor-email-finished-course.php';
		}

		public function backward_add_co_instructor_emails() {
			if ( class_exists( 'LP_Emails' ) ) {
				$emails = LP_Emails::instance()->emails;
				$this->add_co_instructor_emails( $emails );
				LP_Emails::instance()->emails = $emails;
			}
		}

		/**
		 * Remove edit course in admin bar for unauthorized user.
		 *
		 * @return mixed
		 */
		public function before_admin_bar_render() {
			global $post, $wp_admin_bar;

			if ( current_user_can( 'administrator' ) ) {
				return $wp_admin_bar;
			}

			if ( learn_press_is_course() && ! in_array( $post->ID, $this->get_available_courses() ) ) {
				$wp_admin_bar->remove_menu( 'edit' );
			}

			return $wp_admin_bar;
		}

		/**
		 * Remove edit lesson, quiz, question in admin bar for unauthorized user.
		 *
		 * @param $can_edit
		 * @param $course_item
		 *
		 * @return bool
		 */
		public function before_admin_bar_course_item( $can_edit, $course_item ) {
			if ( ! $course_item ) {
				return false;
			}

			if ( current_user_can( 'administrator' ) ) {
				return true;
			}

			$item_id = $course_item->get_id();
			$type    = get_post_type( $item_id );
			if ( $type == LP_LESSON_CPT ) {
				if ( in_array( $item_id, $this->co_instructor_valid_lessons() ) ) {
					return false;
				}
			} elseif ( $type == LP_QUIZ_CPT ) {
				if ( in_array( $item_id, $this->co_instructor_valid_quizzes() ) ) {
					return false;
				}
			} elseif ( $type == LP_QUESTION_CPT ) {
				if ( in_array( $item_id, $this->co_instructor_valid_questions() ) ) {
					return false;
				}
			}

			return apply_filters( 'learn-press/co-instructor/edit-admin-bar', $can_edit, $item_id );
		}


		/**
		 * Pre query items for co-instructor.
		 *
		 * @param array $query
		 *
		 * @return mixed
		 */
		public function get_items_of_co_instructor( $query ) {
			$current_user = wp_get_current_user();

			if ( ! $current_user ) {
				return $query;
			}

			if ( in_array( 'administrator', $current_user->roles ) ) {
				return $query;
			}

			if ( is_admin() && function_exists( 'get_current_screen' ) && in_array( LP_TEACHER_ROLE,
					$current_user->roles ) ) {
				$current_screen   = get_current_screen();
				$screen_check_arr = array( 'edit-' . LP_COURSE_CPT );

				if ( $current_screen && in_array( $current_screen->id, $screen_check_arr ) ) {
					$courses = $this->get_available_courses();

					if ( count( $courses ) > 0 ) {
						unset( $query->query_vars['author'] );
					}

					$query->set( 'post_type', LP_Helper::sanitize_params_submitted( $_GET['post_type'] ) );
					$query->set( 'post__in', $courses );

					// Fix is_post_type_archive $post_type_object object null
					$query->is_post_type_archive = 0;

					// add_filter( 'views_edit-lp_course', array( $this, 'restrict_co_instructor_items' ), 20 );

					return $query;
				}
			}
		}

		/**
		 * Restrict co-instructor items.
		 *
		 * @param $views
		 *
		 * @return mixed
		 */
		public function restrict_co_instructor_items( $views ) {
			$post_type = get_query_var( 'post_type' );
			$author    = get_current_user_id();

			$new_views = array(
				'all'        => __( 'All', 'learnpress-co-instructor' ),
				'mine'       => __( 'Mine', 'learnpress-co-instructor' ),
				'publish'    => __( 'Published', 'learnpress-co-instructor' ),
				'private'    => __( 'Private', 'learnpress-co-instructor' ),
				'pending'    => __( 'Pending Review', 'learnpress-co-instructor' ),
				'future'     => __( 'Scheduled', 'learnpress-co-instructor' ),
				'draft'      => __( 'Draft', 'learnpress-co-instructor' ),
				'trash'      => __( 'Trash', 'learnpress-co-instructor' ),
				'co_teacher' => __( 'Co-instructor', 'learnpress-co-instructor' ),
			);

			$url = 'edit.php';

			foreach ( $new_views as $view => $name ) {

				$query = array(
					'post_type' => $post_type,
				);

				if ( $view == 'all' ) {
					$query['all_posts'] = 1;
					$class              = ( get_query_var( 'all_posts' ) == 1 || ( get_query_var( 'post_status' ) == '' && get_query_var( 'author' ) == '' ) ) ? ' class="current"' : '';
				} elseif ( $view == 'mine' ) {
					$query['author'] = $author;
					$class           = ( get_query_var( 'author' ) == $author ) ? ' class="current"' : '';
				} elseif ( $view == 'co_teacher' ) {
					$query['author'] = - $author;
					$class           = ( get_query_var( 'author' ) == - $author ) ? ' class="current"' : '';
				} else {
					$query['post_status'] = $view;
					$class                = ( get_query_var( 'post_status' ) == $view ) ? ' class="current"' : '';
				}

				$result = new WP_Query( $query );

				if ( $result->found_posts > 0 ) {
					$views[ $view ] = sprintf(
						'<a href="%s" ' . $class . '>' . $name . ' <span class="count">(%d)</span></a>',
						esc_url( add_query_arg( $query, $url ) ),
						$result->found_posts
					);
				} else {
					unset( $views[ $view ] );
				}
			}

			return $views;
		}

		/**
		 * Get all editable courses of current user.
		 *
		 * @return array
		 */
		public function get_available_courses() {
			$user = learn_press_get_current_user();

			if ( ! $user->is_admin() && ! $user->is_instructor() ) {
				return array();
			}

			$courses = LP_CO_Instructor_DB::getInstance()->get_post_of_instructor( $user->get_id() );

			$course_factory = new LP_Course_CURD();
			$course_factory->read_course_sections( $courses );

			return $courses;
		}

		/**
		 * Get all editable lessons of current user, return array lessons id.
		 *
		 * @param $courses
		 *
		 * @return array
		 * @since 3.0.0
		 */
		public function get_available_lessons( $courses ) {
			$user_id = get_current_user_id();

			/**
			 * Cache available lessons for instructor
			 *
			 * @since 3.0.0
			 */
			$lessons = wp_cache_get( 'user-' . $user_id, 'co-instructor-lessons' );
			if ( false === $lessons ) {
				global $wpdb;

				$query = $wpdb->prepare(
					"
					SELECT ID FROM $wpdb->posts
					WHERE ( post_type = %s OR post_type = %s )
					AND post_author = %d
				",
					'lpr_lesson',
					'lp_lesson',
					get_current_user_id()
				);

				$lessons = $wpdb->get_col( $query );
				if ( $courses ) {
					foreach ( $courses as $course_id ) {
						$temp    = $this->get_available_lesson_from_course( $course_id );
						$lessons = array_unique( array_merge( $lessons, $temp ) );
					}
				}

				wp_cache_set( 'user-' . $user_id, $lessons, 'co-instructor-lessons' );
			}

			return $lessons;
		}

		/**
		 * Get all editable quizzes of current user, return array quizzes id.
		 *
		 * @param $courses
		 *
		 * @return array
		 * @since 3.0.0
		 */
		public function get_available_quizzes( $courses ) {
			$user_id = get_current_user_id();

			/**
			 * Cache quizzes for instructor
			 *
			 * @since 3.0.0
			 */
			$quizzes = wp_cache_get( 'user-' . $user_id, 'co-instructor-quizzes' );
			if ( false === $quizzes ) {
				global $wpdb;
				$query = $wpdb->prepare(
					"
					SELECT ID FROM $wpdb->posts
					WHERE ( post_type = %s OR post_type = %s )
					AND post_author = %d
				",
					'lpr_quiz',
					'lp_quiz',
					get_current_user_id()
				);

				// get quizzes of self co-instructor.
				$quizzes = $wpdb->get_col( $query );
				if ( $courses ) {
					foreach ( $courses as $course ) {
						$temp    = $this->get_available_quizzes_from_course( $course );
						$quizzes = array_unique( array_merge( $quizzes, $temp ) );
					}
				}

				wp_cache_set( 'user-' . $user_id, $quizzes, 'co-instructor-quizzes' );
			}

			return $quizzes;
		}

		public function get_available_questions( $quizzes ) {
			global $wpdb;

			$query = $wpdb->prepare(
				"
				SELECT ID FROM $wpdb->posts
				WHERE  post_type = %s
				AND post_author = %d",
				'lp_question',
				get_current_user_id()
			);

			$questions = $wpdb->get_col( $query );

			if ( $quizzes ) {
				foreach ( $quizzes as $quiz ) {
					$temp      = $this->get_available_question_from_quiz( $quiz );
					$questions = array_unique( array_merge( $questions, $temp ) );
				}
			}

			return $questions;
		}

		/**
		 * Get all lessons from course.
		 *
		 * @param null $course_id
		 *
		 * @return array
		 * @since 3.0.0
		 */
		public function get_available_lesson_from_course( $course_id = null ) {
			if ( empty( $course_id ) ) {
				return array();
			}

			$course  = learn_press_get_course( $course_id );
			$lessons = $course->get_items( LP_LESSON_CPT );

			$available = array();

			if ( $lessons ) {
				foreach ( $lessons as $lesson_id ) {
					$available[ $lesson_id ] = absint( $lesson_id );
				}
			}

			return $available;
		}

		/**
		 * Get all quizzes from course, return array quizzes ids.
		 *
		 * @param null $course_id
		 *
		 * @return array
		 * @since 3.0.0
		 */
		public function get_available_quizzes_from_course( $course_id = null ) {
			if ( empty( $course_id ) ) {
				return array();
			}

			$course  = learn_press_get_course( $course_id );
			$quizzes = $course->get_items( LP_QUIZ_CPT );

			$available = array();

			if ( $quizzes ) {
				foreach ( $quizzes as $quiz_id ) {
					$available[ $quiz_id ] = absint( $quiz_id );
				}
			}

			return $available;
		}

		/**
		 * Get all questions form quiz, return array questions ids.
		 *
		 * @param null $quiz_id
		 *
		 * @return array
		 */
		public function get_available_question_from_quiz( $quiz_id = null ) {
			if ( empty( $quiz_id ) ) {
				return array();
			}

			$quiz      = learn_press_get_quiz( $quiz_id );
			$questions = $quiz->get_questions();

			$available = array();

			foreach ( $questions as $question_id ) {
				$available[] = absint( $question_id );
			}

			return $available;
		}

		/**
		 * Add co-instructor settings in course meta box.
		 *
		 * @param $meta_box
		 *
		 * @return mixed
		 */
		public function add_meta_box( $meta_box ) {
			$class       = '';
			$post_author = '';

			if ( isset( $_GET['post'] ) && isset( get_post( $_GET['post'] )->post_author ) ) {
				$post_author = get_post( $_GET['post'] )->post_author;
				if ( $post_author != get_current_user_id() && ! current_user_can( 'manage_options' ) ) {
					$class = 'hidden';
				}
			}

			// roles can be co-instructor
			$instructor_roles = apply_filters(
				'learn-press/co-instructor/instructor-roles',
				array(
					'administrator',
					'lp_teacher',
					'lpr_teacher',
				)
			);

			// get users
			$users       = array();
			$instructors = get_users(
				array(
					'role__in' => $instructor_roles,
					'exclude'  => $post_author,
				)
			);
			foreach ( $instructors as $instructor ) {
				$users[ $instructor->ID ] = $instructor->user_login;
			}

			// show option when has user options
			$meta_box['fields'][] = array(
				'name'        => __( 'Co-Instructors', 'learnpress-co-instructor' ),
				'id'          => '_lp_co_teacher',
				'desc'        => sizeof( $users ) ? __(
					'Colleagues will work with you.',
					'learnpress-co-instructor'
				) : wp_kses(
					__(
						'There is no instructor to select. Create <a href="' . admin_url( 'user-new.php' ) . '" target="_blank">here</a>.',
						'learnpress-co-instructor'
					),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					)
				),
				'class'       => $class,
				'multiple'    => true,
				'type'        => 'select_advanced',
				'placeholder' => __( 'Instructors', 'learnpress-co-instructor' ),
				'options'     => $users,
			);

			return $meta_box;
		}

		/**
		 * Valid lessons.
		 *
		 * @return array
		 */
		public function co_instructor_valid_lessons() {
			$courses = $this->get_available_courses();

			return $this->get_available_lessons( $courses );
		}

		/**
		 * Valid quizzes.
		 *
		 * @return array
		 */
		public function co_instructor_valid_quizzes() {
			$courses = $this->get_available_courses();

			return $this->get_available_quizzes( $courses );
		}

		/**
		 * Valid questions.
		 *
		 * @return array
		 */
		public function co_instructor_valid_questions() {
			$quizzes = $this->co_instructor_valid_quizzes();

			return $this->get_available_questions( $quizzes );
		}

		/**
		 * Check Co-instructor processes.
		 */
		public function process_teacher() {
			global $post;

			if ( current_user_can( 'manage_options' ) ) {
				return;
			}

			$post_id = $post->ID;
			if ( current_user_can( LP_TEACHER_ROLE ) ) {
				if ( $post->post_author == get_current_user_id() ) {
					return;
				}
				$courses   = apply_filters( 'learn_press_valid_courses', array() );
				$lessons   = apply_filters( 'learn_press_valid_lessons', array() );
				$quizzes   = apply_filters( 'learn_press_valid_quizzes', array() );
				$questions = apply_filters( 'learn_press_valid_questions', array() );

				// get all types
				$all = array_merge( $courses, $lessons, $quizzes, $questions );

				if ( in_array( $post_id, $all ) ) {
					return;
				}

				// wp_die( __( 'Sorry! You don\'t have permission to do this action', 'learnpress-co-instructor' ), 403 );
			}
		}

		/**
		 * Add co-instructor settings in admin settings.
		 *
		 * @param $settings
		 * @param $object
		 *
		 * @return array
		 */
		public function co_instructor_settings( $settings, $object ) {
			$instructor_setting = array(
				'title'       => esc_html__( 'Instructor', 'learnpress-co-instructor' ),
				'id'          => 'profile_endpoints[profile-instructor]',
				'default'     => 'instructor',
				'type'        => 'text',
				'placeholder' => '',
				'desc'        => __(
					                 'This is a slug and should be unique.',
					                 'learnpress-co-instructor'
				                 ) . sprintf(
					                 ' %s <code>[profile/admin/instructor]</code>',
					                 __( 'Example link is', 'learnpress-co-instructor' )
				                 ),
			);

			$instructor_setting = apply_filters(
				'learn_press_page_settings_item_instructor',
				$instructor_setting,
				$settings,
				$object
			);

			$new_settings = array();

			foreach ( $settings as $index => $setting ) {
				$new_settings[] = $setting;

				if ( isset( $setting['id'] ) && $setting['id'] === 'profile_endpoints[profile-order-details]' ) {
					$new_settings[]     = $instructor_setting;
					$instructor_setting = false;
				}
			}

			if ( $instructor_setting ) {
				$new_settings[] = $instructor_setting;
			}

			return $new_settings;
		}

		/**
		 * Insert post author of items in course.
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function course_insert_item_args( $args ) {
			$owner               = $this->get_own_user_of_post();
			$args['post_author'] = $owner;

			return $args;
		}

		/**
		 * Insert post author of items in quiz.
		 *
		 * @param $args
		 * @param $quiz_id
		 *
		 * @return mixed
		 */
		public function quiz_insert_question_args( $args, $quiz_id ) {
			$author = get_current_user_id();

			if ( ! empty( $quiz_id ) ) {
				$post   = get_post( $quiz_id );
				$author = $post->post_author;
			}

			if ( ! empty( $author ) ) {
				$args['post_author'] = $author;
			}

			return $args;
		}

		/**
		 * Get own user.
		 *
		 * @return int
		 */
		public function get_own_user_of_post() {
			global $post;

			if ( current_user_can( 'administrator' ) && isset( $_REQUEST['_lp_course_author'] ) && ! empty( $_REQUEST['_lp_course_author'] ) ) {
				$this->user = $_REQUEST['_lp_course_author'];
			} else {
				$this->user = $post->post_author;
			}
			$this->user = absint( $this->user );

			return $this->user;
		}

		/**
		 * Add instructor tab in profile page.
		 *
		 * @param $tabs
		 *
		 * @return array
		 */
		public function add_profile_instructor_tab( $tabs ) {
			$tab = apply_filters(
				'learn-press-co-instructor/profile-tab',
				array(
					'title'    => esc_html__( 'Co-Instructor', 'learnpress-co-instructor' ),
					'icon'     => '<i class="fas fa-user-edit"></i>',
					'callback' => array( $this, 'profile_instructor_tab_content' ),
				),
				$tabs
			);

			$instructor_endpoint = LP()->settings()->get( 'profile_endpoints.profile-instructor', 'instructor' );

			if ( empty( $instructor_endpoint ) || empty( $tab ) ) {
				return $tabs;
			}

			if ( in_array( $instructor_endpoint, array_keys( $tabs ) ) ) {
				return $tabs;
			}

			$instructor = array( $instructor_endpoint => $tab );

			$course_endpoint = LP()->settings()->get( 'profile_endpoints.profile-courses' );

			if ( ! empty( $course_endpoint ) ) {
				$pos  = array_search( $course_endpoint, array_keys( $tabs ) ) + 1;
				$tabs = array_slice( $tabs, 0, $pos, true ) + $instructor + array_slice( $tabs, $pos,
						count( $tabs ) - 1, true );
			} else {
				$tabs = $tabs + $instructor;
			}

			return $tabs;
		}

		/**
		 * Get instructor tab content in profile page.
		 *
		 * @param $current
		 * @param $tab
		 * @param $user
		 */
		public function profile_instructor_tab_content( $current, $tab, $user ) {
			learn_press_get_template(
				'profile-tab.php',
				array(
					'user'    => $user,
					'current' => $current,
					'tab'     => $tab,
				),
				learn_press_template_path() . '/addons/co-instructors/',
				LP_ADDON_CO_INSTRUCTOR_PATH . '/templates/'
			);
		}

		/**
		 * Show list instructors in single course page.
		 */
		public function single_course_instructors() {
			$course = LP_Global::course();

			$course_id   = $course->get_id();
			$instructors = $this->get_instructors( $course_id );

			learn_press_get_template(
				'single-course-tab.php',
				array( 'instructors' => $instructors ),
				learn_press_template_path() . '/addons/co-instructors/',
				LP_ADDON_CO_INSTRUCTOR_TEMPLATE
			);
		}

		/**
		 * Get all course instructors.
		 *
		 * @param $course_id
		 *
		 * @return mixed
		 */
		public function get_instructors( $course_id ) {
			if ( $course_id ) {
				$course_id = learn_press_get_course_id();
			}

			if ( ! $course_id ) {
				return false;
			}

			$instructors = learn_press_co_instructor_get_instructors( $course_id );

			return $instructors;
		}

		/**
		 * Excerpt duplicate post meta.
		 *
		 * @param $excerpt
		 * @param $old_post_id
		 * @param $new_post_id
		 *
		 * @return array
		 */
		public function excerpt_duplicate_post_meta( $excerpt, $old_post_id, $new_post_id ) {
			if ( ! in_array( '_lp_co_teacher', $excerpt ) ) {
				$excerpt[] = '_lp_co_teacher';
			}

			return $excerpt;
		}
	}

	add_action( 'plugins_loaded', array( 'LP_Addon_Co_Instructor', 'instance' ) );
}
