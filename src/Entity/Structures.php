<?php

namespace App\Entity;


use App\Repository\StructuresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=StructuresRepository::class)
 * @UniqueEntity("email", message="Un compte utilise déjà cette adresse email")
 */
class Structures
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 30)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le titre ne peut pas contenir de chiffre."
     * )
     */
    private $store_name;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone;



    /**
     * @ORM\Column(type="integer")
     */
    private $newsletter;

    /**
     * @ORM\Column(type="integer")
     */
    private $promote;

    /**
     * @ORM\Column(type="integer")
     */
    private $planning;

    /**
     * @ORM\Column(type="integer")
     */
    private $statistics;

    /**
     * @ORM\Column(type="integer")
     */
    private $products;

    /**
     * @ORM\Column(type="integer")
     */
    private $digicode;


    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Partners::class, inversedBy="structures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partners;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="structures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNewsletter(): ?int
    {
        return $this->newsletter;
    }

    public function setNewsletter(int $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getPromote(): ?int
    {
        return $this->promote;
    }

    public function setPromote(int $promote): self
    {
        $this->promote = $promote;

        return $this;
    }

    public function getPlanning(): ?int
    {
        return $this->planning;
    }

    public function setPlanning(int $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getStatistics(): ?int
    {
        return $this->statistics;
    }

    public function setStatistics(int $statistics): self
    {
        $this->statistics = $statistics;

        return $this;
    }

    public function getProducts(): ?int
    {
        return $this->products;
    }

    public function setProducts(int $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getDigicode(): ?int
    {
        return $this->digicode;
    }

    public function setDigicode(int $digicode): self
    {
        $this->digicode = $digicode;

        return $this;
    }


    //public function displayPartners()
    // {
    //   $permissionsPartners = $this->partners;
    //  $partnersList = [];
    //
    //      foreach ($permissionsPartners as $partner) {
    //        $partnersList = $partner->getId();
    //  }
    //return $partnersList;
    //}

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPartners(): ?Partners
    {
        return $this->partners;
    }

    public function setPartners(?Partners $partners): self
    {
        $this->partners = $partners;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
