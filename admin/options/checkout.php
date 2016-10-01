<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'general'      => array(
        'title'    => __("General", "enginethemes"),
        'slug'     => 'general',
        'type'     => 'section',
        'template' => array(
            'haha' => array(
                'label'       => __("General 1", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'haha',
                'type'        => 'textbox',
                'name'        => 'me-textbox',
                'template'    => array(),
            ),
            'me-textarea' => array(
                'label'       => __("ME TextArea", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'me-textarea',
                'type'        => 'textarea',
                'name'        => 'me-textarea',
                'template'    => array(),
            ),
            'me-switch-default' => array(
                'label'       => __("ME Switch", "enginethemes"),
                'description' => __("Enable is default selection", "enginethemes"),
                'slug'        => 'me-switch-default',
                'type'        => 'switch',
                'name'        => 'me-switch-default',
                'template'    => array(),
            ),
            'me-switch-optional' => array(
                'label'       => __("ME Switch", "enginethemes"),
                'description' => __("Disable is default selection", "enginethemes"),
                'slug'        => 'me-switch-optional',
                'type'        => 'switch',
                'name'        => 'me-switch-optional',
                'template'    => array(),
            ),
            'me-translate' => array(
                'label'       => __("ME Translate", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'me-translate',
                'type'        => 'translate',
                'name'        => 'me-translate',
                'options'     => array(
                    'language-1'    => 'English',
                    'language-2'    => 'Vietnamese'
                ),
                'template'    => array(
                    'language-1'   => array(
                        'label'       => __("English", "enginethemes"),
                        'name'        => 'language-1',
                        'translate'   => array(
                            'Text #1'   => '',
                            'Text #2'   => 'English',
                        ),
                    ),
                    'language-2' => array(
                        'label'       => __("Vietnamese", "enginethemes"),
                        'name'        => 'language-2',
                        'translate'   => array(
                            'Text #1'   => 'Vietnamese',
                            'Text #2'   => '',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'authenticate' => array(
        'title'    => __("Authentication", "enginethemes"),
        'slug'     => 'authenticate',
        'type'     => 'section',
        'template' => array(
            'me-radio' => array(
                'label'       => __("ME Radio", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'me-radio',
                'type'        => 'radio',
                'data'        => array('Option #1', 'Option #2', 'Option #3'),
                'name'        => 'me-radio',
                'template'    => array(),
            ),
            'me-multi-field' => array(
                'label'       => __("ME Multi field", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'me-multi-field',
                'type'        => 'multi_field',
                'template'    => array(
                    'child-textbox' => array(
                        'label'       => __("Child Textbox", "enginethemes"),
                        'description' => __("The facebook authentication public api key", "enginethemes"),
                        'slug'        => 'child-textbox',
                        'type'        => 'textbox',
                        'name'        => 'child-textbox',
                        'template'    => array(),
                    ),
                    'child-switch' => array(
                        'label'       => __("Child Switch", "enginethemes"),
                        'description' => __("The facebook authentication public api key", "enginethemes"),
                        'slug'        => 'child-switch',
                        'type'        => 'switch',
                        'name'        => 'child-switch',
                        'template'    => array(),
                    ),
                    'child-radio' => array(
                        'label'       => __("Child Radio", "enginethemes"),
                        'description' => __("The facebook authentication public api key", "enginethemes"),
                        'slug'        => 'child-radio',
                        'type'        => 'radio',
                        'data'        => array('Option #1', 'Option #2', 'Option #3'),
                        'name'        => 'child-radio',
                        'template'    => array(),
                    ),
                ),
            ),
            'me-image' => array(
                'label'       => __("ME Image", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'me-image',
                'type'        => 'image',
                'gallery'     => array(
                    'image-1'   => array(
                        'attach_id' => 11,
                        'src'       => 'some-image.png',
                    ),
                    'image-2'   => array(
                        'attach_id' => 12,
                        'src'       => 'some-image.png',
                        'alt'       => 'alternate text'
                    ),
                ),
                'template'    => array(),
            ),
        ),
    ),
);