<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Rotate extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->rotate($options[0] ?: 0, $options[1] ?? 'ffffff');
    }
}
