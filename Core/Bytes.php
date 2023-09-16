<?php

namespace Core;

class Bytes
{
    protected $bytes;

    public function __construct($bytes = null)
    {
        if ($bytes !== null) {
            $this->bytes = $bytes;
        }
    }

    public function setBytes($bytes)
    {
        $this->bytes = $bytes;
    }

    public function toKilobytes()
    {
        return $this->bytes / 1024;
    }

    public function toMegabytes()
    {
        return $this->toKilobytes() / 1024;
    }

    public function toGigabytes()
    {
        return $this->toMegabytes() / 1024;
    }
}
