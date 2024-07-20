<?php

namespace MrPowerUp\FilamentSqlField;

use Filament\Forms\Components\Field;
use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\DB;

class FilamentSqlField extends Field
{
    protected string $view = 'filament-sql-field::index';
    protected int $editorHeight = 300;
    protected array $tables = [];
    protected bool $dark = false;
    protected function setUp(): void
    {
        $this->tables = json_decode($this->getDatabaseTables(), true);
        parent::setUp();
    }
    public function getDatabaseTables(): string
    {
        // $databaseName = DB::connection()->getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        $tablesAndColumns = [];
        foreach ($tableNames as $table) {
            $columns = DB::select("SHOW COLUMNS FROM {$table}");
            $columnNames = array_map(fn($column) => $column->Field, $columns);
            $tablesAndColumns[$table] = $columnNames;
        }
        return json_encode($tablesAndColumns);
    }
    public function getEditorHeight(): string
    {
        return $this->editorHeight.'px';
    }

    public function editorHeight(int $heightInPx): static
    {
        $this->editorHeight = $heightInPx;

        return $this;
    }
    public function getDark(): string
    {
        return $this->dark ? 'true' : 'false';
    }
    public function dark(bool $dark = true): static
    {
        $this->dark = $dark;

        return $this;
    }
}
