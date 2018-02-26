<?php
/**
 * @package  SNF Custom Field
 */
/*
Plugin Name: SNF Custom Field
Plugin URI: #
Description: Trial Task for Schalk & Friends
Version: 1.0.0
Author: Madiha Javed
Author URI: #
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: snfcf_txt_dm
*/

if ( ! class_exists( 'Snfcf_Custom_Field' ) ) {

	class Snfcf_Custom_Field {

		//constructor call
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}

		protected function _constants() {
			/**
			 * Plugin Version
			 */
			define( 'SNFCF_PLUGIN_VER', '1.0.0' );

			/**
			 * Plugin Text Domain
			 */
			define("SNFCF_TXT_DM","snfcf_txt_dm" );

			/**
			 * Plugin Name
			 */
			define( 'SNFCF_PLUGIN_NAME', __( 'SNF Custom Field', 'snfcf_txt_dm' ) );

			/**
			 * Plugin Slug
			 */
			define( 'SNFCF_PLUGIN_SLUG', 'snfcf_custom_field' );

			/**
			 * Plugin Directory Path
			 */
			define( 'SNFCF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			/**
			 * Plugin Directory URL
			 */
			define( 'SNFCF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


		} // end of constructor function


		/**
		 * Setup the default filters and actions
		 * @uses      add_action()  To add various actions
		 * @access    private
		 * @return    void
		 */
		protected function _hooks() {

			/**
			 * Add meta box to all posts and pages
			 */
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );

			/**
			 * Save custom meta box value for individual post & pages
			 */
			add_action('save_post', array(&$this, '_save_settings'));


			/**
			 * Add additional http header based on saved value
			 */
			add_action( 'template_redirect', array(&$this, '_add_custom_header') );

		} // end of hook function


		/**
		 * Adds Meta Boxe to Post & Pages
		 * @access    private
		 * @return    void
		 * add_meta_box( $id, $title, $callback, $screen, $context, $priority,$callback_args );
		 */
		function _admin_add_meta_box($post) {

			add_meta_box(
				'snfcf_class',
				'Life Class Option',
				array(&$this,'snfcf_render_meta_box'),
				array('post','page'),
				'normal',
				'low'
			);
		}


		/**
		 *  Call back function rendering html for meta box
		 * @access    private
		 * @return    void
		 */
		function snfcf_render_meta_box($post ) {

			// Setting nonce field for meta box
		    wp_nonce_field( basename( __FILE__ ), 'snfcf_meta_box_nonce' );

		    // Setting meta key based
		    $snfcf_life_class_key = "snfcf_life_class_".$post->ID;

		    // Retrieving meta data from DB based on post ID
			$option = get_post_meta( $post->ID, $snfcf_life_class_key, true );
			?>

			<div class="">
				<label for="snfcf_life_class-life-class">Select Life Class</label>

                <select name="snfcf_life_class" id="snfcf_life_class" class="form-control">
					<option value="Hour" <?php if($option=="Hour") echo 'selected="selected"'; ?> >Hour</option>
					<option value="Day"  <?php if($option=="Day") echo 'selected="selected"'; ?> >Day</option>
					<option value="Week" <?php if($option=="Week") echo 'selected="selected"'; ?> >Week</option>
				</select>

			</div>

			<?php
		}

		/**
		 *  Save custom meta box value for individual post & pages
		 * @access    private
		 * @return    void
		 */

		 function _save_settings($post_id) {

			// Checks the user's permissions.
			if ( ! current_user_can( 'edit_post', $post_id ) ){
				return;
			}

			// Checks nonce field
			if ( !isset( $_POST['snfcf_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['snfcf_meta_box_nonce'], basename( __FILE__ ) ) ){
				return;
			}
			else {
				if (isset( $_POST['snfcf_life_class'])){

					// Setting meta key
                    $snfcf_life_class_key = "snfcf_life_class_".$post_id;

					// Saving meta data for based on post id
					update_post_meta( $post_id, $snfcf_life_class_key, sanitize_text_field( $_POST['snfcf_life_class'] ) );

					//echo ("done");
					//exit;

				}
			}
		}// end save setting

		/**
		 *  Add additional http header based on saved value
		 * @access    private
		 * @return    void
		 */

		function _add_custom_header() {

			global $wp_query;

			$post_id=$wp_query->post->ID;

			$snfcf_life_class_key = "snfcf_life_class_".$post_id;

			$value = get_post_meta( $post_id, $snfcf_life_class_key, true );

			header( "'X-Lifetime-Class: ".$value );

		}


	} // end of class

	/**
	 * Instantiates the Class
	 * @global    object	$clktusg_gallery_object
	 */
	$clktusg_gallery_object = new Snfcf_Custom_Field();

} // end of if class exists
?>