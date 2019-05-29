<?php

namespace App\Image\Filter;

use App\Image\Filter\Contracts\FilterInterface;

class Resize extends FilterAbstract implements FilterInterface
{
    public function apply(array $options)
    {
        $w = $options[0] ?? null;
        $h = isset($options[1])? $options[1]: null;

        return $this->image->resize($w, $h, function ($constraint) use ($options) {
            if (!in_array('unaspect', $options)) {
                $constraint->aspectRatio();
            }

            if (in_array('upsize', $options)) {
                $constraint->upsize();
            }
        });
    }
}
