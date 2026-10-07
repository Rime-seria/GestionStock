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

$p->retirerQuantite(3);

verifier(
    $p->getQuantite() === 12,
    'Après retrait de 3, la quantité est 12'
);

try {
    $p->retirerQuantite(20);
    verifier(false, 'Un retrait supérieur au stock doit lever une exception');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Un stock insuffisant lève une exception');
}

verifier(
    abs($p->valeurStock() - 1800) < 0.001,
    'La valeur du stock vaut 12 x 150'
);