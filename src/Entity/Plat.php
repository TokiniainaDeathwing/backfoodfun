<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $descriptioncourte;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $descriptionlongue;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescriptioncourte(): ?string
    {
        return $this->descriptioncourte;
    }

    public function setDescriptioncourte(string $descriptioncourte): self
    {
        $this->descriptioncourte = $descriptioncourte;

        return $this;
    }

    public function getDescriptionlongue(): ?string
    {
        return $this->descriptionlongue;
    }

    public function setDescriptionlongue(string $descriptionlongue): self
    {
        $this->descriptionlongue = $descriptionlongue;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
