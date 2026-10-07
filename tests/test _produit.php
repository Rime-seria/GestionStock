<?php

$p = new Produit('P001', 'Clavier', 150, 10);

$p->ajouterQuantite(5);

verifier(
    $p->getQuantite() === 15,
    'Après ajout de 5, la quantité est 15'
);

try {
    $p->ajouterQuantite(0);
    verifier(false, 'Ajouter une quantité nulle doit lever une exception');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Une quantité nulle lève une exception');
}