<?php 
/**
 * Adds lname_Widget widget.
 */
class lname_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'lname_widget', // Base ID
			esc_html__( 'Last Name Loop', 'lname_domain' ), // Name
			array( 'description' => esc_html__( 'Alphabetically order posts by last word in title', 'lname_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        // widget content output
        echo '<div class="row">';
        $instance['postsperpage'] = intval($instance['postsperpage']);
        $query = lnamequery($instance['postsperpage'], $instance['catslug']);
        if ($query) {
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post(); ?>
    
                    <div id="<?php echo $post->post_name; ?>" class="col-md-3">
                        <img src="<?php the_post_thumbnail_url() ?>" alt="">
                        <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                    </div>
                <?php 
                }
            } 
            wp_reset_postdata(); 
        }
        else {
            echo 'Query Failed!';
        }
        echo '</div>';
  
        
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Last Name Loop', 'lname_domain' );
        
        $order = ! empty( $instance['order'] ) ? $instance['order'] : esc_html__( 'ASC', 'lname_domain' );

        $postsperpage = ! empty( $instance['postsperpage'] ) ? $instance['postsperpage'] : esc_html__( '1', 'lname_domain' );

        $catslug = ! empty( $instance['catslug'] ) ? $instance['catslug'] : esc_html__( 'all', 'lname_domain' );
		?>

        <!-- Title -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_attr_e( 'Title:', 'lname_domain' ); ?>
            </label> 
            <input 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
                type="text" 
                value="<?php echo esc_attr( $title ); ?>">
		</p>

        <!-- Order -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
                <?php esc_attr_e( 'Order:', 'lname_domain' ); ?>
            </label> 
            <select 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" >
                <option value="ASC" <?php echo ($order == 'default') ? 'selected' : ''; ?>>
                    ASC
                </option>
                <option value="DESC" <?php echo ($order == 'DESC') ? 'selected' : ''; ?>>
                    DESC
                </option>
            </select>
		</p>

        <!-- Posts Per Page -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'postsperpage' ) ); ?>">
                <?php esc_attr_e( 'Posts Per Page:', 'lname_domain' ); ?>
            </label> 
            <input 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'postsperpage' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'postsperpage' ) ); ?>" 
                type="text" 
                value="<?php echo esc_attr( $postsperpage ); ?>">
		</p>

        <!-- Category Slug -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'catslug' ) ); ?>">
                <?php esc_attr_e( 'Category Slug:', 'lname_domain' ); ?>
            </label> 
            <input 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'catslug' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'catslug' ) ); ?>" 
                type="text" 
                value="<?php echo esc_attr( $catslug ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
        $instance = array();
        
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        
        $instance['order'] = ( ! empty( $new_instance['order'] ) ) ? sanitize_text_field( $new_instance['order'] ) : '';

        $instance['postsperpage'] = ( ! empty( $new_instance['postsperpage'] ) ) ? sanitize_text_field( $new_instance['postsperpage'] ) : '';

        $instance['catslug'] = ( ! empty( $new_instance['catslug'] ) ) ? sanitize_text_field( $new_instance['catslug'] ) : '';

		return $instance;
	}

} // class lname_Widget
?>