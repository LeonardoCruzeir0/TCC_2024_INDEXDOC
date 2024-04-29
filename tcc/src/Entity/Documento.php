<?php

namespace App\Entity;

use App\Repository\DocumentoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentoRepository::class)]
class Documento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $qtd = null;

    #[ORM\ManyToOne(inversedBy: 'documentos')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'documento')]
    private ?Index $indexx = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index8 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index9 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $index10 = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('America/Sao_Paulo');
      
    }

    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getQtd(): ?int
    {
        return $this->qtd;
    }

    public function setQtd(?int $qtd): static
    {
        $this->qtd = $qtd;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getIndexx(): ?Index
    {
        return $this->indexx;
    }

    public function setIndexx(?Index $indexx): static
    {
        $this->indexx = $indexx;

        return $this;
    }

    public function getIndex1(): ?string
    {
        return $this->index1;
    }

    public function setIndex1(?string $index1): static
    {
        $this->index1 = $index1;

        return $this;
    }

    public function getIndex2(): ?string
    {
        return $this->index2;
    }

    public function setIndex2(?string $index2): static
    {
        $this->index2 = $index2;

        return $this;
    }

    public function getIndex3(): ?string
    {
        return $this->index3;
    }

    public function setIndex3(?string $index3): static
    {
        $this->index3 = $index3;

        return $this;
    }

    public function getIndex4(): ?string
    {
        return $this->index4;
    }

    public function setIndex4(?string $index4): static
    {
        $this->index4 = $index4;

        return $this;
    }

    public function getIndex5(): ?string
    {
        return $this->index5;
    }

    public function setIndex5(?string $index5): static
    {
        $this->index5 = $index5;

        return $this;
    }

    public function getIndex6(): ?string
    {
        return $this->index6;
    }

    public function setIndex6(?string $index6): static
    {
        $this->index6 = $index6;

        return $this;
    }

    public function getIndex7(): ?string
    {
        return $this->index7;
    }

    public function setIndex7(?string $index7): static
    {
        $this->index7 = $index7;

        return $this;
    }

    public function getIndex8(): ?string
    {
        return $this->index8;
    }

    public function setIndex8(?string $index8): static
    {
        $this->index8 = $index8;

        return $this;
    }

    public function getIndex9(): ?string
    {
        return $this->index9;
    }

    public function setIndex9(?string $index9): static
    {
        $this->index9 = $index9;

        return $this;
    }

    public function getIndex10(): ?string
    {
        return $this->index10;
    }

    public function setIndex10(?string $index10): static
    {
        $this->index10 = $index10;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
