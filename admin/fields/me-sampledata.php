<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Sampledata {
    function __construct( $args, $options ) {
    }
    function render() {
        wp_nonce_field('marketengine-setup');
        $is_added_sample_data  = get_option('me-added-sample-data')
    ?>
        <form id="add-sample-data" <?php if($is_added_sample_data) echo 'style="display:none;"' ?>>
            <h3><?php _e("Sample Data", "enginethemes"); ?></h3>
            <div class="me-setup-sample">
                <p><?php _e("You can add some sample data to grasp some clearer ideas of how your marketplace will look like.<br>Some sample listings will be generated in each of your categories, together with a few users &amp; orders to demonstrate the checkout flows.<br>You will be able to remove those samples with another click later.", "enginethemes"); ?></p>
                <label class="me-setup-data-btn" id="me-add-sample-data" for="me-setup-sample-data">
                    <span id="me-setup-sample-data"><?php _e("ADD SAMPLE DATA", "enginethemes"); ?></span>
                </label>
            </div>
            <div class="me-setup-sample-finish">
                <p>Few users, orders and some sample listings have already been generated in each of your categories.</p>
                <p>You will be able to remove those samples with another click later.</p>
            </div>
        </form>
        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $('#me-add-sample-data').on('click', function(event) {
                        var $target = $(event.currentTarget);
                        var count = 1;
                        for (var i = 1; i <= 12; i++) {
                            $.ajax({
                                type: 'post',
                                url: me_globals.ajaxurl,
                                data: {
                                    action: 'me-add-sample-data',
                                    number : i,
                                    _wpnonce: $('#_wpnonce').val()
                                },
                                beforeSend: function() {
                                    
                                },
                                success: function(res, xhr) {
                                    count ++;
                                    if(count == i) {
                                        $('#add-sample-data').hide();
                                        $('#remove-sample-data').show();
                                    }
                                }
                            });
                        };
                        setTimeout(function(){
                            $('#add-sample-data').hide();
                            $('#remove-sample-data').show();
                        }, 45000);
                    });
                });
            })(jQuery)
        </script>
        <form id="remove-sample-data" <?php if(!$is_added_sample_data) echo 'style="display:none;"' ?>>
            <h3>Sample Data</h3>
            <div class="me-setup-sample-finish">
                <p>Few users, orders and some sample listings have already been generated in each of your categories.</p>
                <p>You will be able to remove those samples with another click later.</p>
                <label class="me-setup-data-btn" id="me-add-sample-data" for="me-setup-sample-data">
                    <span id="me-remove-sample-data">REMOVE SAMPLE DATA</span>
                </label>
            </div>
        </form>
        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $('#me-remove-sample-data').on('click', function(event) {
                        var $target = $(event.currentTarget);
                        var count = 1;
                        
                        $.ajax({
                            type: 'post',
                            url: me_globals.ajaxurl,
                            data: {
                                action: 'me-remove-sample-data',
                                _wpnonce: $('#_wpnonce').val()
                            },
                            beforeSend: function() {
                                
                            },
                            success: function(res, xhr) {
                                $('#remove-sample-data').hide();
                                $('#add-sample-data').show();
                            }
                        });
                    });
                });
            })(jQuery)
        </script>
    <?php 
    }
}
