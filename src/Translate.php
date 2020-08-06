<?php

namespace Yong\Translate;

use Yong\Translate\Contracts\TranslateInterface;
use Yong\Translate\Traits\HasAttributes;

class Translate implements TranslateInterface
{
    use HasAttributes;

    /**
     * User constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getSrc()
    {
        return $this->getAttribute('src');
    }

    public function getDst()
    {
        return $this->getAttribute('dst');
    }

    public function getOriginal()
    {
        return $this->getAttribute('original');
    }
}
