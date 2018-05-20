<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/kishanvadaliya/
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/admin
 * @author     Kishan Vadaliya <kishanvadaliya2011@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Library_Book_Search_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_Book_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_Book_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library-book-search-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Library_Book_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Library_Book_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library-book-search-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
	public function lbs_define_book_post_and_taxonomy(){
		/**
		* Register the custom post for book
		*/
		$labels = array(
			'name'               => _x( 'Books', 'post type general name' ),
			'singular_name'      => _x( 'Book', 'post type singular name' ),
			'menu_name'          => _x( 'Books', 'admin menu'),
			'name_admin_bar'     => _x( 'Book', 'add new on admin bar' ),
			'add_new'            => _x( 'Add New Book', 'library-book-search' ),
			'add_new_item'       => __( 'Add New Book' ,'library-book-search'),
			'new_item'           => __( 'New Book' ,'library-book-search'),
			'edit_item'          => __( 'Edit Book' ,'library-book-search'),
			'view_item'          => __( 'View Book' ,'library-book-search'),
			'all_items'          => __( 'All Books' ,'library-book-search'),
			'search_items'       => __( 'Search Book' ,'library-book-search'),
			'parent_item_colon'  => __( 'Parent Book:' ,'library-book-search'),
			'not_found'          => __( 'No Book found.' ,'library-book-search'),
			'not_found_in_trash' => __( 'No Books found in Trash.' ,'library-book-search')
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'	 => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'books' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'exclude_from_search' => false,
			'menu_position'      => 20,
			'menu_icon'			 => 'dashicons-book',
			'supports'           => array( 'title', 'editor', 'thumbnail')
		);	
		register_post_type( 'books', $args );
		flush_rewrite_rules();
		
		/**
		* Register taxonomy of author for book
		*/
		$labels = array(
			'name'              => _x( 'Authors', 'taxonomy general name' ),
			'singular_name'     => _x( 'Author', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Authors' ,'library-book-search'),
			'popular_items'     => __( 'Popular Authors' ,'library-book-search'),
			'all_items'         => __( 'All Authors' ,'library-book-search'),
			'parent_item'       => __( 'Parent Author' ,'library-book-search'),
			'parent_item_colon' => __( 'Parent Author:' ,'library-book-search'),
			'edit_item'         => __( 'Edit Author' ,'library-book-search'),
			'update_item'       => __( 'Update Author' ,'library-book-search'),
			'add_new_item'      => __( 'Add New Author' ,'library-book-search'),
			'new_item_name'     => __( 'New Author Name' ,'library-book-search'),
			'separate_items_with_commas' => __( 'Separate Authors with commas' ,'library-book-search'),
			'add_or_remove_items'        => __( 'Add or remove Authors' ),
			'choose_from_most_used'      => __( 'Choose from the most used Authors' ,'library-book-search'),
			'not_found'                  => __( 'No Authors found.' ,'library-book-search'),
			'menu_name'         => __( 'Authors' ,'library-book-search'),
		);	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-author' ),
		);	
		register_taxonomy( 'book_author', array( 'books' ), $args );
		
		/**
		* Register taxonomy of publisher for book
		*/
		$labels = array(
			'name'              => _x( 'Publishers', 'taxonomy general name' ),
			'singular_name'     => _x( 'Publisher', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Publishers' ,'library-book-search'),
			'popular_items'     => __( 'Popular Publishers' ,'library-book-search'),
			'all_items'         => __( 'All Publishers' ,'library-book-search'),
			'parent_item'       => __( 'Parent Publisher' ,'library-book-search'),
			'parent_item_colon' => __( 'Parent Publisher:' ,'library-book-search'),
			'edit_item'         => __( 'Edit Publisher' ,'library-book-search'),
			'update_item'       => __( 'Update Publisher' ,'library-book-search'),
			'add_new_item'      => __( 'Add New Publisher' ,'library-book-search'),
			'new_item_name'     => __( 'New Publisher Name' ,'library-book-search'),
			'separate_items_with_commas' => __( 'Separate Publishers with commas' ,'library-book-search'),
			'add_or_remove_items'        => __( 'Add or remove Publishers' ,'library-book-search'),
			'choose_from_most_used'      => __( 'Choose from the most used Publishers' ,'library-book-search'),
			'not_found'                  => __( 'No Publishers found.' ,'library-book-search'),
			'menu_name'         => __( 'Publishers' ,'library-book-search'),
		);	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-publisher' ),
		);	
		register_taxonomy( 'book_publisher', array( 'books' ), $args );
	
	}
	
	
	/**
	* Add the meta boxes in book
	*/
	public function lbs_book_meta_boxes(){
		add_meta_box('lbs-book-details', 'Books Details', array($this,'lbs_book_details_meta'), 'books', 'side', 'high');
	}
	
	public function lbs_book_details_meta(){
		global $posts;
		
		wp_nonce_field( 'book_meta_box_nonce', 'book_meta_box_nonce_val' );
		$post_id = get_the_ID();
		$book_price = get_post_meta( $post_id, 'book_price', true );
		$book_rating = get_post_meta( $post_id, 'book_rating', true );
		?>
        <div class="book-meta-sec">
        <ul>
            <li>
            	<label for="book_meta_price">Price</label>
            	<input type="number" name="book_meta_price" id="book_meta_price" value="<?php echo $book_price; ?>" />
            </li>
            <li>
            	<label for="book_meta_rating">Rating</label>
                <select name="book_meta_rating" id="book_meta_rating">                	
                    <option value="1" <?php selected( $book_rating, '1' ); ?>>1</option>
                    <option value="2" <?php selected( $book_rating, '2' ); ?>>2</option>
                    <option value="3" <?php selected( $book_rating, '3' ); ?>>3</option>
                    <option value="4" <?php selected( $book_rating, '4' ); ?>>4</option>
                    <option value="5" <?php selected( $book_rating, '5' ); ?>>5</option>
                </select>
            </li>
        </div>
        <?php
	}	
	
	
	/**
	* Save the books meta values
	*/
	public function lbs_book_save_meta_boxes($post_id){		
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		 
		if( !isset( $_POST['book_meta_box_nonce_val'] ) || !wp_verify_nonce( $_POST['book_meta_box_nonce_val'], 'book_meta_box_nonce' ) ) return;
		 
		if( !current_user_can( 'edit_post' ) ) return;

		$book_price = intval(sanitize_text_field( $_POST['book_meta_price'] ));
		$book_rating = intval(sanitize_text_field( $_POST['book_meta_rating'] ));
		
		if(empty($book_price)){
			$book_price = 0;
		}
		if(empty($book_rating)){
			$book_rating = 1;
		}
		
		update_post_meta( $post_id, 'book_price', $book_price );
		update_post_meta( $post_id, 'book_rating', $book_rating );
	}
	
}
