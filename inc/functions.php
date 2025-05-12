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
        return [
            'div'      => [
                'id'    => true,
                'class' => true,
                'style' => true,
            ],
            'img'      => [
                'id'       => true,
                'class'    => true,
                'data-src' => true,
                'alt'      => true,
                'height'   => true,
                'src'      => true,
                'title'    => true,
                'width'    => true,
            ],
            'input'    => [
                'id'       => true,
                'class'    => true,
                'min'      => true,
                'max'      => true,
                'name'     => true,
                'required' => true,
                'type'     => true,
                'value'    => true,
            ],
            'label'    => [
                'class' => true,
                'for'   => true
            ],
            'option'   => [
                'id'      => true,
                'checked' => true,
                'value'   => true,
            ],
            'select'   => [
                'id'    => true,
                'class' => true,
                'name'  => true
            ],
            'span'     => [
                'id'    => true,
                'class' => true
            ],
            'table'    => [
                'id'    => true,
                'class' => true,
                'role'  => true,
            ],
            'tbody'    => [
                'id'    => true,
                'class' => true,
            ],
            'textarea' => [
                'id'    => true,
                'class' => true,
                'name'  => true,
                'rows'  => true,
                'cols'  => true,
            ],
            'tr'       => [
                'id'    => true,
                'class' => true,
            ],
            'th'       => [
                'id'    => true,
                'class' => true,
                'scope' => true,
            ],
            'td'       => [
                'id'    => true,
                'class' => true,
            ],
            'p'        => [
                'id'    => true,
                'class' => true,
            ],
        ];
    }
}