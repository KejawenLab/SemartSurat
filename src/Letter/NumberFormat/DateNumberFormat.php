<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter\NumberFormat;

use KejawenLab\Semart\Surat\Contract\Letter\FormatNotAcceptedException;
use KejawenLab\Semart\Surat\Contract\Letter\NumberFormatInterface;
use KejawenLab\Semart\Surat\Sequence\RomanNumberConverter;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class DateNumberFormat implements NumberFormatInterface
{
    private const FORMAT = 'DATE';
    private const FORMAT_LONG = 'DATE_LONG';
    private const FORMAT_ROMAN = 'DATE_ROMAN';

    /**
     * @param string $format
     *
     * @return string
     */
    public function getNumber(string $format): string
    {
        $format = Str::make($format);
        if ($format->equals(static::FORMAT)) {
            return (string) date('j');
        }

        if ($format->equals(static::FORMAT_LONG)) {
            return (string) date('d');
        }

        if ($format->equals(static::FORMAT_ROMAN)) {
            return RomanNumberConverter::convert((int) date('j'));
        }

        throw new FormatNotAcceptedException();
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