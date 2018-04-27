<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $minor;

    /**
     * @ORM\Column(type="integer")
     */
    private $major;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $qrcode;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getMinor(): ?int
    {
        return $this->minor;
    }

    public function setMinor($minor): self
    {
        $this->minor= $minor;

        return $this;
    }

    public function getMajor(): ?int
    {
        return $this->major;
    }

    public function setMajor($major): self
    {
        $this->major= $major;

        return $this;
    }

    public function getQrcode(): ?string
    {
        return $this->qrcode;
    }

    public function setQrcode(string $qrcode): self
    {
        $this->qrcode = $qrcode;

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
}
