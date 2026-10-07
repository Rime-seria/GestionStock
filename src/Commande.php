<?php

class Commande
{
    private int $numero;
    private array $lignes = [];
    private bool $validee = false;

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

    public function valider(): void
    {
        if ($this->validee) {
            throw new LogicException("La commande est déjà validée.");
        }

        if ($this->lignes === []) {
            throw new LogicException("Une commande vide ne peut pas être validée.");
        }

        foreach ($this->lignes as $ligne) {
            $ligne['produit']->retirerQuantite($ligne['quantite']);
        }

        $this->validee = true;
    }

    public function estValidee(): bool
    {
        return $this->validee;
    }
}
