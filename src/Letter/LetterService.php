<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Letter;

use KejawenLab\Semart\Surat\Contract\Letter\NumberFormatInterface;
use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Surat\Entity\Letter;
use KejawenLab\Semart\Surat\Letter\NumberFormat\NumberFormatFactory;
use KejawenLab\Semart\Surat\Repository\LetterRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class LetterService implements ServiceInterface
{
    private $letterRepository;

    private $formatter;

    public function __construct(LetterRepository $letterRepository, NumberFormatFactory $numberFormatFactory)
    {
        $letterRepository->setCacheable(true);
        $this->letterRepository = $letterRepository;
        $this->formatter = $numberFormatFactory;
    }

    /**
     * @param string $id
     *
     * @return Letter|null
     */
    public function get(string $id): ?object
    {
        return $this->letterRepository->find($id);
    }

    /**
     * ex: HR/[MONTH_ROMAN]/[YEAR_LONG]/PKWT/[SEQ_PKWT] => HR/IX/2019/PKWT/0001
     *
     * @param string $format
     *
     * @return string
     */
    public function getNumberFromFormat(string $format): string
    {
        preg_match_all('/\[(.*?)\]/', $format, $matches);
        $notations = $matches[0];
        $keywords = $matches[1];

        foreach ($keywords as $key => $keyword) {
            $keywords[$key] = $this->formatter->getNumber($keyword);
        }

        return str_replace($notations, $keywords, $format);
    }
}
