<?php

namespace Bokja\Roster {

    function prefixed(string $input): string
    {
        if (isPrefixed($input)) {
            return $input;
        }

        return "roster_$input";
    }

    function unprefixed(string $input): string
    {
        if (!isPrefixed($input)) {
            return $input;
        }

        return substr($input, strlen('roster_'));
    }

    function isPrefixed(string $input): bool
    {
        return str_starts_with($input, 'roster_');
    }
}

namespace Bokja\Roster\Kses {

    function ksesEditForm(): array
    {
        static $setup = null;

        if (is_null($setup)) {
            $defaultProp = [
                'id'    => true,
                'class' => true,
                'style' => true,
            ];

            return [
                'button'   => [
                    ...$defaultProp,
                    'disabled' => true,
                    'onClick'  => true,
                ],
                'div'      => [
                    ...$defaultProp,
                ],
                'form'     => [
                    ...$defaultProp,
                    'action'  => true,
                    'method'  => true,
                    'name'    => true,
                    'enctype' => true,
                ],
                'img'      => [
                    ...$defaultProp,
                    'data-src' => true,
                    'alt'      => true,
                    'height'   => true,
                    'src'      => true,
                    'title'    => true,
                    'width'    => true,
                ],
                'input'    => [
                    ...$defaultProp,
                    'checked'  => true,
                    'disabled' => true,
                    'min'      => true,
                    'max'      => true,
                    'name'     => true,
                    'readonly' => true,
                    'required' => true,
                    'type'     => true,
                    'value'    => true,
                ],
                'label'    => [
                    ...$defaultProp,
                    'for' => true
                ],
                'option'   => [
                    ...$defaultProp,
                    'checked'  => true,
                    'disabled' => true,
                    'selected' => true,
                    'value'    => true,
                ],
                'select'   => [
                    ...$defaultProp,
                    'disabled' => true,
                    'name'     => true,
                ],
                'span'     => [
                    ...$defaultProp,
                ],
                'table'    => [
                    ...$defaultProp,
                    'role' => true,
                ],
                'tbody'    => [
                    ...$defaultProp,
                ],
                'textarea' => [
                    ...$defaultProp,
                    'disabled' => true,
                    'name'     => true,
                    'cols'     => true,
                    'readonly' => true,
                    'required' => true,
                    'rows'     => true,
                ],
                'tr'       => [
                    ...$defaultProp,
                ],
                'th'       => [
                    ...$defaultProp,
                    'scope' => true,
                ],
                'td'       => [
                    ...$defaultProp,
                ],
                'ul'       => [
                    ...$defaultProp,
                ],
                'li'       => [
                    ...$defaultProp,
                ],
                'p'        => [
                    ...$defaultProp,
                ],
            ];
        }

        return $setup;
    }
}