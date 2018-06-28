<?php

return [
    
    'filters' => [
        'greyscale' => \App\Image\Filter\Greyscale::class,
        'brightness' => \App\Image\Filter\Brightness::class,
        'invert' => \App\Image\Filter\Invert::class,
        'resize' => \App\Image\Filter\Resize::class,
        'blur' => \App\Image\Filter\Blur::class,
        'colorize' => \App\Image\Filter\Colorize::class,
        'contrast' => \App\Image\Filter\Contrast::class,
        'crop' => \App\Image\Filter\Crop::class,
        'flip' => \App\Image\Filter\Flip::class,
        'opacity' => \App\Image\Filter\Opacity::class,
        'pixelate' => \App\Image\Filter\Pixelate::class,
        'rotate' => \App\Image\Filter\Rotate::class,
        'sharpen' => \App\Image\Filter\Sharpen::class,
        'abstractart' => \App\Image\Filter\AbstractArt::class,
    ]

];
