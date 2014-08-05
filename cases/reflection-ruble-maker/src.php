<?php

	Class FormGroupPreferences {
		public $_table = 'bbcms_formgroups_preferences';
	}

	Class FormGroupMailHandler {
		public static $db;

		public static function getDatabase ( ) {
			if ( !self :: $db ) {
				self :: $db = Loader :: db ( );
			}

			return self :: $db;
		}

		public static function inviteMemberProfiles ( $params ) {
			$params = self :: setFormGroupStatusToInvite ( $params );
			$email_id = self :: generateEmailFromTemplate ( );
			self :: putEmailsInTodoQueue ( $email_id, $params );
		}

		public static function setFormGroupStatusToInvite ( $params ) {
			$value_strings = array ( );
			foreach ( $params['invitees'] as $k => $v ) {
				$params[ 'invitees' ][ $k ][ 'activation_code' ] = md5 ( PASSWORD_SALT . ':' . $params[ 'invitees' ][ $k ][ 'email' ] );
				$value_strings[ ] = "( " . $params[ 'formgroup_id' ] . ", " . $v[ 'member_profile_id' ] . ", 5, '" . $params[ 'invitees' ][ $k ][ 'uniqid' ] . "' )";
			}
			$sql_set_role = "
				INSERT INTO bbcms_formgroups_memberprofiles_roles
				( formgroup_id, member_profile_id, role_id, activation_code )
				VALUES
			";
			$sql_set_role .= implode ( ',', $value_strings );
			$sql_set_role .= "
				ON DUPLICATE KEY UPDATE
				formgroup_id = VALUES( formgroup_id ),
				member_profile_id = VALUES( member_profile_id ),
				role_id = VALUES( role_id ),
				activation_code = VALUES( activation_code )			
			";
			self :: getDatabase ( ) -> execute ( $sql_set_role );

			return $params;
		}

		public static function generateEmailFromTemplate ( ) {
			// TODO: move email_template_id to a preferences table
			$db = self :: getDatabase ( );
			$sql_select_email_template = "
				SELECT body_html, body_plain_txt
				FROM bbcms_email_templates
				WHERE email_template_id = 2
				LIMIT 1
			";
			$email_template = $db -> getRow ( $sql_select_email_template );
			$sql_insert_email = "
				INSERT INTO bbcms_email_queue
				( sender_name, sender_email, reply_to_name, reply_to_email, system_uri, subject, body_html, body_plain_txt )
				VALUES
				( ?, ?, ?, ?, ?, ?, ?, ? )
			";
			$bindparams = array (
				'Bureau Blanco Tech Dpt',
				'jan@bureaublanco.nl',
				'Bureau Blanco Tech Dpt',
				'jan@bureaublanco.nl',
				'triplep-parenting.net',
				'TPICMS cron test',
				$email_template[ 'body_html' ],
				$email_template[ 'body_plain_txt' ],
			);
			$db -> execute ( $sql_insert_email, $bindparams );

			return ($db -> Insert_ID ( ));
		}

		public static function putEmailsInTodoQueue ( $email_id, $params ) {
			$db = self :: getDatabase ( );
			$sql_insert = "
				INSERT INTO bbcms_email_queue_todo
				( email_id, name, email )
				VALUES
				( ?, ?, ? )
			";
			$bindparams = array (
				$email_id,
				'Jan Koehoorn',
				'jan@bureaublanco.nl',
			);

			foreach ( $params['invitees'] as $invitee ) {
				// Fill bbcms_email_queue_todo
				$db -> execute ( $sql_insert, $bindparams );

				// Fill bbcms_email_personalize
				$todo_id = $db -> Insert_ID ( );
				$replacements = array (
					'{{formgroup_id}}' => 1,
					'{{member_profile_id}}' => $invitee[ 'member_profile_id' ],
					'{{name}}' => $invitee[ 'name' ],
					'{{activation_code}}' => $invitee[ 'activation_code' ],
				);
				self :: putReplacementsInPersonalize ( $email_id, $todo_id, $replacements );
				unset ( $replacements );
			}

		}

		public static function putReplacementsInPersonalize ( $email_id, $todo_id, $replacements ) {
			$sql = "
				INSERT INTO bbcms_email_personalize
				( email_id, todo_id, search_for, replace_with )
				VALUES
			";
			$insert_strings = array ( );

			foreach ( $replacements as $search_for => $replace_with ) {
				$insert_strings[ ] = "( " . $email_id . ", " . $todo_id . ", '" . $search_for . "', '" . $replace_with . "' )";
			}

			$sql .= implode ( ',', $insert_strings ) . ';';
			self :: getDatabase ( ) -> execute ( $sql );
		}

	}

	Class FormGroupFactory {
		public static function create ( Registry $Registry ) {
			switch ( $Registry -> instance -> url_code ) {
				default:
					$FormGroup = new FormGroup;
					break;
			}

			return $FormGroup;
		}

		public static function createPrinter ( Registry $Registry ) {
			switch ( $Registry -> instance -> url_code ) {
				default:
					//@formatter:off
					$FormGroupPreferences = new FormGroupPreferences;
					$bindparams           = array ( $Registry -> instance -> instance_id );
					$FormGroupFacade      = new FormGroupFacade ( $Registry );
					$FormGroupPermissions = new FormGroupPermissions ( $Registry );
					$FormGroupPrinter     = new FormGroupPrinter;

					$FormGroupPreferences -> load ( 'instance_id = ?', $bindparams );
					$FormGroupPrinter 	  -> setPreferences ( $FormGroupPreferences );
					$FormGroupPrinter     -> setFacade ( $FormGroupFacade );
					$FormGroupPrinter     -> setPermissions ( $FormGroupPermissions );
					//@formatter:on
					break;
			}

			return $FormGroupPrinter;
		}

	}

	Class FormGroupFacade {
		private $members_overview = array ( );
		private $members_pending = array ( );
		private $members_invite = array ( );

		public function __construct ( $Registry ) {
			$this -> compile ( $Registry -> instance -> instance_id );
		}

		public function compile ( $instance_id ) {
			$rows = FormGroup :: getMemberProfilesPronto ( $instance_id );

			foreach ( $rows as $row ) {
				switch ($row['role_id']) {
					case '1':
					case '2':
					case '3':
						$this -> members_overview[ ] = $row;
						break;

					case '4':
					case '5':
						$this -> members_pending[ ] = $row;
						break;

					default:
						$this -> members_invite[ ] = $row;
						break;
				}
			}
		}

		public function getMembersOverview ( ) {
			return $this -> members_overview;
		}

		public function getMembersPending ( ) {
			return $this -> members_pending;
		}

		public function getMembersInvite ( ) {
			return $this -> members_invite;
		}

	}

	Class FormGroup {
		public static $db;
		public $_table = 'bbcms_formgroups';
		public $required = array (
			'instance_id',
			'title',
			'type',
		);

		public static function checkActivation ( $bindparams ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT *
				FROM bbcms_formgroups_memberprofiles_roles
				WHERE formgroup_id = ?
				AND member_profile_id = ?
				AND activation_code = ?
				LIMIT 1
			";
			$rows = $db -> getAll ( $sql, $bindparams );

			return (count ( $rows ) == 1);
		}

		public static function getById ( $formgroup_id ) {
			if ( empty ( $formgroup_id ) ) {
				return false;
			}

			$FormGroup = new FormGroup;
			$bindparams = array ( $formgroup_id );
			$FormGroup -> load ( 'formgroup_id = ?', $bindparams );

			return $FormGroup;
		}

		public static function getRole ( MemberProfile $memberprofile, FormGroup $formgroup ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT role_id
				FROM bbcms_formgroups_memberprofiles_roles
				WHERE formgroup_id = ?
				AND member_profile_id = ?
			";
			$bindparams = array (
				$formgroup -> formgroup_id,
				$memberprofile -> member_profile_id,
			);
			$role_id = $db -> getOne ( $sql, $bindparams );

			if ( empty ( $role_id ) ) {
				return false;
			}

			$formgroup_role = new FormGroupRole;
			$bindparams = array ( $role_id );
			$formgroup_role -> load ( 'role_id = ?', $bindparams );

			return $formgroup_role;
		}

		public static function deletePost ( $post_id ) {
			if ( empty ( $post_id ) ) {
				return false;
			}

			$post = FormGroup :: getPost ( $post_id );
			$post -> delete ( );
		}

		public static function updatePost ( $params ) {
			//@formatter:off
			$post_id                      = FormGroup :: coalesce ( $params[ 'post_id' ] );
			$html_content                 = FormGroup :: coalesce ( $params[ 'html_content' ] );

			$validator                    = new FormGroupValidator;
			$validator -> data -> post_id = $post_id;

			$post                         = FormGroup :: getPost ( $post_id );
			$post -> html_content         = $html_content;
			//@formatter:on

			$validator -> verify ( $post );

			if ( $validator -> pass ) {
				$post -> save ( );
			}

			return $validator;
		}

		public static function updateRole ( $params ) {
			$db = self :: getDatabase ( );
			$sql = "
				UPDATE bbcms_formgroups_memberprofiles_roles
				SET role_id = ?
				WHERE member_profile_id = ?
				AND formgroup_id = ?
				LIMIT 1
			";
			$bindparams = array (
				$params[ 'role_id' ],
				$params[ 'member_profile_id' ],
				$params[ 'formgroup_id' ],
			);
			$db -> execute ( $sql, $bindparams );

			return $params;
		}

		public static function getPost ( $post_id ) {
			if ( empty ( $post_id ) ) {
				return false;
			}

			$post = new FormGroupPost;
			$post -> load ( 'post_id = ?', array ( $post_id ) );

			return $post;
		}

		public static function createPost ( $params ) {
			//@formatter:off
			$formgroup_id                  = FormGroup :: coalesce ( $params[ 'formgroup_id' ] );
			$member_profile_id             = FormGroup :: coalesce ( $params[ 'member_profile_id' ] );
			$html_content                  = FormGroup :: coalesce ( $params[ 'html_content' ] );

			$validator                     = new FormGroupValidator;
			$validator -> data -> topic_id = $topic_id;

			$post                          = new FormGroupPost;
			$post -> post_id               = null;
			$post -> topic_id              = $topic_id;
			$post -> member_profile_id     = $member_profile_id;
			$post -> html_content          = $html_content;
			$post -> sticky                = 0;
			$post -> weight                = 0;
			$post -> doc                   = strftime ( '%F %T' );
			$post -> dlm                   = strftime ( '%F %T' );
			//@formatter:on

			$validator -> verify ( $post );

			if ( $validator -> pass ) {
				$post -> save ( );
			}

			return $validator;
		}

		public static function getOwner ( $formgroup_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT fmr.formgroup_id,
				       fmr.member_profile_id,
				       fmr.role_id,
				       mp.firstname,
				       mp.lastname,
				       mp.email
				FROM   bbcms_formgroups_memberprofiles_roles AS fmr
				       LEFT JOIN bbcms_member_profiles AS mp
				              ON ( fmr.member_profile_id = mp.member_profile_id )
				WHERE  fmr.formgroup_id = ?
				   AND fmr.role_id = 1
				LIMIT 1
			";
			$bindparams = array ( $formgroup_id );
			$row = $db -> getRow ( $sql, $bindparams );

			return ( object )$row;
		}

		public static function getMods ( $formgroup_id ) {
			return self :: getMembers ( $formgroup_id, 2 );
		}

		public static function getMemberProfiles ( $formgroup_id ) {
			return self :: getMembers ( $formgroup_id, 3 );
		}

		public static function getMemberProfilesPronto ( $instance_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					m.member_profile_id,
				    IF (m.img_profile = '', 'img-avatar-170x170.jpg', m.img_profile) AS img_profile,
					IF (middlename = '', CONCAT (firstname, ' ', lastname), CONCAT (firstname, ' ', middlename, ' ', lastname)) AS fullname,
					m.email,
					IFNULL(fmr.formgroup_id, 0) AS formgroup_id,
					IFNULL(fmr.role_id, 0) AS role_id,
					GROUP_CONCAT(LPAD(l.level_id, 4, '0')) AS level_ids,
					IFNULL(m.doc, '')
				FROM bbcms_members_levels AS ml
				LEFT JOIN bbcms_levels AS l ON ( ml.level_id = l.level_id )
				LEFT JOIN bbcms_member_profiles AS m ON ( ml.member_profile_id = m.member_profile_id )
				LEFT JOIN bbcms_formgroups_memberprofiles_roles AS fmr ON ( ml.member_profile_id = fmr.member_profile_id )
				WHERE  m.instance_id = ?
				AND m.exclude_from_member_referral = 0
				GROUP  BY( m.member_profile_id )
				ORDER  BY m.lastname ASC			
			";
			$bindparams = array ( $instance_id );
			$rows = $db -> getAll ( $sql, $bindparams );

			return $rows;
		}

		public static function getMembers ( $formgroup_id, $role_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT fmr.formgroup_id,
				       fmr.member_profile_id,
				       fmr.role_id,
				       mp.firstname,
				       mp.lastname,
				       mp.email
				FROM   bbcms_formgroups_memberprofiles_roles AS fmr
				       LEFT JOIN bbcms_member_profiles AS mp
				              ON ( fmr.member_profile_id = mp.member_profile_id )
				WHERE  fmr.formgroup_id = ?
				   AND fmr.role_id = ?
			";
			$bindparams = array (
				$formgroup_id,
				$role_id,
			);
			$rows = $db -> getAll ( $sql, $bindparams );

			return $rows;
		}

		public static function handleRequest ( MemberProfile $memberprofile, $formgroup_id, $action = 'accept' ) {
			if ( empty ( $memberprofile ) || empty ( $formgroup_id ) ) {
				return false;
			}

			$role_id = 0;

			switch ($action) {
				case 'accept':
					$role_id = 3;
					break;

				case 'decline':
					$role_id = 7;
					break;

				case 'ignore':
					$role_id = 8;
					break;
			}

			$db = self :: getDatabase ( );
			$sql = "
				UPDATE bbcms_formgroups_memberprofiles_roles
				SET role_id = ?
				WHERE formgroup_id = ?
				AND member_profile_id = ?
				AND role_id = 5
			";
			$bindparams = array (
				$role_id,
				$formgroup_id,
				$memberprofile -> member_profile_id,
			);
			$db -> execute ( $sql, $bindparams );
		}

		public static function requestAccess ( MemberProfile $memberprofile, $formgroup_id ) {
			if ( empty ( $memberprofile ) || empty ( $formgroup_id ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$sql = "
				INSERT INTO bbcms_formgroups_memberprofiles_roles
				( formgroup_id, member_profile_id, role_id )
				VALUES
				( ?, ?, ? )
			";
			$bindparams = array (
				$formgroup_id,
				$memberprofile -> member_profile_id,
				5,
			);
			$db -> execute ( $sql );
		}

		public static function banMemberProfiles ( array $memberprofiles = array(), $formgroup_id ) {
			if ( empty ( $memberprofiles ) || empty ( $formgroup_id ) ) {
				return false;
			}

			foreach ( $memberprofiles as $memberprofile ) {
				FormGroup :: banMemberProfile ( $memberprofile, $formgroup_id );
			}
		}

		public static function banMemberProfile ( MemberProfile $memberprofile, $formgroup_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				UPDATE bbcms_formgroups_memberprofiles_roles
				SET role_id = 6
				WHERE formgroup_id = ?
				AND member_profile_id = ?
			";
			$bindparams = array (
				$formgroup_id,
				$memberprofile -> member_profile_id,
			);
			$db -> execute ( $sql, $bindparams );
		}

		public static function removeMemberProfile ( MemberProfile $memberprofile, $formgroup_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				DELETE FROM bbcms_formgroups_memberprofiles_roles
				WHERE member_profile_id = ?
			";
			$bindparams = array ( $memberprofile -> member_profile_id );
			$db -> execute ( $sql, $bindparams );
		}

		public static function removeMemberProfiles ( array $memberprofiles = array(), $formgroup_id ) {
			if ( empty ( $memberprofiles ) || empty ( $formgroup_id ) ) {
				return false;
			}

			foreach ( $memberprofiles as $memberprofile ) {
				FormGroup :: removeMemberProfile ( $memberprofile, $formgroup_id );
			}
		}

		public static function getMemberProfileRoles ( ) {

		}

		// TODO: check status withing group for this memberprofile. If someone is banned, it
		// should not be possible to add them. If someone is invited or requests access, those
		// roles should be removed from bbcms_formgroups_memberprofiles_roles
		public static function addMemberProfile ( MemberProfile $memberprofile, $formgroup_id ) {
			$db = self :: getDatabase ( );
			$sql = "
				INSERT IGNORE INTO bbcms_formgroups_memberprofiles_roles
				(formgroup_id,member_profile_id,role_id)
				VALUES
				(?,?,?)
			";
			$bindparams = array (
				$formgroup_id,
				$memberprofile -> member_profile_id,
				3,
			);
			$db -> execute ( $sql, $bindparams );
		}

		public static function addMemberProfiles ( array $memberprofiles = array(), $formgroup_id ) {
			if ( empty ( $memberprofiles ) || empty ( $formgroup_id ) ) {
				return false;
			}

			foreach ( $memberprofiles as $memberprofile ) {
				FormGroup :: addMemberProfile ( $memberprofile, $formgroup_id );
			}
		}

		public static function getByMembership ( MemberProfile $memberprofile ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					fmr.formgroup_id,
					fmr.member_profile_id,
					fmr.role_id,
					f.title,
					f.type
				FROM
					bbcms_formgroups_memberprofiles_roles AS fmr
				LEFT JOIN bbcms_formgroups AS f
					ON ( fmr.formgroup_id = f.formgroup_id )
				WHERE  fmr.member_profile_id = ?
				AND fmr.role_id IN( 2, 3 )
			";
			$bindparams = array ( $memberprofile -> member_profile_id );
			$rows = $db -> getAll ( $sql, $bindparams );

			return $rows;
		}

		public static function getByOwnership ( MemberProfile $memberprofile ) {
			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					fmr.formgroup_id,
					fmr.member_profile_id,
					fmr.role_id,
					f.title,
					f.type
				FROM
					bbcms_formgroups_memberprofiles_roles AS fmr
				LEFT JOIN bbcms_formgroups AS f
					ON ( fmr.formgroup_id = f.formgroup_id )
				WHERE  fmr.member_profile_id = ?
				AND fmr.role_id = 1
			";
			$bindparams = array ( $memberprofile -> member_profile_id );
			$rows = $db -> getAll ( $sql, $bindparams );

			return $rows;
		}

		public static function getAll ( $instance_id = false ) {
			$db = self :: getDatabase ( );

			if ( $instance_id === false ) {
				$records = $db -> getActiveRecordsClass ( 'FormGroup', 'bbcms_formgroups', '1' );
			}
			else {
				$bindparams = array ( $instance_id );
				$records = $db -> getActiveRecordsClass ( 'FormGroup', 'bbcms_formgroups', 'instance_id = ?', $bindparams );
			}

			return $records;
		}

		public static function create ( $params ) {
			//@formatter:off
			$instance_id                            = FormGroup :: coalesce ( $params[ 'instance_id' ] );
			$title                                  = FormGroup :: coalesce ( $params[ 'title' ] );
			$type                                   = FormGroup :: coalesce ( $params[ 'type' ] );

			$validator                              = new FormGroupValidator;
						
			$formgroup                              = new FormGroup;
			$formgroup -> formgroup_id              = null;
			$formgroup -> instance_id               = $instance_id;
			$formgroup -> post_reply_form_schema_id = 11;
			$formgroup -> page_id_overview          = 0;
			$formgroup -> page_id_detail            = 0;
			$formgroup -> title                     = $title;
			$formgroup -> type                      = $type;
			$formgroup -> timezone                  = 'Europe/Amsterdam';
			$formgroup -> doc                       = strftime ( '%F %T' );
			$formgroup -> dlm                       = strftime ( '%F %T' );
  			//@formatter:on

			$validator -> verify ( $formgroup );

			if ( $validator -> pass ) {
				$formgroup -> save ( );
			}

			return $validator;
		}

		// TODO: duplicate code, also exists in Forum. Move to helper or create parent class for Forum and FormGroup
		// Manage $db through Singleton Pattern
		public static function getDatabase ( ) {
			if ( !self :: $db ) {
				self :: $db = Loader :: db ( );
			}

			return self :: $db;
		}

		// TODO: duplicate code, also exists in Forum. Move to helper or create parent class for Forum and FormGroup
		public static function clearCache ( ) {
			$db = self :: getDatabase ( );
			$db -> CacheFlush ( );
		}

		// TODO: duplicate code, also exists in Forum. Move to helper or create parent class for Forum and FormGroup
		public static function coalesce ( ) {
			foreach ( func_get_args( ) as $arg ) {
				if ( !empty ( $arg ) ) {
					return $arg;
				}
			}

			return false;
		}

		// TODO: duplicate code, also exists in Forum. Move to helper or create parent class for Forum and FormGroup
		public static function getImageHtml ( $file_id, $w = 48, $h = 32 ) {
			$img_html = '';
			$imgfile_obj = File :: getById ( $file_id );

			if ( is_object ( $imgfile_obj ) ) {
				$thumb = Loader :: helper ( 'image' ) -> getThumbnail ( $imgfile_obj, $w, $h );
				if ( is_object ( $thumb ) ) {
					$img_html = '<img src="' . $thumb -> src . '" />';
				}
			}

			return $img_html;
		}

	}

	Class FormGroupPost {
		public $_table = 'bbcms_formgroup_posts';
		public $errs = array ( );
		public $required = array (
			'formgroup_id',
			'member_profile_id',
			'html_content',
		);

		// This is needed for array_unique in the ForumPrinter classes
		public function __toString ( ) {
			return $this -> post_id;
		}

		public function populate ( array $params ) {
			foreach ( $this -> GetAttributeNames( ) as $key ) {
				if ( !empty ( $params[ $key ] ) ) {
					$this -> $key = $params[ $key ];
				}
				else {
					// This is important, because otherwise Active Record will
					// complain about numbers of columns that don't match
					$this -> $key = '';
				}
			}
		}

		public function save ( ) {
			parent :: save ( );

			$formgroup = new FormGroup;
			$formgroup -> load ( 'formgroup_id = ?', array ( $this -> formgroup_id ) );
			$formgroup -> dlm = $this -> dlm;
			$formgroup -> save ( );
		}

		public function delete ( ) {
			$formgroup = new FormGroup;
			$formgroup -> load ( 'formgroup_id = ?', array ( $this -> formgroup_id ) );
			$formgroup -> dlm = strftime ( '%F %T' );
			$formgroup -> save ( );

			parent :: delete ( );
		}

	}
?>