<?php

namespace App\Image;

use Intervention\Image\ImageManager;

class Manipulator
{
    protected $manager;

    protected $config;

    protected $image;

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
        $this->config = app('config');
    }

    public function load($file)
    {
        $this->image = $this->manager->make($file);

        return $this;
    }

    public function withFilters(array $filters)
    {

        $this->applyFilters($filters);

        return $this;
    }

    public function stream()
    {
        return $this->image->stream();
    }

    protected function applyFilters(array $filters)
    {
        $availableFilters = $this->config->get('image.filters');

        foreach ($filters as $filter => $options) {
            if (!in_array($filter, array_keys($availableFilters))) {
                continue;
            }

            $this->image = (new $availableFilters[$filter]($this->image))->apply(explode(',', $options));
        }
    }
}
