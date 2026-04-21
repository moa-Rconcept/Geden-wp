<?php

if (!defined('ABSPATH')) {
    exit;
}

function geden_presentation_default_terms(): array
{
    return ['blocs-presentation' => 'Blocs présentation'];
}

function geden_presentation_admin_shortcuts(): array
{
    return [
        ['Blocs Présentation', 'Blocs Présentation', 'edit.php?post_type=geden_presentation&presentation_category=blocs-presentation'],
    ];
}