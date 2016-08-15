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
        $widget_ops = array('classname' => 'me-price-filter', 'description' => __("A price filter for listing archive", "enginethemes"));
        parent::__construct('me-price-filter', __("MarketEngine Price Filter", "enginethemes"), $widget_ops);
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
        global $wp;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Price filter', 'enginethemes') : $instance['title'], $instance, $this->id_base);

        echo $args['before_widget'];
        
        if ( '' === get_option( 'permalink_structure' ) ) {
            $form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
        }

        ?>
        <form method="get" action="<?php echo $form_action; ?>">

            <h2 class="widget-title"><?php echo $title; ?></h2>
            
            <div id="me-range-price" min="1" max="500" step="1"></div>
            <div class="me-row">
                <div class="me-col-xs-4 me-range-dash"><input class="me-range-price me-range-min" type="number" name="price-min" value=""><span>-</span></div>
                <div class="me-col-xs-4 "><input class="me-range-price me-range-max" type="number" name="price-max" value=""></div>
                <div class="me-col-xs-4">
                    <input class="me-filter-btn" type="submit" value="<?php _e("Filter", "enginethemes"); ?>">
                </div>
            </div>
            
            <?php if(!empty($_GET['orderby'])) : ?>
                <input type="hidden" name="orderby" value="<?php echo $_GET['orderby'];  ?>" ?>
            <?php  endif; ?>
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