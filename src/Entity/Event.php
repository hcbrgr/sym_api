<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CallSheet", mappedBy="event_id")
     */
    private $callSheets;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->callSheets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection|CallSheet[]
     */
    public function getCallSheets(): Collection
    {
        return $this->callSheets;
    }

    /**
     * @param CallSheet $callSheet
     * @return Event
     */
    public function addCallSheet(CallSheet $callSheet): self
    {
        if (!$this->callSheets->contains($callSheet)) {
            $this->callSheets[] = $callSheet;
            $callSheet->setEvent($this);
        }

        return $this;
    }

    /**
     * @param CallSheet $callSheet
     * @return Event
     */
    public function removeCallSheet(CallSheet $callSheet): self
    {
        if ($this->callSheets->contains($callSheet)) {
            $this->callSheets->removeElement($callSheet);
            // set the owning side to null (unless already changed)
            if ($callSheet->getEvent() === $this) {
                $callSheet->setEvent(null);
            }
        }

        return $this;
    }
}
