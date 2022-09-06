<?php

namespace App\Entity;

use App\Repository\PartnersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartnersRepository::class)
 */
class Partners
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $store_name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_newsletter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_planning;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_promote;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_products;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_statistics;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_evenements;

    /**
     * @ORM\Column(type="boolean")
     */
    private $permission_digicode;

    /**
     * @ORM\OneToMany(targetEntity=Structures::class, mappedBy="partners")
     */
    private $structures;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoreName(): ?string
    {
        return $this->store_name;
    }

    public function setStoreName(string $store_name): self
    {
        $this->store_name = $store_name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function isPermissionNewsletter(): ?bool
    {
        return $this->permission_newsletter;
    }

    public function setPermissionNewsletter(bool $permission_newsletter): self
    {
        $this->permission_newsletter = $permission_newsletter;

        return $this;
    }

    public function isPermissionPlanning(): ?bool
    {
        return $this->permission_planning;
    }

    public function setPermissionPlanning(bool $permission_planning): self
    {
        $this->permission_planning = $permission_planning;

        return $this;
    }

    public function isPermissionPromote(): ?bool
    {
        return $this->permission_promote;
    }

    public function setPermissionPromote(bool $permission_promote): self
    {
        $this->permission_promote = $permission_promote;

        return $this;
    }

    public function isPermissionProducts(): ?bool
    {
        return $this->permission_products;
    }

    public function setPermissionProducts(bool $permission_products): self
    {
        $this->permission_products = $permission_products;

        return $this;
    }

    public function isPermissionStatistics(): ?bool
    {
        return $this->permission_statistics;
    }

    public function setPermissionStatistics(bool $permission_statistics): self
    {
        $this->permission_statistics = $permission_statistics;

        return $this;
    }

    public function isPermissionEvenements(): ?bool
    {
        return $this->permission_evenements;
    }

    public function setPermissionEvenements(bool $permission_evenements): self
    {
        $this->permission_evenements = $permission_evenements;

        return $this;
    }

    public function isPermissionDigicode(): ?bool
    {
        return $this->permission_digicode;
    }

    public function setPermissionDigicode(bool $permission_digicode): self
    {
        $this->permission_digicode = $permission_digicode;

        return $this;
    }

    /**
     * @return Collection<int, Structures>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structures $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures[] = $structure;
            $structure->setPartners($this);
        }

        return $this;
    }

    public function removeStructure(Structures $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getPartners() === $this) {
                $structure->setPartners(null);
            }
        }

        return $this;
    }
}
