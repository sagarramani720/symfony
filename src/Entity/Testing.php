<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TestingRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TestingRepository::class)
 */
class Testing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank() 
     * * @Assert\Length( 
     * min = 3, 
     * max = 10, 
     * minMessage = "Your name must be at least {{ limit }} characters long", 
     * maxMessage = "Your name cannot be longer than {{ limit }} characters" 
     * ) 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank() 
     * * @Assert\Email( 
     * message = "The email '{{ value }}' is not a valid email.", 
     * ) 
     */
    private $email;

    /**
     * @ORM\Column(type="integer", length=10)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="number_only") 
     * * @Assert\NotBlank() 
     * * @Assert\Length( 
     * min = 10, 
     * max = 10, 
     * minMessage = "Your phone number must be at least {{ limit }} characters long", 
     * maxMessage = "Your phone number cannot be longer than {{ limit }} characters" 
     * ) 
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=25)
     * * @Assert\NotBlank() 
     * * @Assert\Length( 
     * min = 2, 
     * max = 25, 
     * minMessage = "Your city must be at least {{ limit }} characters long", 
     * maxMessage = "Your city cannot be longer than {{ limit }} characters" 
     * ) 
     * 
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
