<?php

namespace App\Cache;

use App\Cache\Contracts\CacheInterface;
use Illuminate\Redis\RedisManager as Predis;


class RedisCache implements CacheInterface
{
    protected $client;

    public function __construct(Predis $client)
    {
        $this->client = $client;
    }

    public function get($key)
    {
        return $this->client->get($key);
    }

    public function put($key, $value, $minutes = null)
    {
        if ($minutes === null) {
            $this->client->set($key, $value);
            return;
        }

        $this->client->setex($key, (int) max(1, $minutes * 60), $value);
    }

    public function remember($key, $minutes, callable $callback)
    {
        if (!is_null($value = $this->get($key))) {
            return $value;
        }

        $this->put($key, $value = $callback(), $minutes);

        return $value;
    }
}
