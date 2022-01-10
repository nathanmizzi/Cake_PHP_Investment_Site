<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Cake/Repl' => $baseDir . '/vendor/cakephp/repl/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
    ],
];
