<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use KejawenLab\Semart\Surat\Contract\Entity\PrimaryableTrait;
use KejawenLab\Semart\Surat\Query\Searchable;
use KejawenLab\Semart\Surat\Query\Sortable;
use PHLAK\Twine\Str;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="semart_pengguna", indexes={@ORM\Index(name="semart_pengguna_search_idx", columns={"nama_pengguna"})})
 * @ORM\Entity(repositoryClass="KejawenLab\Semart\Surat\Repository\UserRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @Searchable({"group.code", "group.name", "fullName", "username"})
 * @Sortable({"group.name", "fullName", "username"})
 *
 * @UniqueEntity(fields={"username"}, repositoryMethod="findUniqueBy", message="label.crud.non_unique_or_deleted")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class User implements UserInterface, \Serializable
{
    use BlameableEntity;
    use PrimaryableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="KejawenLab\Semart\Surat\Entity\Group")
     * @ORM\JoinColumn(name="grup_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     **/
    private $group;

    /**
     * @ORM\Column(name="nama_lengkap", type="string", length=77, nullable=true)
     *
     * @Assert\Length(max=77)
     *
     * @Groups({"read"})
     */
    private $fullName;

    /**
     * @ORM\Column(name="nama_pengguna", type="string", length=12, unique=true)
     *
     * @Assert\Length(max=17)
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $username;

    /**
     * @ORM\Column(name="kata_sandi", type="string")
     */
    private $password;

    private $plainPassword;

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): void
    {
        $this->group = $group;
    }

    public function getFullName(): string
    {
        return $this->fullName ?: $this->username;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = Str::make($fullName)->uppercase();
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = Str::make($username)->lowercase();
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->fullName,
            $this->username,
            $this->password,
            $this->group,
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->fullName, $this->username, $this->password, $this->group) = unserialize($serialized);
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }
}
