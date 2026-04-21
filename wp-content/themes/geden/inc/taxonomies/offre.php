<?php

if (!defined('ABSPATH')) {
    exit;
}

function geden_offre_default_terms(): array
{
    return [
        'blocs-offres' => 'Blocs offres',
        'frequentation' => 'Fréquentation',
        'enquetes' => 'Enquêtes',
        'entretiens' => 'Entretiens',
        'outils-analytiques' => 'Outils analytiques',
    ];
}

function geden_offre_admin_shortcuts(): array
{
    return [
        ['Blocs Offres', 'Blocs Offres', 'edit.php?post_type=geden_offre&offre_category=blocs-offres'],
        ['Fréquentation', 'Fréquentation', 'edit.php?post_type=geden_offre&offre_category=frequentation'],
        ['Enquêtes', 'Enquêtes', 'edit.php?post_type=geden_offre&offre_category=enquetes'],
        ['Entretiens', 'Entretiens', 'edit.php?post_type=geden_offre&offre_category=entretiens'],
        ['Outils analytiques', 'Outils analytiques', 'edit.php?post_type=geden_offre&offre_category=outils-analytiques'],
    ];
}