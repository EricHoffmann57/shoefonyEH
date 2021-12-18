<?php

declare(strict_types=1);
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
     #[Assert\NotBlank(message:"Ce champ ne peut être vide")]
     private ?string $lastname = null;

    #[Assert\NotBlank(message:"Ce champ ne peut être vide")]
     private ?string $firstname = null;

    #[Assert\NotBlank(message:"Ce champ ne peut être vide")]
    #[Assert\Email(message:"Ce champ doit être une adresse mail valide")]
     private ?string $email = null;

    #[Assert\NotBlank(message:"Ce champ ne peut être vide")]
    #[Assert\Length(min: 25, minMessage:"Ce message est trop court")]
     private ?string $message = null;

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Contact
     */
    public function setLastname(string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Contact
     */
    public function setFirstname(string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

}