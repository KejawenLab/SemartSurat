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
 * @ORM\Table(name="penomeran")
 * @ORM\Entity(repositoryClass="KejawenLab\Semart\Surat\Repository\SequenceRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @Searchable({"namespace", "code"})
 * @Sortable({"namespace", "code"})
 *
 * @UniqueEntity({"namespace", "code"})
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Sequence
{
    use BlameableEntity;
    use PrimaryableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="ruang_lingkup", type="string", length=9)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=9)
     *
     * @Groups({"read"})
     */
    private $namespace;

    /**
     * @ORM\Column(name="kode", type="string", length=9)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=9)
     *
     * @Groups({"read"})
     */
    private $code;

    /**
     * @ORM\Column(name="awalan_nol", type="boolean")
     *
     * @Groups({"read"})
     */
    private $zeroPrefix;

    /**
     * @ORM\Column(name="panjang_awalan", type="smallint")
     *
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $prefixLength;

    /**
     * @ORM\Column(name="angka_romawi", type="boolean")
     *
     * @Groups({"read"})
     */
    private $romanNumber;

    /**
     * @ORM\Column(name="nilai_terakhir", type="integer")
     *
     * @Groups({"read"})
     */
    private $lastValue;

    public function __construct()
    {
        $this->lastValue = 0;
        $this->zeroPrefix = true;
        $this->romanNumber = false;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = Str::make($namespace)->uppercase()->__toString();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = Str::make($code)->uppercase()->__toString();
    }

    public function isZeroPrefix(): bool
    {
        return $this->zeroPrefix;
    }

    public function setZeroPrefix(bool $zeroPrefix): void
    {
        $this->zeroPrefix = $zeroPrefix;
    }

    public function getPrefixLength(): ?int
    {
        return $this->prefixLength;
    }

    public function setPrefixLength(int $prefixLength): void
    {
        $this->prefixLength = $prefixLength;
    }

    public function isRomanNumber(): bool
    {
        return $this->romanNumber;
    }

    public function setRomanNumber(bool $romanNumber): void
    {
        $this->romanNumber = $romanNumber;
    }

    public function getLastValue(): ?int
    {
        return $this->lastValue;
    }

    public function setLastValue(int $lastValue): void
    {
        $this->lastValue = $lastValue;
    }

    public function next()
    {
        $this->lastValue++;
    }
}
