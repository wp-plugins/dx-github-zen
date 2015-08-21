<?php
/**
 * The GitHub Zen widget
 * 
 * A widget displaying a random GitHub Zen message from https://api.github.com/zen
 * 
 * @author nofearinc
 *
 */
class DX_GitHub_Zen_Widget extends WP_Widget {

    /**
     * Register the widget
     */
    public function __construct() {
        parent::__construct(
            'dx_zen_widget',
            __("DX GitHub Zen Widget", 'dxgz'),
            array( 'classname' => 'dx_zen_widget_sample_single', 'description' => __( "Display a GitHub Zen Widget", 'dxgz' ) ),
            array( ) // you can pass width/height as parameters with values here
        );
    }

    /**
     * Output of widget
     * 
     * The $args array holds a number of arguments passed to the widget 
     */
    public function widget ( $args, $instance ) {
        extract( $args );

        // Get widget field values
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        $before_zen = apply_filters( 'dx_before_zen', $instance[ 'before_zen' ] );
        $after_zen = apply_filters( 'dx_after_zen', $instance[ 'after_zen' ] );
        $timeout =  $instance[ 'timeout' ];
        
        // Don't use timeouts for less than 5min to avoid API blockage
        // 60req/min could theoretically handle 1min refreshes but just in case
        $timeout = (int) $timeout;
        if( $timeout < 5 ) {
        	$timeout = 5;
        }
        
        // This filter could handle the rest.
        $timeout = apply_filters( 'dx_widget_timeout', $timeout );
        
        // Get Zen message
        $zen_message_object = new DX_GitHub_Zen_Message( $timeout );
        $zen_message = $zen_message_object->get_zen_message();

        // Start sample widget body creation with output code (get arguments from options and output something)
        
		$out = $before_zen.  $zen_message . $after_zen;
		
		$out = apply_filters( 'dx_zen_message_output', $out );
        
        // End sample widget body creation
        
        if ( !empty( $out ) ) {
        	echo $before_widget;
        	if ( $title ) {
        		echo $before_title . $title . $after_title;
        	}
        	?>
        		<div>
        			<?php echo $out; ?>
        		</div>
        	<?php
        		echo $after_widget;
        }
    }

    /**
     * Updates the new instance when widget is updated in admin
     *
     * @return array $instance new instance after update
     */
    public function update ( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['timeout'] = strip_tags($new_instance['timeout']);
        // Still considering a wp_kses here, but most tags make sense to me
        $instance['before_zen'] = $new_instance['before_zen'];
        $instance['after_zen'] = $new_instance['after_zen'];
        
        return $instance;
    }

    /**
     * Widget Form
     */
    public function form ( $instance ) {
		$instance_defaults = array(
				'title' => 'GitHub Zen',
				'timeout' => '20',
				'before_zen' => '<p>',
				'after_zen' => '</p>'
		);

		$instance = wp_parse_args( $instance, $instance_defaults );

        $title = esc_attr( $instance[ 'title' ] );
        $timeout = esc_attr( $instance[ 'timeout' ] );
        $before_zen = $instance['before_zen'];
        $after_zen = $instance['after_zen'];
        
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( "Title:", 'dxgz'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('timeout'); ?>"><?php _e( "Timeout (keep it above 15):", 'dxgz'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('timeout'); ?>" name="<?php echo $this->get_field_name('timeout'); ?>" type="text" value="<?php echo $timeout; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('before_zen'); ?>"><?php _e( "Content before the message:", 'dxgz'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('before_zen'); ?>" name="<?php echo $this->get_field_name('before_zen'); ?>" type="text" value="<?php echo $before_zen; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('after_zen'); ?>"><?php _e( "Content after the message:", 'dxgz'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('after_zen'); ?>" name="<?php echo $this->get_field_name('after_zen'); ?>" type="text" value="<?php echo $after_zen; ?>" /></p>
	<?php
    }
}

add_action( 'widgets_init', 'dx_github_zen_register_widget' );

function dx_github_zen_register_widget() {
	// Register the widget for use
	register_widget('DX_GitHub_Zen_Widget');	
}
