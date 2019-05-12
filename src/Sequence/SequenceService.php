<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Sequence;

use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Surat\Entity\Sequence;
use KejawenLab\Semart\Surat\Repository\SequenceRepository;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SequenceService implements ServiceInterface
{
    private $sequenceRepository;

    public function __construct(SequenceRepository $sequenceRepository)
    {
        $sequenceRepository->setCacheable(true);
        $this->sequenceRepository = $sequenceRepository;
    }

    /**
     * @param string $id
     *
     * @return Sequence|null
     */
    public function get(string $id): ?object
    {
        return $this->sequenceRepository->find($id);
    }

    /**
     * @param string $code
     *
     * @return string
     */
    public function getLastNumber(string $code): string
    {
        /** @var Sequence $sequence */
        $sequence = $this->sequenceRepository->findOneBy(['code' => $code]);
        if (!$sequence) {

            return '0';
        }
        $sequence->next();

        if ($sequence->isRomanNumber()) {

            return RomanNumberConverter::convert($sequence->getLastValue());
        }

        $prefix = '';
        for ($i = 0; $i < $sequence->getPrefixLength(); $i++) {
            $prefix = sprintf('%s%d', $prefix, 0);
        }

        return Str::make(sprintf('%s%s', $prefix, $sequence->getLastValue()))->substring(-1 * $sequence->getPrefixLength(), $sequence->getPrefixLength())->__toString();
    }
}
