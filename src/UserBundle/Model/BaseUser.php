<?php

namespace App\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseUser implements UserInterface
{
    /**
     * @ORM\Column(name="username", type="string", length=120, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="2",
     *     max="120",
     *     minMessage="Your username must be at least {{ limit }} characters long",
     *     maxMessage="Your username cannot be longer than {{ limit }} characters",
     *     allowEmptyString="false"
     * )
     */
    protected $username;

    /**
     * @ORM\Column(name="username_canonical", type="string", length=120, unique=true)
     */
    protected $usernameCanonical;

    /**
     * @ORM\Column(name="email", type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email(message="The email '{{ value }}' is not a valid email")
     * @Assert\Length(
     *     min="2",
     *     max="120",
     *     minMessage="Your email must be at least {{ limit }} characters long",
     *     maxMessage="Your email cannot be longer than {{ limit }} characters",
     *     allowEmptyString="false"
     * )
     */
    protected $email;

    /**
     * @ORM\Column(name="email_canonical", type="string", length=180, unique=true)
     */
    protected $emailCanonical;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled = true;

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @ORM\Column(name="confirmation_token", type="string", nullable=true)
     */
    protected $confirmationToken;

    /***********************************************************METHODS EDITED BY AUTHOR************************************************************/
    public function setUsernameCanonical(): self
    {
        $this->usernameCanonical = strtolower($this->username);

        return $this;
    }

    public function setEmailCanonical(): self
    {
        $this->emailCanonical = strtolower($this->email);

        return $this;
    }
    /***********************************************************END METHODS EDITED BY AUTHOR************************************************************/

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsernameCanonical(): ?string
    {
        return $this->usernameCanonical;
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

    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(\DateTimeInterface $passwordRequestedAt): self
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }
}