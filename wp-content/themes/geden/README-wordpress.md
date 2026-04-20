# Thème WordPress GeDEN

## Mise à jour importante (page Références)
La page **Références (dynamique)** est maintenant alignée sur la structure de `references.html` :
- ancres de navigation (effectuées / en cours / productions),
- cartes références au format visuel identique,
- section productions avec accordéon par année.

## Saisie admin (WordPress)
### Référence
- Titre = titre du projet / production
- Extrait = sous-texte court (utile pour Productions)
- Image mise en avant = image principale de la carte
- Catégorie de référence = `realisations-effectuees` / `realisations-en-cours` / `productions-techniques-scientifiques`
- Meta box:
  - Année / période
  - Client
  - Besoins (1 ligne = 1 puce)
  - Prestations (1 ligne = 1 puce)
  - Auteurs (pour productions)
  - Livrable/méta (pour productions)
  - Sponsors multiples (logos colonne gauche)

### Sponsor
- Titre = nom sponsor
- Image mise en avant = logo
- Lien site sponsor = URL optionnelle

## Mise à jour importante (page Problématiques & Enjeux)
La page **Enjeux dynamique** affiche maintenant 3 blocs distincts :
- **Enjeux** (catégorie `blocs-enjeux`)
- **Ce que cela permet** (catégorie `blocs-permet`)
- **Problématiques** (catégorie `blocs-problematiques`)

### Saisie admin (WordPress)
#### Élément Enjeux
- Assigner la catégorie `enjeu_category` correspondant au bloc visé.
- Meta box:
  - Couleur du picto
  - Icône
  - Texte court (optionnel)
  - Liste (1 ligne = 1 puce)

#### Page "Problématiques et Enjeux"
- Meta box **Options page Problématiques & Enjeux** :
  - sous-titre de page,
  - image / tag / titre / texte pour chacun des 3 héros (Enjeux, Ce que cela permet, Problématiques).

## Mise à jour importante (page Offres & Services)
La page **Offres & Services (dynamique)** est pilotée par catégories `offre_category` :
- `blocs-offres`
- `frequentation`
- `enquetes`
- `entretiens`
- `outils-analytiques`

### Saisie admin (WordPress)
#### Élément Offres
- Assigner la catégorie `offre_category` correspondant au bloc visé.
- Meta box:
  - Couleur du picto
  - Icône
  - Texte court (optionnel)
  - Liste (1 ligne = 1 puce)

#### Catégorie Offres
- Chaque catégorie dispose de champs :
  - Tag affiché
  - Titre du bloc
  - Sous-titre du bloc
  - Image de fond du bloc
- Des raccourcis de menu sont disponibles dans l’admin pour filtrer rapidement chaque bloc.
## Modèles de pages conseillés
- Présentation -> `Présentation (dynamique)`
- Problématiques et Enjeux -> `Problématiques & Enjeux (dynamique)`
- Offres & Services -> `Offres & Services (dynamique)`
- Références -> `Références (dynamique)`
- Contact -> `Contact`