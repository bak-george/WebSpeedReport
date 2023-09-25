<?php

namespace Core;

class Bytes
{
    protected $bytes;
    protected $bandwidth;

    public function __construct($bytes = null, $bandwidth = null)
    {
        $this->setBytes($bytes);
        $this->setBandwidth($bandwidth);
    }

    public function setBytes($bytes)
    {
        $this->bytes = $bytes;
    }

    public function setBandwidth($bandwidth)
    {
        $this->bandwidth = $bandwidth;
    }

    public function toKB($value = null)
    {
        return $this->convertToBase($value, 1);
    }

    public function toMB($value = null)
    {
        return $this->convertToBase($value, 2);
    }

    public function toGB($value = null)
    {
        return $this->convertToBase($value, 3);
    }

    private function convertToBase($value, $power)
    {
        return $value / (1_024 ** $power);
    }

    public function bandwidthToKBps()
    {
        return $this->toKB($this->bandwidth);
    }

    public function bandwidthToMBps()
    {
        return $this->toMB($this->bandwidth);
    }

    public function bandwidthToGBps()
    {
        return $this->toGB($this->bandwidth);
    }
}
