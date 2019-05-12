<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter\NumberFormat;

use KejawenLab\Semart\Surat\Contract\Letter\NumberFormatInterface;
use KejawenLab\Semart\Surat\Sequence\RomanNumberConverter;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class YearNumberFormat implements NumberFormatInterface
{
    private const FORMAT = 'YEAR';
    private const FORMAT_LONG = 'YEAR_LONG';
    private const FORMAT_ROMAN = 'YEAR_ROMAN';
    private const FORMAT_ROMAN_LONG = 'YEAR_ROMAN_LONG';

    /**
     * @param string $format
     *
     * @return string
     */
    public function getNumber(string $format): string
    {
        $format = Str::make($format);
        if ($format->equals(static::FORMAT)) {
            return (string) date('y');
        }

        if ($format->equals(static::FORMAT_LONG)) {
            return (string) date('Y');
        }

        if ($format->equals(static::FORMAT_ROMAN)) {
            return RomanNumberConverter::convert((int) date('y'));
        }

        if ($format->equals(static::FORMAT_ROMAN_LONG)) {
            return RomanNumberConverter::convert((int) date('Y'));
        }

        throw new FormatNotAcceptedException();
    }

    public function support(string $format): bool
    {
        $format = Str::make($format);
        if (!$format->contains(static::FORMAT)) {
            return false;
        }

        return true;
    }
}
