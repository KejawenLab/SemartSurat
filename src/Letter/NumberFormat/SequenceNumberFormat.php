<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter\NumberFormat;

use KejawenLab\Semart\Surat\Contract\Letter\NumberFormatInterface;
use KejawenLab\Semart\Surat\Sequence\SequenceService;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SequenceNumberFormat implements NumberFormatInterface
{
    private $sequenceService;

    private const FORMAT = 'SEQ_';

    public function __construct(SequenceService $sequenceService)
    {
        $this->sequenceService = $sequenceService;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getNumber(string $format): string
    {
        $format = Str::make($format);
        $namespace = $format->replace(static::FORMAT, '')->__toString();

        return $this->sequenceService->getLastNumber($namespace);
    }

    /**
     * @param string $format
     *
     * @return bool
     */
    public function support(string $format): bool
    {
        $format = Str::make($format);
        if (!$format->contains(static::FORMAT)) {
            return false;
        }

        return true;
    }
}
