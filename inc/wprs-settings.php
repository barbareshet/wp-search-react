<?php
/**
 * Created by PhpStorm.
 * User: ido
 * Date: 3/13/2019
 * Time: 08:00
 */

if (!defined('ABSPATH')) {
	exit;
}
if (! class_exists('WPRS_Setting')){
	class WPRS_Setting{

		private static $instance = null;

		public $wprs_options;


		public static function get_instance(){

			if ( null == self::$instance ){
				self::$instance = new self();
			}
			return self::$instance;
		}

		private function __construct() {
			if ( is_admin() ){

				add_action( 'admin_menu', array( &$this, 'wprs_options_menu_link') );
			}
		}


		function wprs_options_menu_link(){

			add_submenu_page(
				'options-general.php',
				'WP React Search Options',
				'WP React Search',
				'manage_options',
				'wprs-options',
				array( $this, 'wprs_options_content')
			);
		}

		function wprs_options_content(){

			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
// init global variable for options

			global $wprs_options;

			$post_types_args = array(
				'public'   => true,
				'publicly_queryable' => true,
				'exclude_from_search'   => false
			);
			$output = 'names'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'
			$post_types = get_post_types( $post_types_args, $output, $operator );
			ob_start();?>

			<div class="wrap">
				<h2><?php _e('WP React Search', 'wprs') ;?></h2>
				<p>
					<?php _e('Settings For the WP React Search Plugin', 'wprs') ;?>
				</p>
				<form action="options.php" method="post">

					<?php settings_fields('wprs_settings_group') ;?>
					<table class="form-table">
						<tbody>

						<tr>
							<th>
								<label for="wprs_settings[wprs_post_types]">
									<?php _e('Select Post Type', 'wprs');?>
								</label>
							</th>
							<td>
								<?php foreach ( $post_types  as $post_type ) { ?>
									<input type="checkbox" name="wprs_settings[wprs_post_types]" value="1" <?php checked( $wprs_options['wprs_post_types'], 1 ); ?> /><?php echo $post_type;?><br/>
								<?php } ?>
								<p class="description">
									<?php _e('Choose post type to search in', 'wprs');?>
								</p>
							</td>
						</tr>

						</tbody>
					</table>
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'wprs') ;?>">
					</p>
				</form>
			</div>
			<?php echo ob_get_clean();

		}
	}

	WPRS_Setting::get_instance();
}
