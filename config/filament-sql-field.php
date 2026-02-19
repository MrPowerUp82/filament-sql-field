<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported SQL Dialects
    |--------------------------------------------------------------------------
    |
    | Here you may specify the SQL dialects available in the SQL field.
    | The key is the MIME type used by CodeMirror, and the value is the label.
    |
    */

    'dialects' => [
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
    ],

    /*
    |--------------------------------------------------------------------------
    | SQL Templates
    |--------------------------------------------------------------------------
    |
    | Define reusable SQL templates here. These will be available in the
    | "Templates" action dropdown.
    | Format: 'Label' => 'SQL query'
    |
    */

    'templates' => [
        'Select All' => 'SELECT * FROM table_name LIMIT 100;',
        'Count Rows' => 'SELECT COUNT(*) FROM table_name;',
        'Insert Row' => "INSERT INTO table_name (column1, column2) VALUES ('value1', 'value2');",
    ],

];
