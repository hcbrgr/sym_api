<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallSheetRepository")
 */
class CallSheet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="callSheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="callSheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\Column(type="boolean")
     */
    private $late;

    /**
     * Get the call sheet id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the call sheet user
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the call sheet user
     * @param User|null $user
     * @return CallSheet
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the call sheet event
     * Get the event object
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * Set the event object
     * @param Event|null $event
     * @return CallSheet
     */
    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get the user present
     * @return bool|null
     */
    public function getPresent(): ?bool
    {
        return $this->present;
    }

    /**
     * Set the user present
     * @param bool $present
     * @return CallSheet
     */
    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    /**
     * Get the user late
     * @return bool|null
     */
    public function getLate(): ?bool
    {
        return $this->late;
    }

    /**
     * Set the user late
     * @param bool $late
     * @return CallSheet
     */
    public function setLate(bool $late): self
    {
        $this->late= $late;

        return $this;
    }
}
