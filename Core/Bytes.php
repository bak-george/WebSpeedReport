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

    public function conversionAndRound($function, $round) {
		return round($this->$function(), $round);
	}

    public static function instantiateConvertAndRound($byteValue, $function, $round) {
        $instance = new self($byteValue);
        return $instance->conversionAndRound($function, $round);
    }
}
