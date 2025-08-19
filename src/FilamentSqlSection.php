<?php

namespace MrPowerUp\FilamentSqlField;

use Cache;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use MrPowerUp\FilamentSqlField\Traits\ReportProcessing;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Facades\DB;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Filament\Forms\Components\Grid;


class FilamentSqlSection extends Section
{
    use ReportProcessing;
    protected array $headerActions = [];
    public static function make($heading = null): static
    {
        $static = app(static::class, ['heading' => $heading]);
        $static->configure();
        return $static;
    }
    protected function setUp(): void
    {
        parent::setUp();
        $this->id('sqlSection');
        $this->headerActions([
            Action::make('exportHeader')
                ->form([
                    // Select::make('connection')
                    //     ->columnSpanFull()
                    //     ->required()
                    //     ->options(function () {
                    //         $data = [];
                    //         foreach (config('database.connections') as $key => $value) {
                    //             $data[$key] = $key;
                    //         }
                    //         return $data;
                    //     }),
                    Select::make('format')
                        ->columnSpanFull()
                        ->required()
                        ->options([
                            'json' => 'Json',
                            'xlsx' => 'Xlsx',
                            'csv' => 'Csv',
                        ])
                ])
                ->action(function (array $data): void {
                    if ($data['format']) {
                        $this->generateReport($data['format'], Cache::get('filament-sql-field::changeConnection')['connection']);
                        // $this->generateReport($data['format'], $data['connection']);
                    } else {
                        Notification::make()
                            ->title('Escolha um formato')
                            ->warning()
                            ->send();
                    }
                })
                ->label(__('filament-sql-field::filament-sql-field.section.actions.export.title')),

            Action::make('changeConnection')
                ->fillForm(Cache::get('filament-sql-field::changeConnection') ?? [])
                ->form([
                    Select::make('connection')
                        ->columnSpanFull()
                        ->required()
                        ->options(function () {
                            $data = [];
                            foreach (config('database.connections') as $key => $value) {
                                $data[$key] = $key;
                            }
                            return $data;
                        })
                ])
                ->action(function (array $data): void {
                    if ($data['connection']) {
                        // $this->childComponents[0]->connection($data['connection']);
                        $this->getChildComponents()[0]->connection($data['connection']);
                        $this->getChildComponents()[0]->autoGetTables();
                        $tables = json_decode($this->getChildComponents()[0]->getTables(), true);
                        $livewire = $this->getLivewire();
                        $livewire->dispatch('updatePlugin', $tables, 'tables');
                        Cache::forget('filament-sql-field::changeConnection');
                        Cache::rememberForever('filament-sql-field::changeConnection', function () use ($data) {
                            return $data;
                        });
                    } else {
                        Notification::make()
                            ->title(__('filament-sql-field::filament-sql-field.section.actions.changeConnection.warning'))
                            ->warning()
                            ->send();
                    }
                })
                ->color('info')
                ->label(__('filament-sql-field::filament-sql-field.section.actions.changeConnection.title')),

            Action::make('changeMime')
                ->fillForm(Cache::get('filament-sql-field::changeMime') ?? [])
                ->form([
                    Select::make('mime')
                        ->columnSpanFull()
                        ->required()
                        ->options([
                            'text/x-sql' => 'SQL',
                            'text/x-mysql' => 'MySQL',
                            'text/x-mariadb' => 'MariaDB',
                            'text/x-cassandra' => 'Cassandra',
                            'text/x-plsql' => 'PL/SQL',
                            'text/x-mssql' => 'MSSQL',
                            'text/x-hive' => 'Hive',
                            'text/x-pgsql' => 'PostgreSQL',
                            'text/x-gql' => 'GraphQL',
                            'text/x-gpsql' => 'Greenplum SQL',
                            'text/x-esper' => 'Esper',
                            'text/x-sqlite' => 'SQLite',
                            'text/x-sparksql' => 'Spark SQL',
                            'text/x-trino' => 'Trino',
                        ])
                ])
                ->action(function (array $data): void {
                    if ($data['mime']) {
                        $this->getChildComponents()[0]->mime($data['mime']);
                        $livewire = $this->getLivewire();
                        $livewire->dispatch('updatePlugin', $data['mime'], 'mime');
                        Cache::forget('filament-sql-field::changeMime');
                        Cache::rememberForever('filament-sql-field::changeMime', function () use ($data) {
                            return $data;
                        });
                    } else {
                        Notification::make()
                            ->title(__('filament-sql-field::filament-sql-field.section.actions.changeMime.warning'))
                            ->warning()
                            ->send();
                    }
                })
                ->color('info')
                ->label(__('filament-sql-field::filament-sql-field.section.actions.changeMime.title')),

            Action::make('format')
                ->action(function (array $data): void {
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', '', 'format');
                })
                ->color('info')
                ->label(__('filament-sql-field::filament-sql-field.section.actions.format.title')),

            Action::make('check')
                ->action(function (array $data): void {
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', '', 'check');
                })
                ->color('info')
                ->label(__('filament-sql-field::filament-sql-field.section.actions.check.title')),

            Action::make('schema')
                ->modalSubmitAction(false)
                ->modalContent(fn(): View => view(
                    'filament-sql-field::tables-modal',
                    [
                        'data' => json_decode($this->getChildComponents()[0]->getTables(), true)
                    ],
                ))
                ->color('info'),

            Action::make('mountSelect')
                ->fillForm(function () {
                    $changeConnection = Cache::get('filament-sql-field::changeConnection');
                    $connection = $changeConnection ? $changeConnection['connection'] : '';
                    $mountSelectData = Cache::get('filament-sql-field::mountSelect-' . $connection) ?? [];
                    return $mountSelectData;
                })
                ->form([
                    Select::make('table')
                        ->searchable()
                        ->options(function () {
                            $tables = json_decode($this->getChildComponents()[0]->getTables(), true);
                            $data = [];
                            foreach ($tables as $key => $value) {
                                $data[$key] = $key;
                            }
                            return $data;
                        })
                        ->live()
                        ->afterStateUpdated(fn(Select $component) => $component
                            ->getContainer()
                            ->getComponent('dynamicTypeFields')
                            ->getChildComponentContainer()
                            ->fill())
                        ->required(),
                    Grid::make(1)
                        ->schema(function (Get $get) {
                            $table = $get('table');
                            if (!$table) {
                                return [];
                            }
                            $columns = [];
                            foreach (json_decode($this->getChildComponents()[0]->getTables(), true)[$table] as $value) {
                                $columns[$value] = $value;
                            }
                            return [
                                Repeater::make('columns')
                                    ->collapsed()
                                    ->schema([
                                        Select::make('name')
                                            ->searchable()
                                            ->options($columns)
                                            ->key('dynamicTypeFields')
                                            ->required(),
                                        Select::make('operator')
                                            ->options([
                                                '=' => '=',
                                                '!=' => '!=',
                                                '>=' => '>=',
                                                '<=' => '<=',
                                                'LIKE' => 'LIKE',
                                                'LIKE %...%' => 'LIKE %...%',
                                                'NOT LIKE' => 'NOT LIKE',
                                                'NOT LIKE %...%' => 'NOT LIKE %...%',
                                                'IS NULL' => 'IS NULL',
                                                'IS NOT NULL' => 'IS NOT NULL',
                                                'BETWEEN' => 'BETWEEN',
                                            ]),
                                        TextInput::make('value'),
                                        ToggleButtons::make('useOnSelect')
                                            ->default(true)
                                            ->label(__('filament-sql-field::filament-sql-field.section.actions.mountSelect.useOnSelect'))
                                            ->boolean()
                                            ->grouped()
                                    ])
                                    ->itemLabel(fn(array $state): ?string => $state['name'] . ' ' . $state['operator'] . ' ' . $state['value'] ?? null)
                                    ->columns(4)
                            ];
                        })
                        ->key('dynamicTypeFields')

                ])
                ->action(function (array $data): void {
                    $table = $data['table'];
                    $columns = $data['columns'];
                    $query = "SELECT ";
                    $query .= implode(',', array_map(function ($item) {
                        if ($item['useOnSelect']){
                            return $item['name'];
                        }
                    }, $columns));
                    $query = trim($query, ',');
                    $query .= " FROM $table WHERE ";
                    $conditions = [];
                    foreach ($columns as $column) {
                        // if (!empty($column['operator']) && empty($column["value"])) {
                        //     Notification::make()
                        //         ->title(__('filament-sql-field::filament-sql-field.section.notifications.mountSelect.warning.title'))
                        //         ->warning()
                        //         ->send();
                        //     return;
                        // } 
                        if (!empty($column['operator'])) {
                            if ($column['operator'] == 'IS NOT NULL' || $column['operator'] == 'IS NULL') {
                                $conditions[] = $column['name'] . ' ' . $column['operator'];
                                continue;
                            }
                            if ($column['operator'] == 'LIKE %...%') {
                                $conditions[] = $column['name'] . ' ' . 'LIKE' . ' ' . "'%" . addslashes($column['value']) . "%'";
                                continue;
                            }
                            if ($column['operator'] == 'NOT LIKE %...%') {
                                $conditions[] = $column['name'] . ' ' . 'NOT LIKE' . ' ' . "'%" . addslashes($column['value']) . "%'";
                                continue;
                            }
                            $conditions[] = $column['name'] . ' ' . $column['operator'] . ' ' . "'" . addslashes($column['value']) . "'";
                        }
                    }
                    $query .= implode(' AND ', $conditions);
                    Notification::make()
                        ->title(__('filament-sql-field::filament-sql-field.section.notifications.mountSelect.success.title'))
                        ->success()
                        ->send();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', $query, 'value');
                    $livewire->dispatch('updatePlugin', '', 'format');
                    Cache::forget('filament-sql-field::mountSelect-' . Cache::get('filament-sql-field::changeConnection')['connection']);
                    Cache::rememberForever('filament-sql-field::mountSelect-' . Cache::get('filament-sql-field::changeConnection')['connection'], function () use ($data) {
                        return $data;
                    });

                })
                ->color('info')
                ->label(__('filament-sql-field::filament-sql-field.section.actions.mountSelect.title')),

        ]);
        $this->footerActions([
            Action::make('dark')
                ->icon('heroicon-o-moon')
                ->iconButton()
                ->color('info')
                ->action(function () {
                    $this->getChildComponents()[0]->dark();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', true, 'theme');
                }),
            Action::make('light')
                ->icon('heroicon-o-sun')
                ->iconButton()
                ->color('info')
                ->action(function () {
                    $this->getChildComponents()[0]->dark(false);
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', false, 'theme');
                }),

            Action::make('select')
                ->color('gray')
                ->action(function () {
                    $this->getChildComponents()[0]->dark();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch('updatePlugin', 'SELECT * FROM `table_name` WHERE 1', 'value');
                }),

            Action::make('insert')
                ->color('gray')
                ->action(function () {
                    $this->getChildComponents()[0]->dark();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch(
                        'updatePlugin',
                        "INSERT INTO `table_name`(`column1`, `column2`) VALUES ('value1','value2')",
                        'value'
                    );
                }),

            Action::make('update')
                ->color('gray')
                ->action(function () {
                    $this->getChildComponents()[0]->dark();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch(
                        'updatePlugin',
                        "UPDATE `table_name` SET `column1`='value1',`column2`='value2' WHERE 1",
                        'value'
                    );
                }),

            Action::make('delete')
                ->color('gray')
                ->action(function () {
                    $this->getChildComponents()[0]->dark();
                    $livewire = $this->getLivewire();
                    $livewire->dispatch(
                        'updatePlugin',
                        "DELETE FROM `table_name` WHERE 1",
                        'value'
                    );
                }),
        ]);
    }

    public function generateReport(string $format, string $connection): void
    {
        // $connection = $this->getChildComponents()[0]->getConnection();
        $query_sql = $this->getChildComponents()[0]->getState();
        if ($query_sql == '') {
            Notification::make()
                ->title(__('filament-sql-field::filament-sql-field.section.notifications.export.warning.title'))
                ->warning()
                ->send();
            return;
        }
        switch ($format) {
            case 'xlsx':
                $result = DB::connection($connection)->select($query_sql);
                $data = [];
                foreach ($result as $key => $value) {
                    $value = array_map(function ($item) {
                        return $this->isJson($item) ? json_decode($item, true) : $item;
                    }, (array) $value);
                    $data[] = (array) $value;
                }
                $url = $this->jsonToSheet($data, "report.xlsx");
                break;
            case 'json':
                $result = DB::connection($connection)->select($query_sql);
                $data = [];
                foreach ($result as $key => $value) {
                    $value = array_map(function ($item) {
                        return $this->isJson($item) ? json_decode($item, true) : $item;
                    }, (array) $value);
                    $data[] = (array) $value;
                }
                $url = $this->jsonOnly($data, "report.json");
                break;
            case 'csv':
                $result = DB::connection($connection)->select($query_sql);
                $data = [];
                foreach ($result as $key => $value) {
                    $value = array_map(function ($item) {
                        return $this->isJson($item) ? json_decode($item, true) : $item;
                    }, (array) $value);
                    $data[] = (array) $value;
                }
                $url = $this->jsonToCsv($data, "report.csv");
                break;
            default:
                break;
        }
        if ($url != '') {
            Notification::make()
                ->title(__('filament-sql-field::filament-sql-field.section.notifications.export.success.title'))
                ->success()
                ->persistent()
                ->body(__('filament-sql-field::filament-sql-field.section.notifications.export.success.body'))
                ->actions([
                    NotificationAction::make('view')
                        ->label('Download')
                        ->button()
                        ->url($url, shouldOpenInNewTab: true)
                ])
                ->send();
        } else {
            Notification::make()
                ->title(__('filament-sql-field::filament-sql-field.section.notifications.export.error.title'))
                ->danger()
                ->body(__('filament-sql-field::filament-sql-field.section.notifications.export.error.body'))
                ->send();
        }
    }

    public function validateSQL(string $sql)
    {
        try {
            DB::connection()->getPdo()->query("EXPLAIN " . $sql);
            return [true, 'Is Valid'];
        } catch (\Exception $e) {
            return [false, $e->getMessage()];
        }
    }

}

