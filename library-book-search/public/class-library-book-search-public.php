<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/kishanvadaliya/
 * @since      1.0.0
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Library_Book_Search
 * @subpackage Library_Book_Search/public
 * @author     Kishan Vadaliya <kishanvadaliya2011@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Library_Book_Search_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library-book-search-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'lbs_price_range_style', plugin_dir_url( __FILE__ ) . 'css/lbs_price_range_style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library-book-search-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'lbs_price_range_script', plugin_dir_url( __FILE__ ) . 'js/lbs_price_range_script.js', array( 'jquery' ), $this->version, false );

	}
	
	/*
	* Book search form shortcode with its result
	*/
	public function lbs_book_form_shortcode(){
		add_shortcode('library_book_search', array($this,'lbs_library_book_search_form_shortcode'));
		
	}
	
	public function lbs_library_book_search_form_shortcode(){
		?>
		<div class="lbs-book-search-sec">
        	<div class="lbs-book-search-form-sec">
        		<h3 class="form-title"><?php echo __('Book Search','library-book-search'); ?></h3>
                <form class="lbs-book-search-form" name="lbs-book-search-form" id="lbs-book-search-form" action="" method="POST">
                	<div class="form-row">
                    	<div class="form-col6">
                        	<label><?php echo __('Book Name:','library-book-search'); ?></label>
                            <div class="form-field">
                            <input type="text" name="lbs_book_name" value="" />
                            </div>
                        </div>
                        <div class="form-col6">
                        	<label><?php echo __('Author:','library-book-search'); ?></label>
                            <div class="form-field">
                            <input type="text" name="lbs_book_author" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="form-col6">
                        	<label><?php echo __('Publisher:','library-book-search'); ?></label>
                            <div class="form-field">
                            <?php
							$pub_arg = array(
								'taxonomy' => 'book_publisher',
								'hide_empty' => true,
								'orderby' => 'name',
								'order' => 'ASC',
								'number' => false
							);
							$publisher_vals = get_terms($pub_arg);
							
							$input_min_price = 1;
							$input_max_price = 500;
							
							// get the min price for price range slider							
							$arg_min_price = array(
								'post_type' => 'books',
								'posts_per_page' => 1,
								'post_status' => 'publish',
								'meta_key' => 'book_price',
								'orderby' => 'meta_value_num',
								'order' => 'ASC'
							);
							$book_posts_min_price = new WP_Query($arg_min_price);							
							if($book_posts_min_price->have_posts()){
								while ($book_posts_min_price->have_posts()){ 
									$book_posts_min_price->the_post();
									$input_min_price = get_post_meta(get_the_ID(),'book_price',TRUE);
								}
							}
							wp_reset_query();
							
							
							// get the max price for price range slider
							$arg_max_price = array(
								'post_type' => 'books',
								'posts_per_page' => 1,
								'post_status' => 'publish',
								'meta_key' => 'book_price',
								'orderby' => 'meta_value_num',
								'order' => 'DESC'
							);
							$book_posts_max_price = new WP_Query($arg_max_price);							
							if($book_posts_max_price->have_posts()){
								while ($book_posts_max_price->have_posts()){ 
									$book_posts_max_price->the_post();
									$input_max_price = get_post_meta(get_the_ID(),'book_price',TRUE);
								}
							}
							wp_reset_query();
							
							
							?>
                            <select name="lbs_book_publisher">
                            	<option value=""><?php echo __('Select Publisher','library-book-search'); ?></option>
                                <?php 
								if(!empty($publisher_vals)){
									foreach($publisher_vals as $publisher_val)
									{	
									?>
                            		<option value="<?php echo $publisher_val->term_id; ?>"><?php echo $publisher_val->name; ?></option>
                                <?php
									}
								}
								?>
                            </select>
                            </div>
                        </div>
                        <div class="form-col6">
                        	<label><?php echo __('Rating:','library-book-search'); ?></label>
                            <div class="form-field">
                            <select name="lbs_book_rating">
                            	<option value=""><?php echo __('Select Rating','library-book-search'); ?></option>
                            	<option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="form-col6">
                        	<label><?php echo __('Price:','library-book-search'); ?></label>
                            <div class="form-field">
                            <input type="hidden" name="lbs_book_price_min" id="lbs_book_price_min" value="" />
                            <input type="hidden" name="lbs_book_price_max" id="lbs_book_price_max" value="" />
                            
                            <div class="book-price-slider-range-outer">
                            	<div id="book-price-amount"></div>
                            	<div id="book-price-slider-range"></div>
                            </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-row form-submit-btn">
                    	<div class="form-col12">                        	
                            <input type="submit" value="<?php echo __('Search','library-book-search'); ?>" />
                        </div>                        
                    </div>
                    <?php wp_nonce_field('lbs_book_seach_nonce','book-search-nonce-val'); ?>
                </form>
        	<div class="lbs-book-loader"></div>
            </div>
        	
            <?php
			//No. of page  - Pagination			
			$default_posts_per_page = get_option( 'posts_per_page' );
			$current_page = 1;
			$arg_pagi = array(
				'post_type' => 'books',
				'posts_per_page' => -1,
				'post_status' => 'publish'
			);
			$book_posts_pagi = new WP_Query($arg_pagi);
			$total_no_of_posts = $book_posts_pagi->post_count;
			wp_reset_query();
			
			
			$arg = array(
				'post_type' => 'books',
				'posts_per_page' => $default_posts_per_page,
				'post_status' => 'publish',
				'paged'	=> $current_page,
			);						
			$book_posts = new WP_Query($arg);
			?>
			<div class="lbs-book-search-result">
            	<div class="book-result-header">
                	<ul>
                    <li class="b_no"><?php echo __('No','library-book-search'); ?></li>
                    <li class="b_name"><?php echo __('Book Name','library-book-search'); ?></li>
                    <li class="b_price"><?php echo __('Price','library-book-search'); ?></li>
                    <li class="b_author"><?php echo __('Author','library-book-search'); ?></li>
                    <li class="b_publisher"><?php echo __('Publisher','library-book-search'); ?></li>
                    <li class="b_rating"><?php echo __('Rating','library-book-search'); ?></li>
                    </ul>
                </div>
			<div class="book-result-body-outer">
			<?php
			if($book_posts->have_posts()){
				?>
                <div class="book-result-body">
                <?php
				$b_no = (($current_page-1)*$default_posts_per_page);
				while ($book_posts->have_posts()){ 
					$book_posts->the_post();
					$b_no++;
					//	var_dump(get_the_ID());
					?>
					<div class="book-result-item">
                        <ul>
                        <li class="b_no"><?php echo $b_no; ?></li>
                        <li class="b_name"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                        <li class="b_price">$<?php echo get_post_meta(get_the_ID(),'book_price', true); ?></li>
                        <li class="b_author"><?php 
								$b_authors = wp_get_post_terms(get_the_ID(),'book_author');								
								if(!empty($b_authors)){
									foreach($b_authors as $b_author){
										echo $b_author->name;
									}
								}
							?></li>
                        <li class="b_publisher"><?php 
								$b_publishers = wp_get_post_terms(get_the_ID(),'book_publisher');								
								if(!empty($b_publishers)){
									foreach($b_publishers as $b_publisher){
										echo $b_publisher->name;
									}
								}
							?></li>
                        <li class="b_rating"><span class="rating-star-<?php echo get_post_meta(get_the_ID(),'book_rating', true); ?>"></span></li>
                        </ul>
                    </div>
					<?php
				}
				?>
                </div>
                
                
                
                
                
                <?php
				// custom pagination
				$pagination_info = array();
				$pagination_info['total_pages'] = ceil($total_no_of_posts/$default_posts_per_page);//$no_of_page;
				$pagination_info['curr_page'] = $current_page;
		
				if($pagination_info['total_pages']>1){			
					echo '<div class="pagination-sec">';
						echo '<ul>';
							//If the current page is more than 1, show the First and Previous links
							if($pagination_info['curr_page'] > 1){
								echo '<li class="extra-page first-page"><span page_no="1">First</span></li>';
								echo '<li class="extra-page first-page"><span page_no="'.($pagination_info['curr_page'] - 1).'">Prev</span></li>';						
							}		
							
							//$max_pages is equal to number of links shown
							$max_pages = 5;
							if($pagination_info['curr_page'] < $max_pages)
								$sp = 1;
							elseif($pagination_info['curr_page'] >= ($pagination_info['total_pages'] - floor($max_pages / 2)) )
								$sp = $pagination_info['total_pages'] - $max_pages + 1;
							elseif($pagination_info['curr_page'] >= $max_pages)
								$sp = $pagination_info['curr_page']  - floor($max_pages/2);
							
							
							//Loop though max_pages number of pages shown and show links either side equal to $max_pages / 2				
							for($i = $sp; $i <= ($sp + $max_pages -1); $i++){
								if($i > $pagination_info['total_pages']){
									continue;
								}
								if($pagination_info['curr_page'] == $i){
								   echo '<li class="active"><span page_no="'.$i.'">'.$i.'</span></li>';
								}
								else{
									echo '<li><span page_no="'.$i.'">'.$i.'</span></li>';
								}
							}
			
							//Show last two pages if we're not near them    
							if($pagination_info['curr_page'] < $pagination_info['total_pages']){      
								echo '<li class="extra-page last-page"><span page_no="'.($pagination_info["curr_page"]+1).'">Next</span></li>';						
								echo '<li class="extra-page last-page"><span page_no="'.$pagination_info["total_pages"].'">Last</span></li>';
							}
						echo '</ul>';
					echo '</div>';
				} // END custom pagination				
				?>
                
                
                <?php
			}
			else{
				echo '<div class="no-book">'.__('No more books', 'lbs_book_seach_nonce').'</div>';
			}
			wp_reset_query();
			
			?>
            </div>
            </div>
        </div>
    
        <script type="text/javascript">
			jQuery(document).ready(function($) {
                var addprotocolPath = '<?php echo admin_url('admin-ajax.php'); ?>';
				var book_search_form_data = jQuery('#lbs-book-search-form').serialize();
				
				jQuery('#lbs-book-search-form').submit(function(e) {
					e.preventDefault();
					book_search_form_data = jQuery('#lbs-book-search-form').serialize();
					
					jQuery('.lbs-book-search-form-sec .lbs-book-loader').show();
					jQuery.ajax({
						url: addprotocolPath,
						data: 'action=book_search_ajax&'+book_search_form_data+'&b_paged=1',
						type:'post',
						beforeSend: function(bs){
						},
						success: function(s_msg){
							//alert(s_msg);
							jQuery('.book-result-body-outer').html(s_msg);
							jQuery('.lbs-book-search-form-sec .lbs-book-loader').hide();
							pagination_ajax_fn();
						},
						error: function(er){							
							jQuery('.book-result-body-outer').html('Error: '+er);
							jQuery('.lbs-book-search-form-sec .lbs-book-loader').hide();
						}
					});
				});
				
				function pagination_ajax_fn(){
				jQuery('.lbs-book-search-sec .pagination-sec ul li span').click(function(e) {
					e.preventDefault();
					var curr_page = jQuery(this).attr('page_no');
					jQuery('.lbs-book-search-form-sec .lbs-book-loader').show();
					jQuery.ajax({
						url: addprotocolPath,
						data: 'action=book_search_ajax&'+book_search_form_data+'&b_paged='+curr_page,
						type:'post',
						beforeSend: function(bs){
						},
						success: function(s_msg){
							//alert(s_msg);
							jQuery('.book-result-body-outer').html(s_msg);
							jQuery('.lbs-book-search-form-sec .lbs-book-loader').hide();
							pagination_ajax_fn();
						},
						error: function(er){
							jQuery('.book-result-body-outer').html('Error: '+er);
							jQuery('.lbs-book-search-form-sec .lbs-book-loader').hide();
						}
					});
				});
				}
				pagination_ajax_fn();
				
				jQuery( function() {
					jQuery( "#book-price-slider-range" ).slider({
						range: true,
						min: <?php echo $input_min_price; ?>,
						max: <?php echo $input_max_price; ?>,
						values: [ <?php echo $input_min_price; ?>, <?php echo $input_max_price; ?> ],
						slide: function( event, ui ) {
							//$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );							
							$( "#lbs_book_price_min" ).val(ui.values[ 0 ]);			
							$( "#lbs_book_price_max" ).val(ui.values[ 1 ]);
							$( "#book-price-amount" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
						}
					});
					$( "#lbs_book_price_min" ).val($( "#book-price-slider-range" ).slider( "values", 0 ));			
					$( "#lbs_book_price_max" ).val($( "#book-price-slider-range" ).slider( "values", 1 ));
					
					$( "#book-price-amount" ).html( "$" + $( "#book-price-slider-range" ).slider( "values", 0 ) + " - $" + $( "#book-price-slider-range" ).slider( "values", 1 ) );
					
				});
				
            });
		
		</script>
        
        <?php
	}
	
	
	
	/*
	* result based on AJAX
	*/
	public function book_search_ajax_result(){
		$b_name = sanitize_text_field($_POST['lbs_book_name']);
		$b_author_name = sanitize_text_field($_POST['lbs_book_author']);
		$b_author_id = '';
		$b_publisher = $_POST['lbs_book_publisher'];
		$b_rating = $_POST['lbs_book_rating'];
		$b_min_price = $_POST['lbs_book_price_min'];
		$b_max_price = $_POST['lbs_book_price_max'];
		$default_posts_per_page = get_option( 'posts_per_page' );
		$req_type = sanitize_text_field($_POST['req_type']);
		$current_page = sanitize_text_field($_POST['b_paged']);
		$default_posts_per_page = get_option( 'posts_per_page' );
			
		$author_obj = get_term_by('name', $b_author_name, book_author);
		if(!empty($author_obj)){
			$b_author_id = $author_obj->term_id;
		}
		elseif(!empty($b_author_name)){
			$b_author_id = -1;
		}
		
		$tax_qry_array = array();
		$meta_qry_array = array();
		
		if((isset($b_author_id) && !empty($b_author_id)) || (isset($b_publisher) && !empty($b_publisher))){
			$tax_qry_array['relation'] = 'AND';
		}
		if(isset($b_author_id) && !empty($b_author_id)){
			$tax_qry_array[] = array(
				'taxonomy' => 'book_author',
				'field' => 'id',
				'terms' => array($b_author_id),
				'operator' => 'IN'
			);
		}
		if(isset($b_publisher) && !empty($b_publisher)){
			$tax_qry_array[] = array(
				'taxonomy' => 'book_publisher',
				'field' => 'id',
				'terms' => array($b_publisher),
				'operator' => 'IN'
			);
		}
		
		if(isset($b_min_price) && !empty($b_min_price) && isset($b_max_price) && !empty($b_max_price)){
			$meta_qry_array[] = array(
				'key' => 'book_price',
				'value' => array($b_min_price,$b_max_price),
				'type' => 'NUMERIC',
				'compare' => 'BETWEEN',
			);
		}
		if(isset($b_rating) && !empty($b_rating)){
			$meta_qry_array[] = array(
				'key' => 'book_rating',
				'value' => $b_rating,
				'type' => 'NUMERIC',
				'compare' => '=',
			);
		}
		
		if(wp_verify_nonce($_POST['book-search-nonce-val'],'lbs_book_seach_nonce')){			
			
			//No. of page  - Pagination			
			$arg_pagi = array(
				'post_type' => 'books',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				's' => $b_name,
				'tax_query' => $tax_qry_array,
				'meta_query' => $meta_qry_array,
			);
			$book_posts_pagi = new WP_Query($arg_pagi);
			$total_no_of_posts = $book_posts_pagi->post_count;
			wp_reset_query();
			
			$arg = array(
				'post_type' => 'books',
				'posts_per_page' => $default_posts_per_page,
				'post_status' => 'publish',
				'paged'	=> $current_page,
				's' => $b_name,
				'tax_query' => $tax_qry_array,
				'meta_query' => $meta_qry_array,
			);		
			$book_posts = new WP_Query($arg);
			
			if($book_posts->have_posts()){
				
				echo '<div class="book-result-body">';
				
				$b_no = (($current_page-1)*$default_posts_per_page);
				
				while ($book_posts->have_posts()){ 
					$book_posts->the_post();
					$b_no++;					
					?>
					<div class="book-result-item">
                        <ul>
                        <li class="b_no"><?php echo $b_no; ?></li>
                        <li class="b_name"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
                        <li class="b_price">$<?php echo get_post_meta(get_the_ID(),'book_price', true); ?></li>
                        <li class="b_author"><?php 
								$b_authors = wp_get_post_terms(get_the_ID(),'book_author');								
								if(!empty($b_authors)){
									foreach($b_authors as $b_author){
										echo $b_author->name;
									}
								}
							?></li>
                        <li class="b_publisher"><?php 
								$b_publishers = wp_get_post_terms(get_the_ID(),'book_publisher');								
								if(!empty($b_publishers)){
									foreach($b_publishers as $b_publisher){
										echo $b_publisher->name;
									}
								}
							?></li>
                        <li class="b_rating"><span class="rating-star-<?php echo get_post_meta(get_the_ID(),'book_rating', true); ?>"></span></li>
                        </ul>
                    </div>
					<?php
				}
				
				echo '</div>';
				
			}
			else{
				echo '<div class="no-book">'.__('No more books', 'lbs_book_seach_nonce').'</div>';
			}
			
			
			
				// custom pagination
				$pagination_info = array();
				$pagination_info['total_pages'] = ceil($total_no_of_posts/$default_posts_per_page);//$no_of_page;
				$pagination_info['curr_page'] = $current_page;
		
				if($pagination_info['total_pages']>1){			
					echo '<div class="pagination-sec">';
						echo '<ul>';
							//If the current page is more than 1, show the First and Previous links
							if($pagination_info['curr_page'] > 1){
								echo '<li class="extra-page first-page"><span page_no="1">First</span></li>';
								echo '<li class="extra-page first-page"><span page_no="'.($pagination_info['curr_page'] - 1).'">Prev</span></li>';						
							}		
							
							//$max_pages is equal to number of links shown
							$max_pages = 5;
							if($pagination_info['curr_page'] < $max_pages)
								$sp = 1;
							elseif($pagination_info['curr_page'] >= ($pagination_info['total_pages'] - floor($max_pages / 2)) )
								$sp = $pagination_info['total_pages'] - $max_pages + 1;
							elseif($pagination_info['curr_page'] >= $max_pages)
								$sp = $pagination_info['curr_page']  - floor($max_pages/2);
							
							
							//Loop though max_pages number of pages shown and show links either side equal to $max_pages / 2				
							for($i = $sp; $i <= ($sp + $max_pages -1); $i++){
								if($i > $pagination_info['total_pages']){
									continue;
								}
								if($pagination_info['curr_page'] == $i){
								   echo '<li class="active"><span page_no="'.$i.'">'.$i.'</span></li>';
								}
								else{
									echo '<li><span page_no="'.$i.'">'.$i.'</span></li>';
								}
							}
			
							//Show last two pages if we're not near them    
							if($pagination_info['curr_page'] < $pagination_info['total_pages']){      
								echo '<li class="extra-page last-page"><span page_no="'.($pagination_info["curr_page"]+1).'">Next</span></li>';						
								echo '<li class="extra-page last-page"><span page_no="'.$pagination_info["total_pages"].'">Last</span></li>';
							}
						echo '</ul>';
					echo '</div>';
				} // END custom pagination				
			
		}
		else{
			echo 'Security check.';
		}
		exit;
	}
	
	// call the custom tempalte for book single page
	function book_single_page_template( $book_template ){
		if ( is_singular( 'books' ) ) {
			$book_template = dirname( __FILE__ ) . '\template\single-books.php';
		}
		if(is_archive() && get_queried_object()->name == "books"){
			$book_template = dirname( __FILE__ ) . '\template\archive-books.php';
		}
		if ( (is_tax()) && (get_queried_object()->taxonomy == "book_publisher" || get_queried_object()->taxonomy == "book_author" )) {
			$book_template = dirname( __FILE__ ) . '\template\taxonomy-books.php';
		}		
		return $book_template;
	}
	

}
