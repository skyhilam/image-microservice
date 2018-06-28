<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Opacity extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->opacity($options[0] ?: 0);
    }
}
