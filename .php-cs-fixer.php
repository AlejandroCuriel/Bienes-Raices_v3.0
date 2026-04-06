<?php

$finder = PhpCsFixer\Finder::create()
    // Solo codigo de logica para evitar conflictos de sangria en vistas mixtas PHP+HTML.
    ->in([
        __DIR__ . '/classes',
        __DIR__ . '/includes',
    ])
    // Excluir plantillas HTML/PHP de includes/templates.
    ->exclude(['templates'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder($finder);
