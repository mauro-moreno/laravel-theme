<?php

namespace MauroMoreno\LaravelTheme\Tree;

class Item
{
    // -----------[ Generic two way functions ]--------------
    const DIRECTION_PARENTS  = 1;
    const DIRECTION_CHILDREN = 2;

    public $children = [];
    public $parents  = [];

    /**
     * Adds a child to the item.
     *
     * @param Item $item
     *
     * @return Item
     */
    public function addChild(Item $item)
    {
        if (!in_array($item, $this->children)) {
            $this->children[] = $item;
            $item->parents[] = $this;
        }
        return $item;
    }

    /**
     * Adds a parent to the item.
     *
     * @param Item $item
     *
     * @return Item
     */
    public function addParent(Item $item)
    {
        $item->addChild($this);
        return $item;
    }

    /**
     * Has child.
     *
     * @param Item $item
     *
     * @return bool
     */
    public function hasChild(Item $item)
    {
        return $this->existsInTree($item, self::DIRECTION_CHILDREN);
    }

    /**
     * Has parent.
     *
     * @param Item $item
     *
     * @return bool
     */
    public function hasParent(Item $item)
    {
        return $this->existsInTree($item, self::DIRECTION_PARENTS);
    }

    /**
     * Return all descendants.
     *
     * @param bool $include_me
     *
     * @return array
     */
    public function descendants($include_me = true)
    {
        return $this->flattenTree($include_me, self::DIRECTION_CHILDREN);
    }

    /**
     * Return all ancestors.
     *
     * @param bool $include_me
     *
     * @return array
     */
    public function ancestors($include_me = true)
    {
        return $this->flattenTree($include_me, self::DIRECTION_PARENTS);
    }

    public function foreachChild($callback)
    {
        $this->foreachItem($callback, self::DIRECTION_CHILDREN);
    }

    public function foreachParent($callback, $include_me = true)
    {
        $this->foreachItem($callback, $include_me, self::DIRECTION_PARENTS);
    }

    public function searchChild($callback, $include_me = true)
    {
        return $this->search($callback, $include_me, self::DIRECTION_CHILDREN);
    }

    public function searchParent($callback)
    {
        return $this->search($callback, self::DIRECTION_PARENTS);
    }

    private function relations($direction)
    {
        if ($direction === self::DIRECTION_CHILDREN) {
            return $this->children;
        }

        if ($direction === self::DIRECTION_PARENTS) {
            return $this->parents;
        }
    }

    private function flattenTree($include_me, $direction)
    {
        $result = [];

        if ($include_me) {
            $result[] = $this;
        }

        foreach ($this->relations($direction) as $item) {
            $result = array_merge($result, $item->flattenTree(true, $direction));
        }

        return $result;
    }

    private function foreachItem($callback, $direction)
    {
        array_walk($this->relations($direction), $callback);
    }

    private function search($callback, $include_me, $direction)
    {
        if ($include_me && $result = $callback($this)) {
            return $result;
        }

        foreach ($this->relations($direction) as $item) {
            if ($result = $item->search($callback, true, $direction)) {
                return $result;
            }
        }

        return false;
    }

    /**
     * Search an item on the tree.
     *
     * @param Item $search
     * @param $direction
     *
     * @return bool
     */
    private function existsInTree(Item $search, $direction)
    {
        $return = false;

        if (in_array($search, $this->relations($direction))) {
            $return = true;
        }

        foreach ($this->relations($direction) as $item) {
            if ($item->existsInTree($search, $direction)) {
                $return = true;
                break;
            }
        }

        return $return;
    }
}
