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

$produitAValider = new Produit('P002', 'Souris', 50, 5);
$commandeAValider = new Commande(2);
$commandeAValider->ajouterLigne($produitAValider, 3);

verifier(
    $commandeAValider->estValidee() === false,
    'Une commande est initialement non validée'
);

$commandeAValider->valider();

verifier(
    $commandeAValider->estValidee() === true,
    'La commande est validée'
);
verifier(
    $produitAValider->getQuantite() === 2,
    'La validation décrémente le stock'
);

try {
    $commandeAValider->valider();
    verifier(false, 'Valider deux fois doit lever une exception');
} catch (LogicException $e) {
    verifier(true, 'Valider deux fois lève une exception');
}

try {
    (new Commande(3))->valider();
    verifier(false, 'Valider une commande vide doit lever une exception');
} catch (LogicException $e) {
    verifier(true, 'Valider une commande vide lève une exception');
}

$affichage = $commandeAValider->afficher();

verifier(
    str_contains($affichage, 'Commande n°2'),
    'L’affichage contient le numéro de la commande'
);
verifier(
    str_contains($affichage, 'Souris x 3 : 150.00'),
    'L’affichage contient les lignes de la commande'
);
verifier(
    str_contains($affichage, 'TOTAL : 150.00'),
    'L’affichage contient le total de la commande'
);
