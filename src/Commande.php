<?php

class Commande
{
    private int $numero;
    private array $lignes = [];
    public function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    public function ajouterLigne(Produit $p, int $quantite): void
    {
        if ($quantite <= 0) {
            throw new InvalidArgumentException(
                "La quantité doit être positive."
            );
        }

        if ($quantite > $p->getQuantite()) {
            throw new InvalidArgumentException(
                "La quantité demandée dépasse le stock disponible."
            );
        }

        $this->lignes[] = [
            'produit' => $p,
            'quantite' => $quantite
        ];
    }

    public function total(): float
    {
        $total = 0;

        foreach ($this->lignes as $ligne) {
            $total += $ligne['produit']->getPrix() * $ligne['quantite'];
        }

        return $total;
    }
}
