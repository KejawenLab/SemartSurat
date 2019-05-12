<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter\NumberFormat;

use KejawenLab\Semart\Surat\Contract\Letter\NumberFormatInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class NumberFormatFactory
{
    /**
     * @var NumberFormatInterface[]
     */
    private $formatters;

    public function __construct(array $formatters = [])
    {
        $this->formatters = $formatters;
    }

    public function getNumber(string $format): string
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->support($format)) {
                return $formatter->getNumber($format);
            }
        }

        throw new FormatNotAcceptedException();
    }
}
