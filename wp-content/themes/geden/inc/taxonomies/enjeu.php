<?php

if (!defined('ABSPATH')) {
    exit;
}

function geden_enjeu_default_terms(): array
{
    return [
        'blocs-enjeux' => 'Blocs enjeux',
        'blocs-permet' => 'Blocs ce que cela permet',
        'blocs-problematiques' => 'Blocs problématiques',
    ];
}

function geden_enjeu_admin_shortcuts(): array
{
    return [
        ['Blocs Enjeux', 'Blocs Enjeux', 'edit.php?post_type=geden_enjeu&enjeu_category=blocs-enjeux'],
        ['Blocs Ce que cela permet', 'Blocs Ce que cela permet', 'edit.php?post_type=geden_enjeu&enjeu_category=blocs-permet'],
        ['Blocs Problématiques', 'Blocs Problématiques', 'edit.php?post_type=geden_enjeu&enjeu_category=blocs-problematiques'],
    ];
}