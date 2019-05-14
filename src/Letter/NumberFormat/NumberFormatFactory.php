<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter\NumberFormat;

use KejawenLab\Semart\Collection\Collection;
use KejawenLab\Semart\Surat\Contract\Letter\FormatNotAcceptedException;
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
        /** @var NumberFormatInterface $formatter */
        $formatter = Collection::collect($this->formatters)
            ->filter(function ($value) use ($format) {
                /** @var NumberFormatInterface $value */
                if ($value->support($format)) {

                    return true;
                }

                return false;
            })
            ->last()
        ;

        if (!$formatter) {
            throw new FormatNotAcceptedException();
        }

        return $formatter->getNumber($format);
    }
}
