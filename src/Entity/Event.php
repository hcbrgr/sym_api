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
     * Get the event id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the event name
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the event name
     * @param string $name
     * @return Event
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the event location
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * Set the event location
     * @param Location|null $location
     * @return Event
     */
    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the event start date
     * @return \DateTimeImmutable|null
     */
    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * Set the event start date
     * @param \DateTimeImmutable $startDate
     * @return Event
     */
    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the event end date
     * @return \DateTimeImmutable|null
     */
    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * Set the event end date
     * @param \DateTimeImmutable $endDate
     * @return Event
     */
    public function setEndDate(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get all the call sheet join to the event
     * @return Collection|CallSheet[]
     */
    public function getCallSheets(): Collection
    {
        return $this->callSheets;
    }

    /**
     * Add a call sheet to the event
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
     * Remove a call sheet
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
