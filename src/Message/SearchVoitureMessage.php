<?php
namespace App\Message;

class SearchVoitureMessage
{
    private $prixMin;
    private $prixMax;

    public function __construct(float $prixMin, float $prixMax)
    {
        $this->prixMin = $prixMin;
        $this->prixMax = $prixMax;
    }

    public function getPrixMin(): float
    {
        return $this->prixMin;
    }

    public function getPrixMax(): float
    {
        return $this->prixMax;
    }
}