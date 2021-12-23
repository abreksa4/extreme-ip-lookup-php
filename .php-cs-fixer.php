<?php

$finder = Symfony\Component\Finder\Finder::create()
                                         ->notPath('vendor')
                                         ->name(['*.php', '*.twig']);

return (new PhpCsFixer\Config())
    ->setRules([
                   '@PSR12'                     => true,
                   'array_syntax'               => ['syntax' => 'short'],
                   'ordered_imports'            => ['sort_algorithm' => 'alpha'],
                   'no_unused_imports'          => true,
                   'no_useless_else'            => true,
                   'no_useless_return'          => true,
                   'blank_line_after_namespace' => true,
                   'elseif'                     => true,
                   'encoding'                   => true,
                   'binary_operator_spaces'     => [
                       'default' => 'align_single_space_minimal'
                   ]
               ])
    ->setFinder($finder);
