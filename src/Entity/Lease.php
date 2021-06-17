<?php

namespace App\Entity;

use App\Repository\LeaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeaseRepository::class)
 */
class Lease
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity=Tenant::class, mappedBy="lease")
     */
    private $tenant_id;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="leases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property_id;

    public function __construct()
    {
        $this->tenant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|Tenant[]
     */
    public function getTenantId(): Collection
    {
        return $this->tenant_id;
    }

    public function addTenantId(Tenant $tenantId): self
    {
        if (!$this->tenant_id->contains($tenantId)) {
            $this->tenant_id[] = $tenantId;
            $tenantId->setLease($this);
        }

        return $this;
    }

    public function removeTenantId(Tenant $tenantId): self
    {
        if ($this->tenant_id->removeElement($tenantId)) {
            // set the owning side to null (unless already changed)
            if ($tenantId->getLease() === $this) {
                $tenantId->setLease(null);
            }
        }

        return $this;
    }

    public function getPropertyId(): ?Property
    {
        return $this->property_id;
    }

    public function setPropertyId(?Property $property_id): self
    {
        $this->property_id = $property_id;

        return $this;
    }
}
