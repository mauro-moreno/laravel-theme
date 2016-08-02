<?php

namespace MauroMoreno\LaravelTheme\Assets;

use MauroMoreno\LaravelTheme\Themes;
use MauroMoreno\LaravelTheme\Tree\Item;

/**
 * Class AbstractAsset
 *
 * @package MauroMoreno\LaravelTheme\Assets
 */
abstract class AbstractAsset extends Item
{
    public $name;
    public $alias;
    private $picked = false;

    /**
     * AbstractAsset constructor.
     * @param $name
     * @param string $alias
     */
    public function __construct($name, $alias = '')
    {
        $this->name = $name;
        $this->alias = $alias ? $alias : $name;
    }

    /**
     * Get Parent
     *
     * @return null
     */
    public function getParent()
    {
        if (!empty($this->parents)) {
            return $this->parents[0];
        } else {
            return null;
        }
    }

    /**
     * Dependencies
     *
     * @return array
     */
    public function dependencies()
    {
        $asset = $this;
        $data = [];
        do {
            array_unshift($data, $asset);
        } while ($asset = $asset->getParent());

        return $data;
    }

    /**
     * Write
     *
     * @param bool $onlyOnce
     *
     * @return string
     */
    public function write($onlyOnce = true)
    {
        $result = '';
        foreach ($this->dependencies() as $asset) {
            if (!$asset->picked) {
                $result .= $asset->toStr();
            }
            $asset->picked = $asset->picked || $onlyOnce;
        }
        return $result;
    }

    /**
     * URL
     *
     * @return string
     */
    public function url()
    {
        return Themes::url($this->name);
    }

    /**
     * To String
     *
     * @return mixed
     */
    public abstract function toStr();
}
