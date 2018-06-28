<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Sharpen extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->sharpen($options[0] ?: 0);
    }
}
