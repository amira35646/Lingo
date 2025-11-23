<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true, nullable: false)]
    private ?string $username = null;

    #[ORM\Column(length: 180, unique: true, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(nullable: false)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $fullName = null;

    #[ORM\Column(enumType: UserRole::class)]
    private UserRole $role = UserRole::LEARNER;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $enabled = true;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nativeLanguage = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $targetLanguage = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $proficiencyLevel = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'participants')]
    private Collection $joinedRooms;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'readyUsers')]
    private Collection $readyRooms;

    /**
     * @var Collection<int, ChatSession>
     */
    #[ORM\ManyToMany(targetEntity: ChatSession::class, mappedBy: 'participants')]
    private Collection $chatSessions;

    public function __construct()
    {
        $this->joinedRooms = new ArrayCollection();
        $this->readyRooms = new ArrayCollection();
        $this->chatSessions = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): static
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function getNativeLanguage(): ?string
    {
        return $this->nativeLanguage;
    }

    public function setNativeLanguage(?string $nativeLanguage): static
    {
        $this->nativeLanguage = $nativeLanguage;
        return $this;
    }

    public function getTargetLanguage(): ?string
    {
        return $this->targetLanguage;
    }

    public function setTargetLanguage(?string $targetLanguage): static
    {
        $this->targetLanguage = $targetLanguage;
        return $this;
    }

    public function getProficiencyLevel(): ?string
    {
        return $this->proficiencyLevel;
    }

    public function setProficiencyLevel(?string $proficiencyLevel): static
    {
        $this->proficiencyLevel = $proficiencyLevel;
        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getJoinedRooms(): Collection
    {
        return $this->joinedRooms;
    }

    public function addJoinedRoom(Room $room): static
    {
        if (!$this->joinedRooms->contains($room)) {
            $this->joinedRooms->add($room);
            $room->addParticipant($this);
        }
        return $this;
    }

    public function removeJoinedRoom(Room $room): static
    {
        if ($this->joinedRooms->removeElement($room)) {
            $room->removeParticipant($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getReadyRooms(): Collection
    {
        return $this->readyRooms;
    }

    public function addReadyRoom(Room $room): static
    {
        if (!$this->readyRooms->contains($room)) {
            $this->readyRooms->add($room);
            $room->addReadyUser($this);
        }
        return $this;
    }

    public function removeReadyRoom(Room $room): static
    {
        if ($this->readyRooms->removeElement($room)) {
            $room->removeReadyUser($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, ChatSession>
     */
    public function getChatSessions(): Collection
    {
        return $this->chatSessions;
    }

    public function addChatSession(ChatSession $chatSession): static
    {
        if (!$this->chatSessions->contains($chatSession)) {
            $this->chatSessions->add($chatSession);
            $chatSession->addParticipant($this);
        }
        return $this;
    }

    public function removeChatSession(ChatSession $chatSession): static
    {
        if ($this->chatSessions->removeElement($chatSession)) {
            $chatSession->removeParticipant($this);
        }
        return $this;
    }

    // Business logic method
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;  // FIXED: was comparing to string 'ADMIN'
    }

    // Symfony Security interface implementations

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        // Convert enum value to string and prepend ROLE_
        $role = 'ROLE_' . strtoupper($this->role->value);
        return [$role];
    }

    public function eraseCredentials(): void
    {
        // Clear any temporary sensitive data
    }
}