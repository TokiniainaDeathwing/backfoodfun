<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriePlatRepository")
 */
class CategoriePlat
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idplat;

    /**
     * @ORM\Column(type="integer")
     */
    private $idcategorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdplat(): ?int
    {
        return $this->idplat;
    }

    public function setIdplat(int $idplat): self
    {
        $this->idplat = $idplat;

        return $this;
    }

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(int $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }
}
