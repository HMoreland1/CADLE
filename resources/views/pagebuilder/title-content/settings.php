<?php

return [
    'id' => 'title-content',
    'name' => __('Title and Text with Alignment'),
    'icon' => '<i class="icon-credit-card"></i>',
    'tab' => "Common",
    'fields' => [
        [
            'id'            => 'title',
            'type'          => 'text',
            'value'         => 'Enter Your Title Here',
            'class'         => '',
            'label_title'   => __('Title'),
            'placeholder'   => __('Title'),
        ],
        [
            'id'            => 'content',
            'type'          => 'editor',
            'class'         => '',
            'value'         => 'Enter Your Content Here',
            'label_title'   => __('Content'),
            'placeholder'   => __('Content'),
        ],
        [
            'id'            => 'alignment',
            'type'          => 'select',
            'label_title'   => __('Alignment'),
            'value'         => 'left', // Default alignment
            'options'       => [
                'left'      => __('Left'),
                'center'    => __('Center'),
                'right'     => __('Right'),
            ],
        ],
    ]
];


