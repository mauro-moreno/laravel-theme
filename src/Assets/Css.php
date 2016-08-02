<?php

namespace MauroMoreno\LaravelTheme\Assets;

class Css extends AbstractAsset
{
    public function toStr()
    {
        return '<link media="all" type="text/css" rel="stylesheet" href="'.$this->url().'">'."\n";
    }
}