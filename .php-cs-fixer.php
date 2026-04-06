<?php

$finder = PhpCsFixer\Finder::create()
  ->in(__DIR__ . '/app') // cambia esto según tu estructura
  ->exclude(['vendor', 'storage']);

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
