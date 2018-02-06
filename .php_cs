<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

$header = <<<'EOF'
This file is part of the browser-detector package.

Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->append([__FILE__]);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PSR2'                     => true,
            '@Symfony'                  => true,
            '@Symfony:risky'            => true,
            '@PHP70Migration'           => true,
            '@PHP70Migration:risky'     => true,
            '@PHP71Migration'           => true,
            '@PHP71Migration:risky'     => true,
            '@PHPUnit60Migration:risky' => true,

            // @PSR2 rules configured different from default
            'blank_line_after_namespace' => true,
            'class_definition'           => [
                'singleLine'                     => false,
                'singleItemSingleLine'           => true,
                'multiLineExtendsEachSingleLine' => true,
            ],
            'method_argument_space' => [
                'ensure_fully_multiline'           => true,
                'keep_multiple_spaces_after_comma' => false,
            ],
            'no_break_comment'    => false,
            'visibility_required' => ['elements' => ['property', 'method', 'const']],

            // @Symfony rules configured different from default
            'binary_operator_spaces'             => ['default' => 'align_single_space_minimal'],
            'concat_space'                       => ['spacing' => 'one'],
            'declare_equal_normalize'            => ['space' => 'single'],
            'no_blank_lines_after_phpdoc'        => false,
            'phpdoc_no_empty_return'             => false,
            'phpdoc_summary'                     => false,
            'single_blank_line_before_namespace' => false,
            'single_line_comment_style'          => ['comment_types' => ['hash']],
            'space_after_semicolon'              => ['remove_in_empty_for_expressions' => true],
            'yoda_style'                         => [
                'equal'            => true,
                'identical'        => true,
                'less_and_greater' => true,
            ],

            // @Symfony:risky rules configured different from default
            'non_printable_character' => ['use_escape_sequences_in_strings' => true],

            // @PHP70Migration rules configured different from default
            'ternary_to_null_coalescing' => false,

            // @PHP70Migration:risky rules configured different from default
            'pow_to_exponentiation' => false,

            // @PHPUnit60Migration:risky rules configured different from default
            'php_unit_dedicate_assert' => ['target' => 'newest'],

            // other rules
            'align_multiline_comment'     => ['comment_type' => 'all_multiline'],
            'array_syntax'                => ['syntax' => 'short'],
            'backtick_to_shell_exec'      => true,
            'class_keyword_remove'        => false,
            'combine_consecutive_issets'  => true,
            'combine_consecutive_unsets'  => true,
            'compact_nullable_typehint'   => true,
            'escape_implicit_backslashes' => [
                'double_quoted'  => true,
                'heredoc_syntax' => true,
                'single_quoted'  => false,
            ],
            'explicit_indirect_variable' => true,
            'explicit_string_variable'   => true,
            'final_internal_class'       => [
                'annotation-black-list' => ['@final', '@Entity', '@ORM'],
                'annotation-white-list' => ['@internal'],
            ],
            'general_phpdoc_annotation_remove' => [
                'expectedExceptionMessageRegExp',
                'expectedException',
                'expectedExceptionMessage',
                'author',
            ],
            'hash_to_slash_comment' => true,
            'header_comment'        => [
                'header'      => $header,
                'commentType' => 'PHPDoc',
                'location'    => 'after_open',
                'separate'    => 'bottom',
            ],
            'heredoc_to_nowdoc'                         => true,
            'linebreak_after_opening_tag'               => true,
            'list_syntax'                               => ['syntax' => 'short'],
            'mb_str_functions'                          => true,
            'method_chaining_indentation'               => true,
            'method_separation'                         => true,
            'native_function_invocation'                => false,
            'no_blank_lines_before_namespace'           => true,
            'no_multiline_whitespace_before_semicolons' => true,
            'no_null_property_initialization'           => true,
            'no_php4_constructor'                       => true,
            'no_short_echo_tag'                         => true,
            'no_superfluous_elseif'                     => true,
            'no_unreachable_default_argument_value'     => true,
            'no_useless_else'                           => true,
            'no_useless_return'                         => false,
            'not_operator_with_space'                   => false,
            'not_operator_with_successor_space'         => false,
            'ordered_class_elements'                    => false,
            'ordered_imports'                           => true,
            'php_unit_test_annotation'                  => ['case' => 'camel', 'style' => 'prefix'],
            'php_unit_test_class_requires_covers'       => false,
            'phpdoc_add_missing_param_annotation'       => ['only_untyped' => false],
            'phpdoc_order'                              => true,
            'phpdoc_types_order'                        => [
                'null_adjustment' => 'always_last',
                'sort_algorithm'  => 'alpha',
            ],
            'psr0'                   => true,
            'simplified_null_return' => false,
            'static_lambda'          => true,
            'strict_comparison'      => true,
            'strict_param'           => false,
        ]
    )
    ->setUsingCache(true)
    ->setFinder($finder);
