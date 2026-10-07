<?php
$prodC = new Produit('C1', 'Cable', 10, 5);
$cmd = new Commande(1);
$cmd->ajouterLigne($prodC, 3);
verifier(abs($cmd->total() - 30) < 0.001, 'Total = 3 x 10 = 30');
verifier($cmd->estValidee() === false, 'Commande non validée au départ');

$cmd->valider();
verifier($cmd->estValidee() === true, 'Commande validée');
verifier($prodC->getQuantite() === 2, 'Le stock est décrémenté (5 - 3 = 2)');

try { $cmd->valider(); $ok = false; }
catch (LogicException $e) { $ok = true; }
verifier($ok, 'Valider deux fois lève une exception');

try { (new Commande(2))->valider(); $ok = false; }
catch (LogicException $e) { $ok = true; }
verifier($ok, 'Valider une commande vide lève une exception');

try { (new Commande(3))->ajouterLigne($prodC, 50); $ok = false; }
catch (InvalidArgumentException $e) { $ok = true; }
verifier($ok, 'Quantité supérieure au stock : exception');

try { (new Commande(4))->ajouterLigne($prodC, 0); $ok = false; }
catch (InvalidArgumentException $e) { $ok = true; }
verifier($ok, 'Quantité nulle : exception');

verifier(str_contains($cmd->afficher(), 'TOTAL'), 'La facture contient le total');