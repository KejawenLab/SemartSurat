<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Entity;

class OutcomingLetter
{
    private $letter;

    private $to;

    private $copyLetter;

    public function getLetter(): ?Letter
    {
        return $this->letter;
    }

    public function setLetter(Letter $letter): void
    {
        $this->letter = $letter;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    public function getCopyLetter(): ?string
    {
        return $this->copyLetter;
    }

    public function setCopyLetter(string $copyLetter): void
    {
        $this->copyLetter = $copyLetter;
    }
}
