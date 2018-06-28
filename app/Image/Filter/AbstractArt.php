<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class AbstractArt extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        return $this->image->pixelate(30)->blur(50)->contrast(50);
    }
}
