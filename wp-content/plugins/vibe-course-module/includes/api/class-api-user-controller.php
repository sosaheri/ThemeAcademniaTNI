<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'BP_Course_Rest_Course_Controller' ) ) {
	
	class BP_Course_Rest_User_Controller extends BP_Course_Rest_Controller {

		
		/**
		 * Register the routes for the objects of the controller.
		 *
		 * @since 3.0.0
		 */
		public function register_routes() {



			//$this->token = '2tz745fwp6d7z1d50euboegms7pgvglbnn5biilw';
			

			$this->type = 'user';
			register_rest_route( $this->namespace, '/'. $this->type .'/', array(
				array(
					'methods'                   =>  WP_REST_Server::READABLE,
					'callback'                  =>  array( $this, 'get_user' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/', array(
				array(
					'methods'                   =>  WP_REST_Server::READABLE,
					'callback'                  =>  array( $this, 'get_user_profile' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/(?P<tab>\w+)?(&P<per_page>\d+)?(&P<paged>\d+)', array(
				'methods'                   =>  WP_REST_Server::READABLE,
				'callback'                  =>  array( $this, 'get_user_profile_tab' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_string( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)?', array(
				'methods'                   =>  WP_REST_Server::READABLE,
				'callback'                  =>  array( $this, 'get_course_status' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/item/(?P<id>\d+)?', array(
				'methods'                   =>  WP_REST_Server::READABLE,
				'callback'                  =>  array( $this, 'get_course_status_item' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );	

			
			register_rest_route( $this->namespace, '/'. $this->type .'/finishcourse', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'finish_course' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/updatecourse/progress', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'update_course_progress' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			
			register_rest_route( $this->namespace,'/'. $this->type .'/getreview/(?P<course>\d+)', array(
				'methods'                   =>  WP_REST_Server::READABLE,
				'callback'                  =>  array( $this, 'get_review' ),
			) );

			register_rest_route( $this->namespace, '/updatecourse/addreview', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_review' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/activity/add', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_activity' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/submitresult', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'add_user_result' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
			
			register_rest_route( $this->namespace,  '/'. $this->type .'/signin/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'signin_user' ),
				'permission_callback' 		=> array( $this, 'get_verify_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/register/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'register_user' ),
				'permission_callback' 		=> array( $this, 'get_verify_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/verify/', array(
				array(
					'methods'                   =>  WP_REST_Server::READABLE,
					'callback'                  =>  array( $this, 'verfify_user' ),
				),
			));

			register_rest_route( $this->namespace,  '/'. $this->type .'/activity/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_activity' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/subscribe/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_to_course' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );
			
			/* Quiz Functions */
			register_rest_route( $this->namespace,  '/'. $this->type .'/quiz/start', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'start_quiz' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/quiz/submit', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'submit_quiz' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/image/', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'submit_quiz' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/fields', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'set_field' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/chart/course', array(
				array(
					'methods'                   =>  WP_REST_Server::READABLE,
					'callback'                  =>  array( $this, 'get_course_chart' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/chart/quiz', array(
				array(
					'methods'                   =>  WP_REST_Server::READABLE,
					'callback'                  =>  array( $this, 'get_quiz_chart' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
		}

		public function get_user_permissions_check($request){
			
			//$headers = $request->get_headers();
			$headers = getallheaders();

			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->token = $token;
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id){
					return true;
				}
			}

			return false;
		}

		public function get_user($request){

			$token = $this->token;

			//$user = $this->get_user_from_token($token);
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			
			if(isset($request['full'])){
				$user_data = apply_filters( 'bp_course_api_get_user',$this->fetch_user($this->user_id), $request );
			}else{
				$user_data = apply_filters( 'bp_course_api_get_user', $this->user_id, $request );
			}
			

			return new WP_REST_Response( $user_data, 200 );
		}


		function get_user_from_token($token){

			global $wpdb;
			$user_id = $wpdb->get_var("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '$token'");

			if(is_numeric($user_id)){
				return $user_id;
			}

			return false;
			
		}


		function fetch_user($user_id){
			$user = array();
			$field = 'Location';
			if(function_exists('vibe_get_option')){$field = vibe_get_option('student_about');}
		
			$sub = bp_get_profile_field_data('field='.$field.'&user_id='.$user_id);

			$u = get_userdata($user_id);
			$user['id']	  = $user_id;
			$user['name'] = bp_core_get_user_displayname($user_id);
			$user['sub']  = ($sub?$sub:'');
			$user['email']= $u->user_email;
			$user['avatar'] = bp_core_fetch_avatar(array(
								'item_id' => $user_id,
								'object'  => 'user',
								'html'	  => false
							));

			return $user;
		}

		function get_user_profile($request){


			$tab = $request['tab'];	
			if(empty($tab)){
				$user = $this->get_user_profile_details();
			}else{
				$user = $this->get_user_profile_tab_value($tab,$request);	
			}
			
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$user_data = apply_filters( 'bp_course_api_get_user_profile_tab', $user, $request );

			return new WP_REST_Response( $user_data, 200 );
		}
		

		function get_user_profile_details(){
			global $wpdb;
			$user_id = $this->user_id;
			if(is_numeric($user_id)){
				$data = apply_filters('bp_course_api_get_user_profile_data',array(
							array(
								'key'=>'announcements',
								'label'=>_x('Announcements','api','vibe'),
								'type' => 'objects',
								'value'=>bp_course_get_course_announcements_for_user($user_id),
							),
							array(
								'key'=>'courses',
								'label'=>_x('Courses','api','vibe'),
								'type' => 'number',
								'value'=>bp_course_get_total_course_count_for_user($user_id),
							),
							array(
								'key'=>'quizzes',
								'label'=>_x('Quizzes','api','vibe'),
								'type' => 'number',
								'value'=>bp_course_get_total_quiz_count_for_user($user_id),
							),
							array(
								'key'=>'badges',
								'type' => 'objects',
								'label'=>_x('Badges','api','vibe'),
								'value'=>  bp_course_api_get_user_badges($user_id),
							),
							array(
								'key'=>'certificates',
								'type' => 'objects',
								'label'=>_x('Certificates','api','vibe'),
								'value'=>  bp_course_api_get_user_certificates($user_id),
							),
						)
					);
				$tabs = apply_filters('bp_course_api_get_user_profile_tabs',array(
						array(
							'key'=>'dashboard',
							'type'=> 'tab',
							'label'=>_x('Dashboard','api','vibe'),
							'value'=>'md-analytics',
						),
						array(
							'key'=>'profile',
							'type'=> 'tab',
							'label'=>_x('Profile','api','vibe'),
							'value'=>'md-contact',
						),
						array(
							'key'=>'courses',
							'type'=> 'tab',
							'label'=>_x('My Courses','api','vibe'),
							'value'=>'md-book',
						),
						array(
							'key'=>'results',
							'type'=> 'tab',
							'label'=>_x('Results','api','vibe'),
							'value'=>'md-bookmarks',
						),
						/*array(
							'key'=>'gradebook',
							'type'=> 'tab',
							'label'=>_x('Gradebook','api','vibe'),
							'value'=>'md-checkmark-circle-outline',
						),
						array(
							'key'=>'notifications',
							'type'=> 'tab',
							'label'=>_x('Notifications','api','vibe'),
							'value'=>'md-alert',
						),*/
						array(
							'key'=>'activity',
							'type'=> 'tab',
							'label'=>_x('Activity','api','vibe'),
							'value'=>'md-alarm',
						),
						array(
							'key'=>'settings',
							'type'=> 'tab',
							'label'=>_x('Settings','api','vibe'),
							'value'=>'md-settings',
						),
				));
			

				return array('data'=>$data,'tabs'=>$tabs);
			}
			return false;
		}


		function get_user_profile_tab_value($tab,$request){
			global $wpdb;
			$data = array();
			$user_id = $this->user_id;
			
			$per_view = (empty($request['per_page'])?5:$request['per_page']); 
			$paged = (empty($request['paged'])?1:$request['paged']);

			if(is_numeric($user_id)){
				$data = apply_filters('bp_course_api_get_user_profile_tab_'.$tab,array(),$user_id);
				if(empty($data)){
					
					switch($tab){
						case 'profile':
							$data = $this->generate_profile_data($user_id);
						break;
						case 'courses':
							$data = $this->get_my_courses($user_id,$per_view,$paged);
						break;
						case 'results':
							$data = $this->get_my_results($user_id,$per_view,$paged);
						break;
						case 'result':
							$data = $this->get_my_result($user_id,$request['result'],$request['activity_id']);
						break;
						case 'gradebook':
							$data = $this->get_my_grades($user_id,$per_view,$paged);
						break;
						case 'notifications':
							$data = $this->get_my_notifications($user_id,$per_view,$paged);
						break;
						case 'activity':
							$data = $this->get_my_activity($user_id,$per_view,$paged);
						break;
						case 'settings':
							$data = $this->get_my_settings($user_id);
						break;
					}	
				}
				
				
			}

			return $data;
		}

		function wdw_bp_get_field_options( $field_id ){
			global $bp, $wpdb;
			return $wpdb->get_col( $wpdb->prepare( "SELECT name FROM {$bp->profile->table_name_fields} WHERE parent_id=%d AND type='option'", $field_id ) );
		}

		function generate_profile_data($user_id){
			$data = array();

			if(function_exists('bp_xprofile_get_groups')){
				$groups = bp_xprofile_get_groups( array(
					'fetch_fields' => true
				) );

				if(!empty($groups)){
					foreach($groups as $group){
						$field_group = array();
						$field_group['id'] = $group->id;
						$field_group['name'] = $group->name;
						$field_group['description'] = $group->description;
						if ( !empty( $group->fields ) ) {

							foreach($group->fields as $field){
								if($field->type == 'url'){
									$field_value = bp_get_profile_field_data(array('field'=>$field->id,'user_id'=>$user_id));
									$field_value =	wp_extract_urls($field_value);
									if(empty($field_value)){
										$field_value = '';
									}else{
										$field_value = $field_value[0];
									}
								}else{
									$field_value = bp_get_profile_field_data(array('field'=>$field->id,'user_id'=>$user_id));
								}
								$f = array(
									'id' => $field->id,
									'type' => $field->type,
									'name' => $field->name,
									'value' => $field_value,
								);
								$options_fields = apply_filters('wplms_options_fields_api',array('checkbox','selectbox','multiselectbox','radio'));
								if(!empty($field->type) && in_array($field->type,$options_fields)){
									$options = $this->wdw_bp_get_field_options($field->id);
									if(!empty($options)){
										$f['options']=$options;
									}
								}
								if($field->field_order){
									$field_group['fields'][$field->field_order] = $f;
								}else{
									$field_group['fields'][] = $f;
								}
							}
						}
						if($group->group_order){
							$data[$group->group_order] = $field_group;
						}else{
							$data[] = $field_group;	
						}
						
					}
				}
			}
			
			return $data;
		}

		function get_my_courses($user_id,$per_view,$paged){
			// Prepare the element data
			$posts_data = array();
			$courses = bp_course_get_user_courses($user_id,4);
			$defaults = array(
				'post_type'  	=> 'course',
				'post_status'	=> 'publish',
				'orderby' 		=> 'alphabetical',
				'order'			=> 'ASC',
				'per_page'		=>	$per_view,
				'paged'			=>	$paged,
				'post__not_in'  => $courses,
				'user'          => $user_id,
			);


			$args = array();
			//Enter REQUEST IN ARGS FOR FILTERS
			
			$args = wp_parse_args($args,$defaults);

			if ( bp_course_has_items( $args ) ):
				while ( bp_course_has_items() ) : bp_course_the_item();
					global $post;
					$course = $post;
					$posts[]= array(
						'id'                    => $course->ID,
						'name'                  => $course->post_title,
						'date_created'          => strtotime( $course->post_date_gmt ),
						'user_progress'         => $this->get_user_progress($course,$user_id),
						'user_status'           => $this->get_user_status($course,$user_id),
						'start_date'            => $this->get_course_start_date($course,$user_id),
						'featured_image'		=> $this->get_course_featured_image($course),	
						'instructor'            => $this->get_course_instructor($course->post_author),	
						'menu_order'            => $course->menu_order,	
					);
				endwhile;	
			endif;
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$posts_data = apply_filters( 'bp_course_api_get_courses', $posts, $request );

			return $posts_data;
		}
	

		function get_course_start_date($course,$user_id){
			$start_date = bp_course_get_start_date($course->ID,$user_id);
			return strtotime($start_date);
		}

		function get_user_progress($course,$user_id){
			$p = bp_course_get_user_progress($user_id,$course->ID);
			return empty($p)?0:$p;
		}

		function get_user_status($course,$user_id){
			return bp_course_get_user_course_status($user_id,$course->ID);
		}

		function get_course_featured_image($course){

			if(!is_numeric($course)){
				$course = $course->ID;
			}

			$post_thumbnail_id = get_post_thumbnail_id( $course );
			if(!empty($post_thumbnail_id)){
				$image = wp_get_attachment_image_src($post_thumbnail_id,'medium');
				$image = $image[0];
			}

			if(empty($image)){
	            $image = vibe_get_option('default_course_avatar');
	            if(empty($image)){
	                $image = VIBE_URL.'/assets/images/avatar.jpg';
	            }
	        }

	        return $image;
		}

		function get_course_instructor($instructor_id){
			$field = 'Speciality';
			if(function_exists('vibe_get_option'))
			$field = vibe_get_option('instructor_field');

			return array(
				'id'     => $instructor_id, 
				'name'   => bp_core_get_user_displayname($instructor_id),
				'avatar' => bp_course_get_instructor_avatar_url($instructor_id),
				'sub'    => (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$instructor_id):''),
			);
		}


		function get_my_results($user_id,$per_view,$paged){
			$data = array();

			global $wpdb,$bp;
			if(function_exists('bp_is_active') && bp_is_active('activity')){
			    $activity_ids = $wpdb->get_results($wpdb->prepare( "
			    							SELECT a.secondary_item_id,MAX(a.id) AS id
			    							FROM {$bp->activity->table_name} AS a
			    							LEFT JOIN {$bp->activity->table_name_meta}  AS am
			    							ON a.id = am.activity_id
			    							WHERE a.type = 'quiz_evaluated'
											AND a.user_id = %d
											AND am.meta_value IS NOT NULL
											GROUP BY a.secondary_item_id
											ORDER BY a.date_recorded DESC
											LIMIT %d,%d
										" ,$user_id,(($paged-1)*$per_view),$per_view));
		
			    if(!empty($activity_ids)){
			    	foreach($activity_ids as $activity_id){
			    		$questions = bp_course_get_quiz_questions($activity_id->secondary_item_id,$user_id);
			    		$data[] = array(
			    			'activity_id' =>$activity_id->id,
			    			'quiz'=> $activity_id->secondary_item_id,
			    			'title'=> get_the_title($activity_id->secondary_item_id),
			    			'marks'=> intval(get_post_meta($activity_id->secondary_item_id,$user_id,true)),
			    			'max' => array_sum($questions['marks'])
		    			);	
			    	}
			    }
			}
			return $data;
		}

		function get_my_result($user_id,$quiz_id,$activity_id){
			$data = array();
			$qdata=bp_course_get_quiz_results_meta($quiz_id,$user_id,$activity_id );
			$qdata = unserialize($qdata);
			if(is_array($qdata)){
				foreach($qdata as $key=>$value){
					if(is_numeric($key)){
						$data[] = array(
							'id'=>"answer",
							'value'=>$value
						);
					}
					
				}	
			}
				
			return $data;
		}

		function get_my_grades($user_id,$per_view,$paged){
			$data = array();
			$courses = bp_course_get_user_courses($user_id,4);

			if(!empty($courses)){
				foreach($courses as $course_id){
					$data[] = array(
						'id'                    => $course_id,
						'name'                  => get_the_title($course_id),
						'featured_image'		=> $this->get_course_featured_image($course_id),
						'score'					=> get_post_meta($course_id,$user_id,true),	
						'retakes'				=> bp_course_get_course_retakes($course_id,$user_id),
						'finish_access'			=> (vibe_get_option('finished_course_access')?vibe_get_option('finished_course_access'):0),
					);
				}
			}

			return $data;
		}


		function get_my_notifications($user_id,$per_view,$paged){
			$data = array();
			if(bp_has_notifications(array('user_id'=>$user_id,'page'=>$paged,'per_page'=>$per_view))){
				while ( bp_the_notifications() ) {
					bp_the_notification();	
					$data[] = array(
						'component'=>bp_get_the_notification_component_name(),
						'time'	=> strtotime(bp_get_the_notification_date_notified()),
						'action' => bp_get_the_notification_component_action(),
						'content'=> wp_strip_all_tags(bp_get_the_notification_description())
					);
				} 
			}

			return $data;
		}

		function get_my_activity($user_id,$per_view,$paged){
			$data = array();
			if ( bp_has_activities(array('user_id'=>$user_id,'page'=>$paged,'per_page'=>$per_view)) ){
				while ( bp_activities() ) {
					bp_the_activity();	
					$data[] = array(
						'date'	=> strtotime(bp_get_activity_feed_item_date()),
						'content'=> wp_strip_all_tags(bp_get_activity_content_body())
					);
				} 
			}

			return $data;
		}

		/**
		 * My Settings for User
		 *
		 * @since 3.0.0
		 */
		function get_my_settings($user_id){
			$data = array();
		}


		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_user_course_status_permissions_check($request){

			//$this->user_id = 1; //return true;
			$this->get_user_id($request);
			
			$user_id = $this->user_id;
			$course_id = $request['course'];	

			if(function_exists('bp_course_is_member') && bp_course_is_member($course_id,$user_id))
				return true;

			return false;
		}

		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_course_status($request){

			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}

			$user_id = $this->user_id;
			$course_id = $request['course'];	

			$course_status = bp_course_get_user_course_status($user_id,$course_id);

			if($course_status == 1){
				bp_course_update_user_course_status($user_id,$course_id,$course_status);
			}

			$curriculum = bp_course_get_curriculum($course_id);
			if(empty($curriculum))
				return false;

			$curriculum_arr = array();
			$first_unit_id = '';

			$section_duration = 0;
			foreach($curriculum as $key => $item){
				if(is_numeric($item)){
					if(bp_course_get_post_type($item) == 'unit'){
						if(empty($first_unit_id)){$first_unit_id = $item;}

						$d = bp_course_get_unit_duration($item);
						$section_duration += $d;

						$complete = 0;
						
						if(bp_course_check_unit_complete($item,$user_id,$course_id)){
							$complete = 1;
						}
						$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_unit',array(
							'key'		=> $key,
							'id'		=> $item,
							'type'		=> 'unit', 
							'title'		=> get_the_title($item),
							'duration'	=> $d,
							'content'   => '',
							'status'    => $complete,
							'meta'		=> array()
						));
					}else if(bp_course_get_post_type($item) == 'quiz'){
						$d = bp_course_get_quiz_duration($item);
						$section_duration += $d;

						$complete = 0;
						if(bp_course_check_unit_complete($item,$user_id,$course_id)){
							$complete = 1;
						}
						$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_quiz',array(
							'key'		=> $key,
							'id'		=> $item,
							'type'		=> 'quiz',
							'title'		=> get_the_title($item),
							'duration'	=> $d,
							'content'   => '',
							'status'    => $complete,
							'meta'		=> array(),
						));
					}

				}else{
					$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_section',array(
						'key'		=> $key,
						'id'		=> 0,
						'type'		=> 'section',
						'title'		=> $item,
						'duration'	=> $section_duration,
						'content'   => '',
						'meta'		=> array()
					));
					$section_duration = 0;
				}
			}
			
			$unit_id = wplms_get_course_unfinished_unit($course_id);
			if(empty($unit_id)){
				$unit_id = $first_unit_id;
			}
			if(get_post_type($unit_id) == 'unit'){
				//mark the opening unit as complete
				bp_course_update_user_unit_completion_time($user_id,$unit_id,$course_id,time());	
			}
			
			/*$current_key = 0;
			foreach($curriculum_arr as $key => $item){
				if($item['id'] == $unit_id){
					$current_key = $key;
					//Fetch the API
					//$content = get_post_field('post_content',$unit_id);
					//$content = apply_filters('the_content',$content);
					//
					//$curriculum_arr[$key]['content'] = $content;
					//$curriculum_arr[$key]['meta'] = array('access'=>1);
				}
			}*/
			
			//Get content
			
			$return = array('current_unit_key'=>0,'courseitems'=>$curriculum_arr) ;
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$data = apply_filters( 'bp_course_api_get_user_course_status',$return, $request );

			return new WP_REST_Response( $data, 200 );
		}
		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_course_status_item($request){
			
			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}

			$user_id = $this->user_id;
			$course_id = $request['course'];	
			$item_id = $request['id'];	
			
			if(!bp_course_is_member($course_id,$user_id))
				return;

			$course_status=bp_course_get_user_course_status($user_id,$course_id);
			$return = array();
			

			$item = get_post($item_id);
			$meta=array('access'=>0);
			if($item->post_type == 'unit'){
				
				
				$fetch_item = true;
				$drip_check = bp_course_get_drip_status($course_id,$user_id,$item_id);
				if($drip_check['status']){
					$return['content'] = $drip_check['message'];
					$meta['access'] = 0; // do not cache in app
					$fetch_item = false;
				}
				

				if($fetch_item){

					$unit_type = get_post_meta($item_id,'vibe_type',true);
					if($unit_type == 'play' && ( false !== strpos( $item->post_content, '[' ))){

	                	preg_match_all( '/' . get_shortcode_regex(array('video','audio')) . '/', $item->post_content, $matches, PREG_SET_ORDER );
        				$video = array();$audio = array();$iframes =array();
        				$meta['iframes'] = array();
        				if ( !empty( $matches ) ){
        					
        					foreach ( $matches as $shortcode ) {
		                        if ( in_array($shortcode[2],array('audio','video'))) {
		                        	$paths = explode('"', $shortcode[3]);
		                        	if(is_array($paths)){
		                        		foreach($paths as $path){
		                        			if(strpos($path, ".mp4")){
		                        				$video[] = $path;
		                        			}
		                        			if(strpos($path, ".mp3")){
		                        				$audio[] = $path;
		                        			}
		                        		}
		                        	}
		                        }
        					}	
        					
	    					$item->post_content  = str_replace('[/video]', '', $item->post_content );
	    					$item->post_content  = str_replace('[/audio]', '', $item->post_content );
							
							if(!empty($audio)){$meta['audio']=$audio;}
    					}
    				

    					//for iframes
    					preg_match_all( "/\[iframe\](.*)\[\/iframe\]/", $item->post_content, $matches2 ,PREG_SET_ORDER);

    					if ( !empty( $matches2 ) ){
        					foreach ( $matches2 as $shortcode ) {
        						//logic to match iframs
        						$iframes[] = $shortcode[1];
		                        
        					}	
    					}
    					
    					//for iframevideo
    					preg_match_all( "/\[iframevideo\](.*)\[\/iframevideo\]/", $item->post_content, $matches3 ,PREG_SET_ORDER);
    					if ( !empty( $matches3 ) ){
        					
        					foreach ( $matches3 as $shortcode2 ) {
        						preg_match('/src="([^"]+)"/', $shortcode2[1], $matchiframeurl);
        						if(!empty($matchiframeurl)){
        							$iframes[] = $matchiframeurl[1];
        						}
								
		                       
        					}	
    					}

    					//for wplms vimeo
    					if(false !== strpos($item->post_content,'wplms_vimeo')){
	    					preg_match_all( '/' . get_shortcode_regex(array('wplms_vimeo')) . '/', $item->post_content, $matches4, PREG_SET_ORDER );
	    					if ( !empty( $matches4 ) ){
	        					foreach ( $matches4 as $shortcode3 ) {
	        						preg_match('/[0-9]*[0-9]/',$shortcode3[3],$file_numeric);
	        						if(!empty($file_numeric[0])){
	        							$iframes[] = 'https://player.vimeo.com/video/'.$file_numeric[0];
	        						}
	        					}	
	    					}
    					}

    					//for wplms s3
    					if(false !== strpos($item->post_content,'wplms_s3')){
    						
	    					preg_match_all( '/' . get_shortcode_regex(array('wplms_s3')) . '/', $item->post_content, $matches5, PREG_SET_ORDER );
	    					if ( !empty( $matches5 ) ){
	        					foreach ( $matches5 as $shortcode4 ) {
	        						preg_match('/link=[\'|"](.*?)[\'|"]/',$shortcode4[3],$link_s3);

	        						preg_match('/duration=[\'|"](.*?)[\'|"]/',$shortcode4[3],$duration);

	        						preg_match('/parameter=[\'|"](.*?)[\'|"]/',$shortcode4[3],$parameter);

	        						if(!empty($link_s3[1])){
	        							if(class_exists('Wplms_S3_Init')){
	        								$s3 =Wplms_S3_Init::init();
	        								$file_mime = $s3->getMimeType($link_s3[1]);
	        								$video_mimes = apply_filters('api_allowed_video_mime_types',array(
	        									'video/mp4','video/ogg','video/webm','video/flv',
	        									));
	        								if(in_array($file_mime,$video_mimes)){
	        									$duration =floatval($duration[1] );$parameter= floatval($parameter[1]);
	        									$url = $s3->get_s3_url($link_s3[1],$duration*$parameter);
		        								if(!empty($url)){
		        									if(empty($video)){
		        										$video = array($url);
		        									}else{
		        										$video[] = $url;
		        									}
		        								}
	        								}
	        								
	        							}
	        						}
	        					}	
	    					}
    					}
    					
    					//for h5p
    					if(false !== strpos($item->post_content,'wplms_h5p')){
							preg_match_all( '/' . get_shortcode_regex(array('wplms_h5p')) . '/', $item->post_content, $matches6, PREG_SET_ORDER );
	    					if ( !empty( $matches6 ) ){
	        					foreach ( $matches6 as $shortcode4 ) {
	        						preg_match('/id=[\'|"](.*?)[\'|"]/',$shortcode4[3],$id);

	        						if(!empty($id[1])){
	        							$url = admin_url('admin-ajax.php?action=h5p_embed&id=' .$id[1]) ;
	        							if(!empty($url)){
        									if(empty($iframes)){
        										$iframes = array($url);
        									}else{
        										$iframes[] = $url;
        									}
        								}
	        						}
	        					}	
	    					}
						}

    					if(!empty($video)){$meta['video']=$video;}
    					if(!empty($iframes)){$meta['iframes']=$iframes;}
    					$regex = get_shortcode_regex(array('audio','video','iframevideo','iframe','wplms_s3','wplms_vimeo','wplms_h5p'));
        				$item->post_content = preg_replace("/$regex/s", " ", $item->post_content);
    					$item->post_content = preg_replace ( '/\[[video|audio](.*?)\]/s' , '' , $item->post_content );
						$return['content'] = apply_filters('the_content',$item->post_content);
						$meta['access'] = 1; // do not cache in app
						


					}else{
						$return['content'] = apply_filters('the_content',$item->post_content);
						$meta['access'] = 1; // do not cache in app
					}
					if($course_status < 3 ){
						$done_flag=bp_course_get_user_unit_completion_time($user_id,$item_id,$course_id);
						if(empty($done_flag)){

							$args = array(
								'action' => __('Student finished unit ','vibe'),
							    'content' => sprintf(__('Student %s finished the unit %s in course %s','vibe'),bp_core_get_userlink($user_id),get_the_title($item_id),get_the_title($course_id)),
							    'type' => 'unit_complete',
							    'user_id' => $user_id,
							    'primary_link' => get_permalink($item_id),
							    'item_id' => $course_id,
							    'secondary_item_id' => $item_id
							);
							bp_course_record_activity($args);
							bp_course_update_user_unit_completion_time($user_id,$item_id,$course_id,time());
						}
						
						$progress = bp_course_get_user_progress($user_id,$course_id);
						$course_curriculum=bp_course_get_curriculum_units($course_id);
						$progress = $progress + round((100/(count($course_curriculum))),2);
						if($progress > 100){$progress = 100;}
						bp_course_update_user_progress($user_id,$course_id,$progress);
						$meta['progress']=$progress;
					}
					$return['meta'] = apply_filters('wplms_api_unit_meta',$meta);
				}
			}
			
			if($item->post_type == 'quiz'){

				//Get all questions.
				$status = bp_course_get_user_quiz_status($user_id,$item_id);

				if($status){
					$t = get_user_meta($user_id,$item_id,true);
					$return['remaining']=$t - time();
				}

				$quiz_access_flag=apply_filters('bp_course_api_check_quiz_lock',true,$item_id,$user_id,'api');

				if($quiz_access_flag){

					$return['content'] = apply_filters('the_content',$item->post_content);
					$all_questions = bp_course_get_quiz_questions($item_id,$user_id);
					if(empty($all_questions)){
						do_action('wplms_before_quiz_begining',$item_id,$user_id);
						$all_questions = bp_course_get_quiz_questions($item_id,$user_id);
					}

					$questions = $question = array();


					$progress = $user_marks = 0;
					if(!empty($all_questions)){

						$max = array_sum($all_questions['marks']);
						$auto = get_post_meta($item_id,'vibe_quiz_auto_evaluate',true);
						

						if($status < 3){
							foreach($all_questions['ques'] as $k=>$question_id){

								$question = bp_course_get_question_details($question_id,1);
								$question['marks'] = intval($all_questions['marks'][$k]);
								$question['user_marks'] = 0;
								$question['status'] = 0;
								$question['marked'] = bp_course_get_question_marked_answer($item_id,$question,$user_id);
								$question['auto'] = (($auto == 'S')?1:0);
								if(!empty($question['marked'])){
									$question['user_marks'] = bp_course_get_user_question_marks($item_id,$question_id,$user_id);
									$user_marks += intval($question['user_marks']);
									$progress++;
									$question['status'] = 1;
								}
								
								array_push($questions, $question);
							}
							$progress = round((100*$progress/count($all_questions['ques'])),2);	
						}else{
							$progress = 100;
							ob_start();
							bp_course_quiz_results($item_id,$user_id);
							$return['content'] .= ob_get_clean();
							$user_marks = get_post_meta($item_id,$user_id,true);
						}
						
					}
					
					$retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($item_id,'vibe_quiz_retakes',true),$quiz_id,$course,$user_id);
					
					if(function_exists('bp_is_active') && bp_is_active('activity')){
						global $bp,$wpdb;
						$table_name=$bp->activity->table_name;
						$retake_count = $wpdb->get_var($wpdb->prepare( "
										SELECT count(activity.content) FROM {$bp->activity->table_name} AS activity
										WHERE 	activity.component 	= 'course'
										AND 	activity.type 	= 'retake_quiz'
										AND 	user_id = %d
										AND 	secondary_item_id = %d
										ORDER BY date_recorded DESC
									" ,$user_id,$item_id));

						$retakes = $retakes - intval($retake_count);
					}
					
					$retake_count = intval($retake_count);
					$return['meta'] = array(
						'access' => 1,
						'status' => intval($status),
						'progress' => $progress,
						'marks'=> $user_marks,
						'max' => $max,
						'questions' => $questions,
						'auto'=>(($auto == 'S')?1:0),
						'retakes' => $retakes,
						'completion_message'=>  do_shortcode(get_post_meta($item_id,'vibe_quiz_message',true)),
					);
				}else{
					$return['content'] = __x('Quiz already in progress, contact site, please retry after sometime.','quiz lock flag check for App and Site','vibe');
					$return['meta'] = array(
						'access' => 0
					);
				}
			}
			
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$data = apply_filters( 'bp_course_api_get_user_course_status_item',$return, $request );

			return new WP_REST_Response( $data, 200 );
		}



		/**
		 * Record Course Progress User
		 *
		 * @since 3.0.0
		 */
		function update_course_progress($request){
			
			$post = json_decode(file_get_contents('php://input'));
			
			$data = array();
			bp_course_update_user_progress($this->user_id,$post->course,$post->progress);

			return new WP_REST_Response( $data, 200 );;
		}


		/**
		 * GET COURSE REVIEW BY USER
		 *
		 * @since 3.0.0
		 */
		function get_review($request){

			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}
			$course = $request['course'];
			global $wpdb;
			$comment_id = $wpdb->get_var("SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = $course AND user_id = $this->user_id AND comment_approved = 1");
			
			$data = array();
			if(!empty($comment_id)){
				$comment = get_comment($comment_id);
				$data['comment_ID']= $comment->comment_ID;
				$data['review']= $comment->comment_content;
				$data['title']= get_comment_meta($comment->comment_ID,'review_title',true);
				$data['rating']= get_comment_meta($comment->comment_ID,'review_rating',true);
			}

			

			return new WP_REST_Response( $data, 200 );;
		}

		/**
		 * Record Course Review BY User
		 *
		 * @since 3.0.0
		 */
		function get_user_course_permissions_check($request){
			//Check if user part of course.

			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}



			$post = json_decode(file_get_contents('php://input'));

			if(!is_numeric($post->course_id))
				return false;


			

			if(bp_course_is_member($post->course_id,$this->user_id))
				return true;


			return false;
		}

		function add_review($request){

			$post = json_decode(file_get_contents('php://input'));
			$review = wp_filter_nohtml_kses(stripslashes($post->review));	
			
			$data = array(
    				'comment_post_ID' => $post->course_id,
    				'comment_content' => $review,
    				'user_id' => $this->user_id,
    				'comment_approved' => 1,
				);
			
			if(strlen($review) < 20){
				$status = 0;
				$message = _x('Please add more words to the review message !','API message failure to add review','vibe');
			}else{
				global $wpdb;
				$comment_id = $wpdb->get_var("SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = $post->course_id AND user_id = $this->user_id AND comment_approved = 1");

				if(is_numeric($comment_id)){
					$data['comment_ID']=$comment_id;
					wp_update_comment($data);
				}else{
					$comment_id = wp_insert_comment($data);	
				}
				
				if($comment_id){
					$status = 1;
					$title = wp_filter_nohtml_kses($post->title);
					update_comment_meta( $comment_id, 'review_title', $title );
          			$rating = wp_filter_nohtml_kses($post->rating);
          			update_comment_meta( $comment_id, 'review_rating', $rating );
					$message = _x('Review successfully added !','API message failure to add review','vibe');
				}else{
					$status = 0;
					$message = _x('Failed to add review','API message failure to add review','vibe');
				}
			}

			
			

			$data = array('status'=>$status,'message'=>$message);

			return 	new WP_REST_Response( $data, 200 );
		}

		/*
		Add Quiz result
		 */
		function add_user_result(){
			$post = json_decode(file_get_contents('php://input'));
			
			$max=$marks=0;
			$results = array();
			if(is_array($post->results)){
				foreach($post->results as $res){
					$max += $res->marks;		
					$marks += $res->user_marks;
					$result = array(
						'content'=>$res->content,
						'type'=>$res->type,
						'marked_answer'=>$res->marked,
						'correct_answer'=>$res->correct,
						'explaination'=>$res->marks,
						'max_marks'=>$res->marks,
						'marks'=>$res->user_marks
						);
					$results[] =$result; 
				}
			}
			 
			$activity_id = bp_course_activity::evaluate_quiz($post->quiz_id,$marks,$this->user_id,$max);
			
			bp_course_generate_user_result($post->quiz_id,$this->user_id,$results,$activity_id);
			
			update_post_meta( $post->quiz_id,$this->user_id,$marks);
			
			bp_course_update_user_quiz_status($this->user_id,$post->quiz_id,4);
		}

		/*
		VERIFY USER
		 */
		
		function get_verify_permissions_check($request){

			$post =  json_decode(file_get_contents('php://input'));
			
			$state = bp_course_get_setting( 'api_security_state', 'api','string' );;

			if($state == $post->state){
				
				if($this->verify_client($post->client_id)){
						return true;	
				}else{
					return false;
				}
				
			}

			return false;
		}
		/*
		USER LOGIN
		 */
		function signin_user($request){


			$post = json_decode(file_get_contents('php://input'));
			
			$data = array();
			$user_id = username_exists($post->username);
			if(!$user_id){
				$user_id = email_exists($post->username);
				if(!$user_id){
					$data['status'] = false;
					$data['message'] = _x('Invalid login username/email','incorrect credentials','vibe');
				}
			}

			if($user_id){
				$this->user_id = $user_id;

				if(isset($post->fbid)){
					//validate is user meta with fb login exists.
					$data['status'] = true;
					$data['token'] = $this->generate_token($this->user_id,$post->client_id);
					$current_user = $this->fetch_user($this->user_id);
					$data['user'] = apply_filters( 'bp_course_api_get_user', $current_user, $request );

				}else{
					$creds = array('user_login'=>$post->username,'user_password'=>$post->password);

					$user = wp_signon( $creds, false );

					if ( is_wp_error($user) ){
						$data['status'] = false;
						$data['message']=$user->get_error_message();
					}else{
						$data['status'] = true;
						$data['token'] = $this->generate_token($this->user_id,$post->client_id);
						$current_user = $this->fetch_user($this->user_id);
						$data['user'] = apply_filters( 'bp_course_api_get_user', $current_user, $request );
					}
				}
				
			}

			return new WP_REST_Response( $data, 200 );
		}
		/*
		USER REGISTRATION
		 */
		function register_user($request){
			$post = json_decode(file_get_contents('php://input'));
			
			$enable = bp_course_get_setting( 'api_registrations', 'api','boolean' );
			if(empty($enable )){
				$user_register_flag = false;
				$message = _x('Registrations disabled in API','registration disabled in api','vibe');
			}else{

				$user_register_flag = false;

				if(isset($post->email) && isset($post->username) && (isset($post->password) || isset($post->fbid)) ){
					if(!email_exists($post->email) && !username_exists($post->username)){
						$user_register_flag = true;
						if(isset($post->fbid)){
							$post->password = wp_generate_password(8, false);
						}

						$user_id = wp_insert_user(array(
							'user_login'=>$post->username,
							'user_email'=>$post->email,
							'user_pass'=>$post->password
						));
						if(isset($post->fbid)){
							update_user_meta($user_id,'facebook_id',$post->fbid);
						}
						$user = $this->fetch_user($user_id);
						$message = _x('Username successfully registered','error message on api registration','vibe');
					}else{
						$message = _x('Username/Email already registered','error message on api registration','vibe');
					}
				}
			}

			if($user_register_flag){
				
				$token = $this->generate_token($user_id,$post->client_id);

				$data = array(
					'status'=>true,
					'message'=>_x('Registration complete !',' message on api registration','vibe'),
					'user'=>$user,
					'token'=>$token,
					);
			}else{
				$data = array(
					'status'=>false,
					'message'=>$message,
				);
			}
			return 	new WP_REST_Response( $data, 200 );
		}
		/*
		Verify user for registrtion
		 */
		function verfify_user($request){

			if(!empty($request['email'])){
				if(email_exists($request['email'])){
					$data = array('status'=>true, 'message'=>_x('Email exists !','app verification','vibe'));
				}else{
					$data = array('status'=>false);
				}
			}

			if(!empty($request['username'])){
				if(username_exists($request['username'])){
					$data = array('status'=>true, 'message'=>_x('Username exists !','app verification','vibe'));
				}else{
					$data = array('status'=>false);
				}
			}

			return 	new WP_REST_Response( $data, 200 );
		}
		/*
		GET USER FROM TOKEN
		 */
		function get_user_id($request){

			if(isset($this->user_id))
				return $this->user_id;

			$headers = getallheaders();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->token = $token;
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id)
					return $this->user_id;
			}
			
			return false;
		}

		function generate_token($user_id,$client_id){

			$access_token = wp_generate_password(40);
			do_action( 'wplms_auth_set_access_token', array(
				'access_token' => $access_token,
				'client_id'    => $client_id,
				'user_id'      => $user_id
			) );

			$expires = time()+86400*7;
			$expires = date( 'Y-m-d H:i:s', $expires );
	
			$tokens = get_user_meta($user_id,'access_tokens',true);
			if(empty($tokens)){$tokens = array();}else if(in_array($access_token,$tokens)){$k = array_search($access_token, $tokens);unset($tokens[$k]);delete_user_meta($user_id,$access_token);
			}
			
			$tokens[] = $access_token;
			update_user_meta($user_id,'access_tokens',$tokens);

			$token = array(
				'access_token'=> $access_token,
				'client_id' => $client_id,
				'user_id'	=>	$user_id,
				'expires'	=> $expires,
				'scope'		=> $scope,
				);
			
			update_user_meta($user_id,$access_token,$token);

			return $token;
		}

		function finish_course(){
			$post = json_decode(file_get_contents('php://input'));
			$message = bp_get_course_check_course_complete(array('id'=>$post->course_id,'user_id'=>$this->user_id));

			$data = array('status'=>true, 'message'=>$message);
			return 	new WP_REST_Response( $data, 200 );
		}


		function add_activity($request){
			$post = json_decode(file_get_contents('php://input'));
			print_r($post);
		}

		/*
		APP & Client verification
		 */
		function get_apps(){
			if(empty($this->apps)){
				$this->apps = get_option('wplms_apps');
			}
		}

		function verify_client($client_id){
			$this->get_apps();
			
			if(empty($this->apps))
				return false;

			foreach($this->apps as $app){
				if($app['app_id'] == $client_id){
					return true;
				}
			}
		}

		function add_to_course(){
			$post = json_decode(file_get_contents('php://input'));
			if(is_numeric($post->course_id)){
				if(get_post_type($post->course_id) == 'course'){
					bp_course_add_user_to_course($this->user_id,$post->course_id);
					$data = array('status'=>true, 'message'=>_x('Successfully  subscribed to course!','course subscribe via app','vibe'));		
				}
			}else{
				$data = array('status'=>false, 'message'=>_x('Failed to subscribe to course','course subscribe via app','vibe'));
			}
			
			return 	new WP_REST_Response( $data, 200 );
		}

		/*
		Chart functions
		 */
		
		function get_course_chart(){

			global $wpdb;
			$marks=$wpdb->get_results(sprintf("
              SELECT posts.post_title as title,rel.meta_value as val
                FROM {$wpdb->posts} AS posts
                LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
                WHERE   posts.post_type   = 'course'
                AND   posts.post_status   = 'publish'
                AND   rel.meta_key   = %d
                 AND   rel.meta_value >= 2
            ",$this->user_id));

			$data = array('labels'=>array(),'data'=>array());
			if(!empty($marks)){
				foreach($marks as $mark){
					$data['labels'][] = $mark->title;
					$data['data'][] = intval($mark->val);
				}
			}

			return new WP_REST_Response( $data, 200 );
		}
		

		function get_quiz_chart(){

			global $wpdb;
			$marks=$wpdb->get_results(sprintf("
	              SELECT posts.post_title as title, rel.meta_value as val
	                FROM {$wpdb->posts} AS posts
	                LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
	                WHERE   posts.post_type   = 'quiz'
	                AND   posts.post_status   = 'publish'
	                AND   rel.meta_key   = %d
	                AND   rel.meta_value >= 0
	            ",$this->user_id));

			$data = array('labels'=>array(),'data'=>array());
			if(!empty($marks)){
				foreach($marks as $mark){
					$data['labels'][] = $mark->title;
					$data['data'][] = intval($mark->val);
				}
			}

			return new WP_REST_Response( $data, 200 );
		}
	

		/* Quiz Functions */
		function start_quiz(){
			$post = json_decode(file_get_contents('php://input'));
			if(is_numeric($post->quiz_id)){
				bp_course_update_user_quiz_status($this->user_id,$post->quiz_id,2);
			}
		}

		function submit_quiz(){
			$post = json_decode(file_get_contents('php://input'));
			print_r($post->quiz);
		}

		function set_field($post){
		$post = json_decode(file_get_contents('php://input'));
			if(function_exists('xprofile_set_field_data')){
				$options_fields = apply_filters('wplms_options_fields_api_set_field',array('checkbox','multiselectbox'));

				if(is_numeric($post->field->id)){
					if(in_array($post->field->type, $options_fields)){
						$post->field->value=explode(',',$post->field->value);
						$value = array();
						foreach($post->field->value as $val){
							$val = sanitize_text_field($val);
							$value[]=$val;
						}
					}else{
						$value = sanitize_text_field($post->field->value );
						if($post->field->type == 'datebox'){
							
							$timestamp = strtotime($post->field->value);
							$value = date("Y-m-d H:i:s", $timestamp);
						}
					}
					$flag = xprofile_set_field_data( $post->field->id,$this->user_id,$value);
				}
			}
			if($flag){
				$message = _x('Successfully Changed !','api message','vibe');
			}else{
				$message = _x('Unable to save changes','api message','vibe');
			}
			return 	new WP_REST_Response( array('message'=>$message), 200 );
			
	 	}

	}
	
}