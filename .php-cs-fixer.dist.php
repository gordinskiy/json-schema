<?php

return (new PhpCsFixer\Config('json-schema'))
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->path('src')
            ->path('tests')
            ->in(__DIR__)
    );
