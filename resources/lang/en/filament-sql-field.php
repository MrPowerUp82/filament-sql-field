<?php

return [
    'section' => [
        'actions' => [
            'export' => [
                'title' => 'Export',
            ],
            'changeConnection' => [
                'title' => 'Change connection',
                'warning' => 'Choose a connection',
            ],
            'changeMime' => [
                'title' => 'Change MIME',
                'warning' => 'Choose a MIME',
            ],
            'format' => [
                'title' => 'Format',
                'warning' => 'Failed to format',
            ],
            'mountSelect' => [
                'title' => 'Mount SELECT',
                'warning' => 'Provide an SQL',
                'useOnSelect' => 'Use on SELECT',
            ],
            'check' => [
                'title' => 'Check',
                'warning' => 'Provide an SQL',
            ],
        ],
        'notifications' => [
            'export' => [
                'error' => [
                    'title' => 'Error during export',
                    'body' => 'Review the SQL and try again.'
                ],
                'success' => [
                    'title' => 'Exported successfully',
                    'body' => 'Click the button below to download the file.'
                ],
                'warning' => [
                    'title' => 'Provide an SQL',
                ],
            ],
            'mountSelect' => [
                'error' => [
                    'title' => 'Error during mount SELECT',
                    'body' => 'Provide an SQL and try again.'
                ],
                'success' => [
                    'title' => 'SELECT mounted successfully',
                    'body' => 'Click the button below to run the SQL.'
                ],
                'warning' => [
                    'title' => 'Fill in the fields correctly',
                ]
            ],
        ],
    ],
    'field' => [
        'tooltip' => [
            'text' => "F11: Fullscreen | Ctrl + Space: Autocomplete | ESC: Exit Fullscreen mode"
        ],
        'label' => [
            'text' => 'SQL',
        ],
        'notifications' => [
            'check' => [
                'error' => [
                    'title' => 'Error during check',
                    'body' => 'Provide an SQL and try again.'
                ],
                'success' => [
                    'title' => 'Checked successfully',
                    'body' => 'The SQL is correct.'
                ],
                'warning' => [
                    'title' => 'Provide an SQL',
                ],
            ],
            'format' => [
                'error' => [
                    'title' => 'Error during format',
                    'body' => 'Provide an SQL and try again.'
                ],
                'success' => [
                    'title' => 'Formatted successfully',
                    'body' => 'The SQL is formatted.'
                ],
                'warning' => [
                    'title' => 'Provide an SQL',
                ],
            ],
            'tables' => [
                'error' => [
                    'title' => 'Error during get tables',
                    'body' => 'Provide an SQL and try again.'
                ],
                'success' => [
                    'title' => 'Tables fetched successfully',
                    'body' => 'The tables are fetched.'
                ],
                'warning' => [
                    'title' => 'Provide an SQL',
                ],
            ],
            'mime' => [
                'error' => [
                    'title' => 'Error during change MIME',
                    'body' => 'Choose a MIME and try again.'
                ],
                'success' => [
                    'title' => 'MIME changed successfully',
                    'body' => 'The MIME is changed.'
                ],
                'warning' => [
                    'title' => 'Choose a MIME',
                ],
            ],
        ],
    ]
];
