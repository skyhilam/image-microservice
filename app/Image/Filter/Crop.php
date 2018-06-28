<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Crop extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->crop($options[0], $options[1], $options[2] ?? null, $options[3] ?? null);
    }
}
