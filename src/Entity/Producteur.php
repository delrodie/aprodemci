<?php

namespace App\Entity;

use App\Repository\ProducteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProducteurRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Producteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenoms;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pseudonyme;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $entreprise;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $artistes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $albums;

    #[ORM\Column(type: 'text', nullable: true)]
    private $explication;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $accord;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $statut;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $media;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slug;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $matricule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getPseudonyme(): ?string
    {
        return $this->pseudonyme;
    }

    public function setPseudonyme(?string $pseudonyme): self
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getArtistes(): ?string
    {
        return $this->artistes;
    }

    public function setArtistes(?string $artistes): self
    {
        $this->artistes = $artistes;

        return $this;
    }

    public function getAlbums(): ?string
    {
        return $this->albums;
    }

    public function setAlbums(?string $albums): self
    {
        $this->albums = $albums;

        return $this;
    }

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(?string $explication): self
    {
        $this->explication = $explication;

        return $this;
    }

    public function isAccord(): ?bool
    {
        return $this->accord;
    }

    public function setAccord(?bool $accord): self
    {
        $this->accord = $accord;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
	
	#[ORM\PrePersist]
         	public function setCreatedAtValue()
         	{
         		return $this->createdAt = new \DateTime();
         	}

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }
}
