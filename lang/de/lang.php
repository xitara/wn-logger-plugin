<?php

return [
    'plugin' => [
        'name'        => 'Custom-Logger',
        'description' => 'Zusätzliches Logging mit weiteren Einstellmöglichkeiten',
    ],
    'tab' => [
        'custom_logging' => 'Custom Logging',
    ],
    'switch' => [
        'custom'   => 'Custom-Logger aktivieren',
        'database' => 'Logging in der Datenbank',
        'cli'      => 'Logausgabe in der Kommandozeile',
        'comment'  => [
            'custom'   => 'aktiviert das Custom-Logger Plugin unabhängig des internen Logs',
            'database' => 'schreibt Logdaten in die Datenbank',
            'cli'      => 'Ausgabe beim Aufruf per Artisan oder PHP-Cli',
        ],
    ],
    'checkboxlist' => [
        'label'   => 'Aktivierte Loglevel',
        'comment' => 'Nur diese Loglevel werden geloggt',
    ],
];
