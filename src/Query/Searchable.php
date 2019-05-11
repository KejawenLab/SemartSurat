<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Query;

/**
 * @Annotation()
 * @Target({"CLASS"})
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Searchable
{
    private $fields = [];

    public function __construct(array $configs = [])
    {
        if (isset($configs['fields']) && \is_array($configs['fields'])) {
            $this->fields = \array_values($configs['fields']);
        }

        if (isset($configs['value'])) {
            $this->fields = \array_values($configs['value']);
        }
    }

    public function getFields()
    {
        return $this->fields;
    }
}
