<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Pixelate extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->pixelate($options[0] ?: 0);
    }
}
