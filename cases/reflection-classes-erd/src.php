<?php
	Interface ForumPrinter {
		public function printCategory ( );
		public function printThread ( );
	}

	Class ProviderSiteForumPrinter implements ForumPrinter {
		private $forumpermissions;

		public function __construct ( ForumPermissions $forumpermissions ) {
			$this -> forumpermissions = $forumpermissions;
		}

		public function printCategory ( ) {
			if ( empty ( $this -> forumpermissions ) ) {
				return false;
			}

			if ( $threads = Forum :: getThreads ( $this -> forumpermissions -> category -> category_id ) ) {
				echo '
					<table class="forums threads">
						<thead>
							<tr>
								<th>Title</th>
								<th>Owner</th>
								<th>Posts</th>
								<th>Created</th>
								<th>Last modified</th>
							</tr>
						</thead>
						<tbody>
				';

				foreach ( $threads as $thread ) {
					$member_profile = new MemberProfile;
					$bindparams = array ( $thread -> member_profile_id );
					$member_profile -> load ( 'member_profile_id = ?', $bindparams );
					$href_posts = Page :: getCollectionPathFromID ( 2849 );
					$num_posts = Forum :: getNumPosts ( $thread -> thread_id );

					echo '
						<tr class="thread">
							<td class="medium"><a href="' . DIR_REL . $href_posts . '?id=' . $thread -> thread_id . '">' . $thread -> title . '</a></td>
							<td>' . $member_profile -> user . '</td>
							<td>' . $num_posts . '</td>
							<td>' . $thread -> doc . '</td>
							<td>' . $thread -> dlm . '</td>
						</tr>
					';
				}

				echo '
						</tbody>
					</table>
				';
			}

		}

		public function printThread ( ) {
			if ( empty ( $this -> forumpermissions ) ) {
				return false;
			}

			if ( $posts = Forum :: getPosts ( $this -> forumpermissions -> thread -> thread_id ) ) {
				$href_thread = '?id=' . $thread_id;

				foreach ( $posts as $post ) {
					$href_post = '?id=' . $post -> post_id;
					$css_classes_additional = '';

					if ( $post -> sticky ) {
						$css_classes_additional .= ' sticky';
					}

					Loader :: model ( 'member_profile', 'member_profile' );
					$member_profile = new MemberProfile;
					$bindparams = array ( $post -> member_profile_id );
					$member_profile -> load ( 'member_profile_id = ?', $bindparams );

					if ( $this -> forumpermissions -> canEditPost ( $post ) ) {
						echo '<p>Edit permission</p>';
					}

					echo '
						<div class="post clearfix' . $css_classes_additional . '">
							<div class="col-1">
								<h3>' . $member_profile -> user . '</h3>
								<div class="img-profile"><img src="/provider/files/profile-images/' . $member_profile -> img_profile . '" /></div>
								<div class="date">' . $post -> doc . '</div>
							</div>
							<div class="col-2">
								<ul class="buttons">
									<li><a class="quote" href="' . $href_post . '"></a></li>
									<li><a class="sticky" href="' . $href_post . '"></a></li>
									<li><a class="lock" href="' . $href_thread . '"></a></li>
									<li><a class="delete" href="' . $href_post . '"></a></li>
								</ul>
								<div class="clearer"></div>
								<div class="content">' . $post -> html_content . '</div>
							</div>
						</div>
					';
				}
			}
		}

	}

	Class Forum {
		public $_table = 'bbcms_forums';
		public static $db;

		// Manage $db through Singleton Pattern
		public static function getDatabase ( ) {
			if ( !self :: $db ) {
				self :: $db = Loader :: db ( );
			}

			return self :: $db;
		}

		public static function clearCache ( ) {
			$db = self :: getDatabase ( );
			$db -> CacheFlush ( );
		}

		// http://stackoverflow.com/questions/1013493/coalesce-function-for-php
		public static function coalesce ( ) {
			foreach ( func_get_args( ) as $arg ) {
				if ( !empty ( $arg ) ) {
					return $arg;
				}
			}

			return false;
		}

		public static function getFormStartThread ( array $params = array() ) {
			if ( empty ( $params[ 'member_profile_id' ] ) ) {
				return false;
			}
			if ( empty ( $params[ 'category_id' ] ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					thread_start_form_schema_id      
				FROM
					bbcms_forums
				WHERE forum_id = (
					SELECT
						forum_id                        
					FROM
						bbcms_forum_categories                        
					WHERE category_id = ?            
				)
			";
			$bindparams = array ( $params[ 'category_id' ] );
			$thread_start_form_schema_id = $db -> getOne ( $sql, $bindparams );

			if ( empty ( $thread_start_form_schema_id ) ) {
				return false;
			}

			Loader :: model ( 'form_factory', 'form_factory' );
			Loader :: model ( 'form_schema', 'form_factory' );

			$form_schema = new FormSchema;
			$form_schema -> load ( 'schema_id = ?', array ( $thread_start_form_schema_id ) );
			$form_start_thread = new Form ( $form_schema );
			$form_start_thread -> setFormFieldValue ( 'member_profile_id', $params[ 'member_profile_id' ] );
			$form_start_thread -> setFormFieldValue ( 'category_id', $params[ 'category_id' ] );
			$form_start_thread -> setFormFieldValue ( 'token', uniqid ( ) );
			$form_start_thread -> setFormFieldValue ( 'action', 'start-thread' );

			return $form_start_thread;
		}

		public static function getFormPostReply ( array $params = array() ) {
			if ( empty ( $params[ 'member_profile_id' ] ) ) {
				return false;
			}
			if ( empty ( $params[ 'thread_id' ] ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					post_reply_form_schema_id      
				FROM
					bbcms_forums
				WHERE forum_id = (
					SELECT
						forum_id                        
					FROM
						bbcms_forum_categories                        
					WHERE category_id = (
						SELECT
							category_id                                           
						FROM
							bbcms_forum_threads
						WHERE
							thread_id = ?
					)                
				)
			";
			$bindparams = array ( $params[ 'thread_id' ] );
			$post_reply_form_schema_id = $db -> getOne ( $sql, $bindparams );

			if ( empty ( $post_reply_form_schema_id ) ) {
				return false;
			}

			$html_content = '';
			if ( $params[ 'quote_id' ] ) {
				$forum_post_quote = new ForumPost;
				$forum_post_quote -> load ( 'post_id = ?', array ( $params[ 'quote_id' ] ) );
				$html_content = '
					<blockquote>
					' . $forum_post_quote -> html_content . '
					</blockquote>
					<p></p>
					';
			}

			Loader :: model ( 'form_factory', 'form_factory' );
			Loader :: model ( 'form_schema', 'form_factory' );

			$form_schema = new FormSchema;
			$form_schema -> load ( 'schema_id = ?', array ( $post_reply_form_schema_id ) );
			$form_post_reply = new Form ( $form_schema );
			$form_post_reply -> setAttribute ( 'action', '?id=' . $params[ 'thread_id' ] );
			$form_post_reply -> setFormFieldValue ( 'member_profile_id', $params[ 'member_profile_id' ] );
			$form_post_reply -> setFormFieldValue ( 'thread_id', $params[ 'thread_id' ] );
			$form_post_reply -> setFormFieldValue ( 'html_content', $html_content );
			$form_post_reply -> setFormFieldValue ( 'token', uniqid ( ) );

			return $form_post_reply;
		}

		public static function getByInstanceIds ( array $instance_ids ) {
			if ( empty ( $instance_ids ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$str_in = implode ( ',', $instance_ids );
			$sql = "
				SELECT
					forum_id,
					title,
					doc,
					dlm
				FROM bbcms_forums
				WHERE
					instance_id IN (" . $str_in . ")
				ORDER BY 
					title ASC
			";
			$records = array ( );

			foreach ( $db -> getAll ( $sql ) as $row ) {
				$records[ ] = (object)$row;
			}

			return $records;
		}

		public static function getCategories ( $forum_id = false ) {
			$db = self :: getDatabase ( );

			if ( $forum_id ) {
				$bindparams = array ( $forum_id );
				$records = $db -> getActiveRecordsClass ( 'ForumCategory', 'bbcms_forum_categories', 'forum_id = ? ORDER BY title ASC', $bindparams );
			}
			else {
				$records = $db -> getActiveRecordsClass ( 'ForumCategory', 'bbcms_forum_categories', '1 ORDER BY title ASC' );
			}

			return $records;

		}

		public static function getForum ( $forum_id ) {
			$forum = new Forum;
			$forum -> load ( 'forum_id = ?', array ( $forum_id ) );

			return $forum;
		}

		public static function getCategory ( $category_id ) {
			$category = new ForumCategory;
			$category -> load ( 'category_id = ?', array ( $category_id ) );

			return $category;
		}

		public static function getThread ( $thread_id ) {
			$thread = new ForumThread;
			$thread -> load ( 'thread_id = ?', array ( $thread_id ) );

			// Get number of posts from the last two weeks
			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					COUNT(post_id) AS num_posts
				FROM (
					SELECT
						post_id,
						thread_id
					FROM
						bbcms_forum_posts
					WHERE
						DATEDIFF(NOW(), dlm) < 14
				) AS fp
				WHERE thread_id = ?
			";
			$bindparams = array ( $thread_id );
			$thread -> num_posts_last_period = $db -> getOne ( $sql, $bindparams );

			// Get datetime for last activity
			$sql = "
				SELECT
					MAX(dlm) AS last_edit
				FROM
					bbcms_forum_posts
				WHERE
					thread_id = ?
			";
			$thread -> dt_last_activity = $db -> getOne ( $sql, $bindparams );

			return $thread;
		}

		public static function createThread ( $params ) {
			Forum :: clearCache ( );
			try {
				//@formatter:off
				$category_id                 = Forum :: coalesce ( $params[ 'category_id' ] );
				$member_profile_id           = Forum :: coalesce ( $params[ 'member_profile_id' ] );
				$title                       = Forum :: coalesce ( $params[ 'title' ] );
				$html_content                = Forum :: coalesce ( $params[ 'html_content' ] );
	
				$thread                      = new ForumThread;
				$thread -> thread_id         = null;
				$thread -> category_id       = $category_id;
				$thread -> member_profile_id = $member_profile_id;
				$thread -> title             = $title;
				$thread -> status            = 0;
				$thread -> sticky            = 0;
				$thread -> locked            = 0;
				$thread -> doc               = strftime ( '%F %T' );
				$thread -> dlm               = strftime ( '%F %T' );

				$thread -> save ( );
				//@formatter:on
			}
			catch ( Exception $e ) {
				echo '<pre class="debug">';
				print_r ( $e );
				echo '</pre>';
			}

			$params = array (
				'thread_id' => $thread -> thread_id,
				'member_profile_id' => $member_profile_id,
				'html_content' => $html_content,
			);

			Forum :: createPost ( $params );

			return $thread -> thread_id;
		}

		public static function getRole ( $forum_id, $member_profile_id ) {
			$db = Loader :: db ( );
			$sql = "
				SELECT role_id
				FROM bbcms_forums_memberprofiles_roles
				WHERE forum_id = ?
				AND member_profile_id = ?			
			";
			$bindparams = array (
				$forum_id,
				$member_profile_id
			);
			$role_id = $db -> GetOne ( $sql, $bindparams );

			if ( !empty ( $role_id ) ) {
				$role = new ForumRole;
				$role -> load ( 'role_id = ?', array ( $role_id ) );

				return $role;
			}

			return false;
		}

		public static function lockThread ( $thread_id ) {
			$db = self :: getDatabase ( );
			$thread = self :: getThread ( $thread_id );
			$thread -> locked = 1;
			$thread -> save ( );
		}

		public static function getThreads ( $category_id = false ) {
			if ( empty ( $category_id ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$bindparams = array ( $category_id );
			$records = $db -> getActiveRecordsClass ( 'ForumThread', 'bbcms_forum_threads', 'category_id = ? ORDER BY title ASC', $bindparams );

			return $records;
		}

		public static function getPost ( $post_id ) {
			if ( empty ( $post_id ) ) {
				return false;
			}

			$post = new ForumPost;
			$post -> load ( 'post_id = ?', array ( $post_id ) );

			return $post;
		}

		public static function createPost ( $params ) {
			//@formatter:off
			$thread_id                 = Forum :: coalesce ( $params[ 'thread_id' ] );
			$member_profile_id         = Forum :: coalesce ( $params[ 'member_profile_id' ] );
			$html_content              = Forum :: coalesce ( $params[ 'html_content' ] );
			$post                      = new ForumPost;
			$post -> post_id           = null;
			$post -> thread_id         = $thread_id;
			$post -> member_profile_id = $member_profile_id;
			$post -> html_content      = $html_content;
			$post -> sticky            = 0;
			$post -> weight            = 0;
			$post -> doc               = strftime ( '%F %T' );
			$post -> dlm               = strftime ( '%F %T' );

			$post -> save ( );
			//@formatter:on
		}

		public static function deletePost ( $post_id ) {
			if ( empty ( $post_id ) ) {
				return false;
			}

			$post = new ForumPost;
			$post -> load ( 'post_id = ?', array ( $post_id ) );
			$post -> delete ( );
		}

		public static function toggleStickyPost ( $post_id ) {
			if ( empty ( $post_id ) ) {
				return false;
			}

			$post = self :: getPost ( $post_id );
			$post -> sticky^=1;
			$post -> save ( );
		}

		public static function getPosts ( $thread_id = false ) {
			if ( empty ( $thread_id ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$bindparams = array ( $thread_id );
			$records = $db -> getActiveRecordsClass ( 'ForumPost', 'bbcms_forum_posts', 'thread_id = ? ORDER BY sticky DESC, dlm ASC', $bindparams );

			return $records;
		}

		public static function getNumPosts ( $thread_id ) {
			if ( empty ( $thread_id ) ) {
				return false;
			}

			$db = self :: getDatabase ( );
			$sql = "
				SELECT
					COUNT(post_id) AS num_post
				FROM
					bbcms_forum_posts
				WHERE
					thread_id = ?
			";
			$bindparams = array ( $thread_id );

			return $db -> getOne ( $sql, $bindparams );
		}

	}

	Class ForumCategory {
		public $_table = 'bbcms_forum_categories';
	}

	Class ForumThread {
		public $_table = 'bbcms_forum_threads';
		public $num_posts_last_period;
		public $dt_last_activity;
	}

	Class ForumPost {
		public $_table = 'bbcms_forum_posts';
		public $required = array (
			'thread_id',
			'member_profile_id',
			'html_content',
		);

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

		public function validates ( ) {
			foreach ( $this -> required as $fieldname ) {
				if ( empty ( $this -> $fieldname ) ) {
					return false;
				}
			}

			return true;
		}

		public function save ( ) {
			$db = Forum :: getDatabase ( );
			parent :: save ( );
		}

	}

	Class ForumPermissions {
		const FORUM_MEMBER = 1;
		const FORUM_MODERATOR = 2;
		const FORUM_CLIENT_ADMIN = 3;
		public $memberprofile;
		public $forum;
		public $category;
		public $thread;
		public $role;

		public function __construct ( MemberProfile $memberprofile, $elem ) {
			$classname = get_class ( $elem );

			$this -> memberprofile = $memberprofile;

			if ( $classname == 'ForumThread' ) {
				$this -> thread = $elem;
				$this -> category = Forum :: getCategory ( $this -> thread -> category_id );
				$this -> forum = Forum :: getForum ( $this -> category -> forum_id );
				$this -> role = Forum :: getRole ( $this -> forum -> forum_id, $this -> memberprofile -> member_profile_id );
			}
			elseif ( $classname == 'ForumCategory' ) {
				$this -> category = $elem;
				$this -> forum = Forum :: getForum ( $this -> category -> forum_id );
				$this -> role = Forum :: getRole ( $this -> forum -> forum_id, $this -> memberprofile -> member_profile_id );
			}
		}

		public function canEditPost ( ForumPost $post ) {
			switch ($this -> role -> role_id) {
				case self :: FORUM_MEMBER:
					return ($post -> member_profile_id == $this -> memberprofile -> member_profile_id);
					break;

				// These two cases are treated the same, so no 'break' needed for the first case
				case self :: FORUM_MODERATOR:
				case self :: FORUM_CLIENT_ADMIN:
					return true;
					break;
			}

			return false;
		}

		public function canToggleStickyThread ( ) {
			//@formatter:off
			return (
				$this -> role -> role_id == self :: FORUM_CLIENT_ADMIN ||
				$this -> role -> role_id == self :: FORUM_MODERATOR
			);
			//@formatter:on
		}

		public function canLockThread ( ) {
			//@formatter:off
			return (
				$this -> role -> role_id == self :: FORUM_CLIENT_ADMIN ||
				$this -> role -> role_id == self :: FORUM_MODERATOR
			);
			//@formatter:on
		}

	}

	Class ForumRole {
		public $_table = 'bbcms_forum_roles';
	}
?>