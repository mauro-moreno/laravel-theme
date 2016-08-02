<?php

namespace MauroMoreno\LaravelTheme\Assets;

class Js extends AbstractAsset
{
    public function toStr()
    {
		return '<script src="'.$this->url().'"></script>'."\n";
    }
}
