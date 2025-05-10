<?php

namespace Bokja\Roster;

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
