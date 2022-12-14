<?php

namespace App\Entity;

use App\Repository\PartnersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PartnersRepository::class)
 * @UniqueEntity("email", message="Un compte utilise déjà cette adresse email")
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
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=30)
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
    private $name;


    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 15,
     *      max = 150)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La description ne peut pas contenir de chiffre."
     * )
     */
    private $short_description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 15,
     *      max = 150)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La description ne peut pas contenir de chiffre."
     * )
     */
    private $long_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $technical_contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commercial_contact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Structures::class, mappedBy="partners", orphanRemoval=true)
     */
    private $structures;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="partners")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Permissions::class, mappedBy="partners", orphanRemoval=true)
     */
    private $permissions;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->long_description;
    }

    public function setLongDescription(string $long_description): self
    {
        $this->long_description = $long_description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTechnicalContact(): ?string
    {
        return $this->technical_contact;
    }

    public function setTechnicalContact(string $technical_contact): self
    {
        $this->technical_contact = $technical_contact;

        return $this;
    }

    public function getCommercialContact(): ?string
    {
        return $this->commercial_contact;
    }

    public function setCommercialContact(string $commercial_contact): self
    {
        $this->commercial_contact = $commercial_contact;

        return $this;
    }

    //public function displayStructures()
    //{
    //  $partnersStructures = $this->structures;
    //$structuresList = [];

    //foreach ($partnersStructures as $structure) {
    //  $structuresList[] = $structure->getId();
    //}
    //return $structuresList;
    // }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Permissions>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permissions $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setPartners($this);
        }

        return $this;
    }

    public function removePermission(Permissions $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getPartners() === $this) {
                $permission->setPartners(null);
            }
        }

        return $this;
    }
}
