<?php

return [
    'section' => [
        'actions' => [
            'export' => [
                'title' => 'Exportar',
            ],
            'changeConnection' => [
                'title' => 'Alterar conexão',
                'warning' => 'Escolha uma conexão',
            ],
            'changeMime' => [
                'title' => 'Alterar MIME',
                'warning' => 'Escolha um MIME',
            ],
            'format' => [
                'title' => 'Formatar',
                'warning' => 'Falha ao formatar',
            ],
            'mountSelect' => [
                'title' => 'Montar SELECT',
                'warning' => 'Informe um SQL',
                'useOnSelect' => 'Usar no SELECT',
            ],
            'check' => [
                'title' => 'Verificar',
                'warning' => 'Informe um SQL',
            ],
        ],
        'notifications' => [
            'export' => [
                'error' => [
                    'title' => 'Erro ao exportar',
                    'body' => 'Revise o SQL e tente novamente.'
                ],
                'success' => [
                    'title' => 'Exportado com sucesso',
                    'body' => 'Clique no botão abaixo para baixar o arquivo.'
                ],
                'warning' => [
                    'title' => 'Informe um SQL',
                ],
            ],
            'mountSelect' => [
                'error' => [
                    'title' => 'Erro ao montar SELECT',
                    'body' => 'Informe um SQL e tente novamente.'
                ],
                'success' => [
                    'title' => 'SELECT montado com sucesso',
                    'body' => 'Clique no botão abaixo para executar o SQL.'
                ],
                'warning' => [
                    'title' => 'Preencha os campos corretamente',
                ],
            ],
        ],
    ],
    'field' => [
        'tooltip' => [
            'text' => "F11: Tela cheia | Ctrl + Espaço: Preenchimento automático | ESC: Sair do modo Tela cheia"
        ],
        'label' => [
            'text' => 'SQL',
        ],
        'notifications' => [
            'check' => [
                'error' => [
                    'title' => 'Erro ao verificar',
                    'body' => 'Informe um SQL e tente novamente.'
                ],
                'success' => [
                    'title' => 'Verificado com sucesso',
                    'body' => 'Clique no botão abaixo para executar o SQL.'
                ],
                'warning' => [
                    'title' => 'Informe um SQL',
                ],
            ],
            'format' => [
                'error' => [
                    'title' => 'Erro ao formatar',
                    'body' => 'Informe um SQL e tente novamente.'
                ],
                'success' => [
                    'title' => 'Formatado com sucesso',
                    'body' => 'Clique no botão abaixo para copiar o SQL formatado.'
                ],
                'warning' => [
                    'title' => 'Informe um SQL',
                ],
            ],
            'tables' => [
                'error' => [
                    'title' => 'Erro ao obter tabelas',
                    'body' => 'Informe um SQL e tente novamente.'
                ],
                'success' => [
                    'title' => 'Tabelas obtidas com sucesso',
                    'body' => 'Clique no botão abaixo para exibir as tabelas.'
                ],
                'warning' => [
                    'title' => 'Informe um SQL',
                ],
            ],
            'mime' => [
                'error' => [
                    'title' => 'Erro ao alterar MIME',
                    'body' => 'Escolha um MIME e tente novamente.'
                ],
                'success' => [
                    'title' => 'MIME alterado com sucesso',
                    'body' => 'O MIME foi alterado.'
                ],
                'warning' => [
                    'title' => 'Escolha um MIME',
                ],
            ],
        ],
    ]
];
