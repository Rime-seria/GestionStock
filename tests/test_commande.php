<?php

$p = new Produit('P001', 'Clavier', 150, 10);

$c = new Commande(1);
$c->ajouterLigne($p, 2);

verifier(
    abs($c->total() - 300) < 0.001,
    'Le total de la commande vaut 300'
);

try {
    $c->ajouterLigne($p, 0);
    verifier(false, 'Une quantité nulle doit lever une exception');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Une quantité nulle lève une exception');
}

try {
    $c->ajouterLigne($p, 20);
    verifier(false, 'Une quantité supérieure au stock doit lever une exception');
} catch (InvalidArgumentException $e) {
    verifier(true, 'Une quantité supérieure au stock lève une exception');
}