<?php

namespace MauroMoreno\LaravelTheme\Assets;

class Asset extends AbstractAsset
{
    public function toStr()
    {
        return $this->url() . "\r\n";
    }
}
