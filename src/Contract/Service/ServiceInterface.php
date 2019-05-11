<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Contract\Service;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
interface ServiceInterface
{
    public function get(string $id): ?object;
}
