<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Contract\Letter;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
interface NumberFormatInterface
{
    /**
     * @param string $format
     *
     * @return string
     */
    public function getNumber(string $format): string;

    /**
     * @param string $format
     *
     * @return bool
     */
    public function support(string $format): bool;
}
