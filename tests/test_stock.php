<?php

$stock = new Stock();

$p1 = new Produit('P001', 'Clavier', 150, 10);
$p2 = new Produit('P002', 'Souris', 50, 0);
$p3 = new Produit('P003', 'Ecran', 1000, 2);

$stock->ajouter($p1);
$stock->ajouter($p2);
$stock->ajouter($p3);

verifier(
    $stock->compter() === 3,
    'Le stock contient 3 produits'
);

verifier(
    $stock->trouver('P001') === $p1,
    'Le produit P001 est trouvé'
);

verifier(
    $stock->trouver('P999') === null,
    'Une référence inexistante retourne null'
);

verifier(
    count($stock->tous()) === 3,
    'La méthode tous retourne tous les produits'
);

verifier(
    abs($stock->valeurTotale() - 3500) < 0.001,
    'La valeur totale du stock vaut 3500'
);

$ruptures = $stock->produitsEnRupture();

verifier(
    count($ruptures) === 1 && $ruptures[0]->getReference() === 'P002',
    'La souris est détectée comme produit en rupture'
);

$sousSeuil = $stock->produitsSousSeuil(3);

verifier(
    count($sousSeuil) === 2,
    'Deux produits ont une quantité inférieure à 3'
);

try {
    $stock->ajouter(new Produit('P001', 'Autre clavier', 200, 5));
    verifier(false, 'Une référence dupliquée doit lever une exception');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Une référence dupliquée lève une exception');
}
