# filament-sql-field

<!-- ![image](https://raw.githubusercontent.com/MrPowerUp82/filament-sql-field-plus/main/example_1.png)
![image](https://raw.githubusercontent.com/MrPowerUp82/filament-sql-field-plus/main/example_2.png) -->

![image](example_1.png)
![image](example_2.png)
![image](example_3.gif)

## Installation

You can install the package via composer:

```bash
composer require mrpowerup/filament-sql-field
```

## Usage
```php
use MrPowerUp\FilamentSqlField\FilamentSqlSection;
use MrPowerUp\FilamentSqlField\FilamentSqlField;
```

```php
public static function form(Form $form): Form
    {
        return $form
            ->schema([
                   FilamentSqlSection::make()
                    ->schema([
                        FilamentSqlField::make('sql')                               
                            ->fullscreen() // Allow Fullscreen mode
                            ->editorHeight(300) // Set height of editor
                            ->autoGetTables() // Automatically get tables from database
                            ->default("SELECT * FROM users WHERE 1;")
                            ->columnSpanFull(),
                    ])
            ]);
    }
```

## MIME types defined

- text/x-sql
- text/x-mysql
- text/x-mariadb
- text/x-cassandra
- text/x-plsql
- text/x-mssql
- text/x-hive
- text/x-pgsql
- text/x-gql
- text/x-gpsql
- text/x-esper
- text/x-sqlite
- text/x-sparksql
- text/x-trino

### If you need to update the editor value with dispatch here is an example:

```php
$this->dispatch('updatePlugin', $record->sql);
```

```html
@script
    <script>
        $wire.on('updatePlugin', (event) => {
            window.editor.setValue(event[0]);
        });
    </script>
@endscript
```

## Links

- [Source Code](https://github.com/MrPowerUp82/filament-sql-field)
- [Packagist](https://packagist.org/packages/mrpowerup/filament-sql-field)

## License

The MIT License (MIT). Please see [License File](https://raw.githubusercontent.com/MrPowerUp82/filament-sql-field/main/LICENSE.md) for more information.
