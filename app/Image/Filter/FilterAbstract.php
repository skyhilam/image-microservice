<?php

namespace App\Image\Filter;

use Intervention\Image\Image;

abstract class FilterAbstract
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }
}
