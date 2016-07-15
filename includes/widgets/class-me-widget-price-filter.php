<?php

if (!defined('ABSPATH')) {
    exit;
}


/**
 * MarketEngine Listing Categories Widget
 *
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @author EngineTeam
 * @since 1.0
 */
class ME_Widget_Price_Filter extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    public function ME_Widget_Price_Filter() {
        $widget_ops = array('classname' => 'me-price-filter', 'description' => __("MarketEngine Price Filter", "enginethemes"));
        parent::__construct('marketengine-price-filter', __("MarketEngine Price Filter", "enginethemes"), $widget_ops);
    }

    /**
     * Outputs the content for the current Listing Categories widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Categories widget instance.
     */
    public function widget($args, $instance) {
        static $first_dropdown = true;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Price filter', 'enginethemes') : $instance['title'], $instance, $this->id_base);

        $c = !empty($instance['count']) ? '1' : '0';
        $h = !empty($instance['hierarchical']) ? '1' : '0';
        $d = !empty($instance['dropdown']) ? '1' : '0';

        echo $args['before_widget'];
        
        ?>
        <form method="get">
            <h2 class="widget-title"><?php echo $title; ?></h2>
            
            <div id="me-range-price" min="1" max="500" step="1"></div>
            <div class="me-row">
                <div class="me-col-xs-5"><input class="me-range-price me-range-min" type="number" name="price-min" value=""></div>
                <div class="me-col-xs-2 "><span class="me-range-dash">-</span></div>
                <div class="me-col-xs-5"><input class="me-range-price me-range-max" type="number" name="price-max" value=""></div>
            </div>
            <div class="me-filter-button">
                <input class="me-filter-btn" type="submit" value="Filter">
                
            </div>
            
        </form>
        <?php

        echo $args['after_widget'];
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    public function form($instance) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = sanitize_text_field( $instance['title'] );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
    <?php
    }
}