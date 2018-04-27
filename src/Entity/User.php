<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CallSheet", mappedBy="user_id")
     */
    private $callSheets;

    private $salt;

    public function __construct()
    {
        $this->callSheets = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|CallSheet[]
     */
    /*public function getCallSheets(): Collection
    {
        return $this->callSheets;
    }

    public function addCallSheet(CallSheet $callSheet): self
    {
        if (!$this->callSheets->contains($callSheet)) {
            $this->callSheets[] = $callSheet;
            $callSheet->setUser($this);
        }

        return $this;
    }

    public function removeCallSheet(CallSheet $callSheet): self
    {
        if ($this->callSheets->contains($callSheet)) {
            $this->callSheets->removeElement($callSheet);
            // set the owning side to null (unless already changed)
            if ($callSheet->getUser() === $this) {
                $callSheet->setUser(null);
            }
        }

        return $this;
    }*/

    public function getRoles()
    {

    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {

    }


    public function eraseCredentials()
    {

    }
}
