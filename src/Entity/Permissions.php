<?php

namespace App\Entity;

use App\Repository\PermissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermissionsRepository::class)
 */
class Permissions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=30)
     */
    private $perms;

    /**
     * @ORM\OneToOne(targetEntity=Partners::class, cascade={"persist", "remove"})
     */
    private $partners;

    /**
     * @ORM\ManyToOne(targetEntity=Structures::class, inversedBy="permissions")
     */
    private $structures;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;






    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPerms(): ?string
    {
        return $this->perms;
    }

    public function setPerms(string $perms): self
    {
        $this->perms = $perms;

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

    public function getStructures(): ?Structures
    {
        return $this->structures;
    }

    public function setStructures(?Structures $structures): self
    {
        $this->structures = $structures;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
