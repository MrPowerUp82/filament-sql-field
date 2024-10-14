<?php

namespace MrPowerUp\FilamentSqlField;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\DB;

class FilamentSqlField extends Field
{
    protected string $view = 'filament-sql-field::index';
    protected int $editorHeight = 300;
    protected array $tables = [];
    protected ?bool $dark = null;
    protected bool $fullscreen = false;
    protected string $mime = "text/x-mysql";
    protected string $connection = 'mysql';
    protected function getDatabaseTables(): string
    {
        $tables = DB::connection($this->connection)->select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        if (empty($tableNames)) {
            return json_encode([]);
        }
        $tablesAndColumns = [];
        foreach ($tableNames as $table) {
            $columns = DB::connection($this->connection)->select("SHOW COLUMNS FROM $table");
            $columnNames = array_map(fn($column) => $column->Field, $columns);
            $tablesAndColumns[$table] = $columnNames;
        }
        return json_encode($tablesAndColumns, JSON_UNESCAPED_UNICODE);
    }
    protected function setUp(): void
    {
        parent::setUp();
        $this->hintIcon('heroicon-m-question-mark-circle', tooltip: __('filament-sql-field::filament-sql-field.field.tooltip.text'));
    }
    public function getTables(): string
    {
        return json_encode($this->tables, JSON_UNESCAPED_UNICODE);
    }
    public function getEditorHeight(): string
    {
        return $this->editorHeight;
    }

    public function editorHeight(int $heightInPx): static
    {
        $this->editorHeight = $heightInPx;

        return $this;
    }
    public function getDark(): string
    {
        return match ($this->dark) {
            true => 'true',
            false => 'false',
            default => 'null',
        };
    }
    public function dark(bool $dark = true): static
    {
        $this->dark = $dark;

        return $this;
    }
    public function getFullscreen(): string
    {
        return $this->fullscreen ? 'true' : 'false';
    }
    public function fullscreen(bool $fullscreen = true): static
    {
        $this->fullscreen = $fullscreen;

        return $this;
    }
    public function getMime(): string
    {
        return $this->mime;
    }
    public function mime(string $mime): static
    {
        $this->mime = $mime;

        return $this;
    }
    public function autoGetTables(): static
    {
        $this->tables = json_decode($this->getDatabaseTables(), true);

        return $this;
    }
    /**
     * Set the tables for the SQL field.
     *
     * @param array $tables The tables to be used.
     * Example: ['table1' => ['column1', 'column2', 'column3'], 'table2' => ['column1', 'column2', 'column3']]
     * @return static
     */
    public function tables(array $tables): static
    {
        $this->tables = $tables;

        return $this;
    }
    public function connection(string $connection): static
    {
        $this->connection = $connection;

        return $this;
    }
    public function getConnection(): string
    {
        return $this->connection;
    }
}
