<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use KejawenLab\Semart\Surat\Contract\Entity\CodeNameableTrait;
use KejawenLab\Semart\Surat\Contract\Entity\PrimaryableTrait;
use KejawenLab\Semart\Surat\Query\Searchable;
use KejawenLab\Semart\Surat\Query\Sortable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="surat")
 * @ORM\Entity(repositoryClass="KejawenLab\Semart\Surat\Repository\LetterRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @Searchable({"code", "name"})
 * @Sortable({"code", "name"})
 *
 * @UniqueEntity({"code", "name"})
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Letter
{
    use CodeNameableTrait;
    use BlameableEntity;
    use PrimaryableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="format_penomeran", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @Groups({"read"})
     */
    private $numberFormat;

    /**
     * @ORM\Column(name="template_surat", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @Groups({"read"})
     */
    private $templatePath;

    /**
     * @ORM\Column(name="nomer_surat_terakhir", type="string", length=255)
     *
     * @Groups({"read"})
     */
    private $lastNumber;

    public function getNumberFormat(): ?string
    {
        return $this->numberFormat;
    }

    public function setNumberFormat(string $numberFormat): void
    {
        $this->numberFormat = $numberFormat;
    }

    public function getTemplatePath(): ?string
    {
        return $this->templatePath;
    }

    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = $templatePath;
    }

    public function getLastNumber(): ?string
    {
        return $this->lastNumber;
    }

    public function setLastNumber(string $lastNumber): void
    {
        $this->lastNumber = $lastNumber;
    }
}
