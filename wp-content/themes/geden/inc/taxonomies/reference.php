<?php

if (!defined('ABSPATH')) {
    exit;
}

function geden_reference_default_terms(): array
{
    return [
        'realisations-effectuees' => 'Réalisations effectuées',
        'realisations-en-cours' => 'Réalisations en cours',
        'productions-techniques-scientifiques' => 'Productions techniques et scientifiques',
    ];
}

function geden_reference_admin_shortcuts(): array
{
    return [
        ['Réalisations en cours', 'Réalisations en cours', 'edit.php?post_type=geden_reference&reference_category=realisations-en-cours'],
        ['Réalisations effectuées', 'Réalisations effectuées', 'edit.php?post_type=geden_reference&reference_category=realisations-effectuees'],
        ['Productions', 'Productions', 'edit.php?post_type=geden_reference&reference_category=productions-techniques-scientifiques'],
    ];
}