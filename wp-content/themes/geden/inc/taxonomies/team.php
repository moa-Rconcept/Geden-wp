<?php

if (!defined('ABSPATH')) {
    exit;
}

function geden_team_default_terms(): array
{
    return [
        'membres-equipe' => 'Membres équipe',
    ];
}

function geden_team_admin_shortcuts(): array
{
    return [
        ['Membres équipe', 'Membres équipe', 'edit.php?post_type=geden_team&team_category=membres-equipe'],
    ];
}