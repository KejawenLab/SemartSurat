<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Sequence;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class RomanNumberConverter
{
    /**
     * @param int $number
     *
     * @return string
     */
    public static function convert(int $number): string
    {
        $romanMap = ['I', 'IV', 'V', 'IX', 'X', 'XL', 'L', 'XC', 'C', 'CD', 'D', 'CM', 'M'];
        $decimalMap = [1, 4, 5, 9, 10, 40, 50, 90, 100, 400, 500, 900, 1000];

        $output = '';
        for ($i=12; $i>=0; $i--) {
            while($number >= $decimalMap[$i]) {
                $number -= $decimalMap[$i];
                $output .= $romanMap[$i];
            }
        }

        return $output;
    }
}
