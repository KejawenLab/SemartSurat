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
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="semart_setting", indexes={@ORM\Index(name="semart_setting_search_idx", columns={"parameter"})})
 * @ORM\Entity(repositoryClass="KejawenLab\Semart\Surat\Repository\SettingRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @Searchable({"parameter", "value"})
 * @Sortable({"parameter", "value"})
 *
 * @UniqueEntity(fields={"parameter"}, repositoryMethod="findUniqueBy", message="label.crud.non_unique_or_deleted")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Setting
{
    use BlameableEntity;
    use PrimaryableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="parameter", type="string", length=27)
     *
     * @Assert\Length(max=27)
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $parameter;

    /**
     * @ORM\Column(name="nilai", type="string", length=255)
     *
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $value;

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): void
    {
        $this->parameter = Str::make($parameter)->uppercase()->__toString();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }
}
