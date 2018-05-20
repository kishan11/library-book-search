<?php
/**
 * Provide a admin area view for the plugin
 *
 * @link       https://www.linkedin.com/in/kishanvadaliya/
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Library_Book_Search_Admin_Screen {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* Add the help menu in book custom post
	*/
	public function lbs_book_admin_menu(){
		add_submenu_page("edit.php?post_type=books", __('Book Search Help','library-book-search'), __('Book Search Help','library-book-search'), "manage_options", "books-help", array($this,"lbs_book_help") ,'' , 45 );
		
	}
	
	
	public function lbs_book_help(){
	 ?>
		<div class="lbs-admin-screen-sec">		
			<div class="lbs-screen-title"><?php echo __('Library Book Search Help','library-book-search'); ?></div>
            
            <div class="lbs-admin-screen-body">
            	<div class="help-sec-desc">
            		<strong>Please use below shortcode to display the search form:</strong>
                    <div><pre>[library_book_search]</pre></div>
                </div>
                <div class="help-sec-img-sec">
                	<img src="<?php echo plugins_url('images/admin-book.jpg', dirname(__FILE__)); ?>" alt="Book Image" />
                </div>
            </div>
		
		</div>
     <?php
	}

}