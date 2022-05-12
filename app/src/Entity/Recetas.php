<?php

namespace App\Entity;

use App\Repository\RecetasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetasRepository::class)]
class Recetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'Id')]
    #[ORM\JoinColumn(nullable: false)]
    private $UserId;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nombre;

    #[ORM\Column(type: 'string', length: 25)]
    private $Tipo;

    #[ORM\Column(type: 'integer')]
    private $Cant;

    #[ORM\Column(type: 'string', length: 50)]
    private $Dificultad;

    #[ORM\Column(type: 'json')]
    private $Ingredientes = [];

    #[ORM\Column(type: 'array')]
    private $Pasos = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Imagen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->Tipo;
    }

    public function setTipo(string $Tipo): self
    {
        $this->Tipo = $Tipo;

        return $this;
    }

    public function getCant(): ?int
    {
        return $this->Cant;
    }

    public function setCant(int $Cant): self
    {
        $this->Cant = $Cant;

        return $this;
    }

    public function getDificultad(): ?string
    {
        return $this->Dificultad;
    }

    public function setDificultad(string $Dificultad): self
    {
        $this->Dificultad = $Dificultad;

        return $this;
    }

    public function getIngredientes(): ?array
    {
        return $this->Ingredientes;
    }

    public function setIngredientes(array $Ingredientes): self
    {
        $this->Ingredientes = $Ingredientes;

        return $this;
    }

    public function getPasos(): ?array
    {
        return $this->Pasos;
    }

    public function setPasos(array $Pasos): self
    {
        $this->Pasos = $Pasos;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->Imagen;
    }

    public function setImagen(?string $Imagen): self
    {
        $this->Imagen = $Imagen;

        return $this;
    }
}
