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
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $beacon;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $qrcode;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getBeacon(): ?int
    {
        return $this->beacon;
    }

    /**
     * @param $beacon
     * @return Location
     */
    public function setBeacon($beacon): self
    {
        $this->beacon= $beacon;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getQrcode(): ?string
    {
        return $this->qrcode;
    }

    /**
     * @param string $qrcode
     * @return Location
     */
    public function setQrcode(string $qrcode): self
    {
        $this->qrcode = $qrcode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Location
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
