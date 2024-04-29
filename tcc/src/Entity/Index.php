<?php

namespace App\Entity;

use App\Repository\IndexRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndexRepository::class)]
#[ORM\Table(name: '`index`')]
class Index
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\OneToMany(targetEntity: Documento::class, mappedBy: 'indexx')]
    private Collection $documento;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    public function __construct()
    {
        $this->documento = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('America/Sao_Paulo');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection<int, Documento>
     */
    public function getDocumento(): Collection
    {
        return $this->documento;
    }

    public function addDocumento(Documento $documento): static
    {
        if (!$this->documento->contains($documento)) {
            $this->documento->add($documento);
            $documento->setIndexx($this);
        }

        return $this;
    }

    public function removeDocumento(Documento $documento): static
    {
        if ($this->documento->removeElement($documento)) {
            // set the owning side to null (unless already changed)
            if ($documento->getIndexx() === $this) {
                $documento->setIndexx(null);
            }
        }

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
}
