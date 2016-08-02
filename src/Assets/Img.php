<?php

namespace MauroMoreno\LaravelTheme\Assets;

class Img extends AbstractAsset
{
    public function toStr()
    {
        return '<img src="'.$this->url()."\">\r\n";
    }
}
