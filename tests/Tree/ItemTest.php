<?php

namespace MauroMoreno\LaravelTheme\Tests\Tree;

use MauroMoreno\LaravelTheme\Tree\Item;

function test_callback($test) {
    dd($test);
}

class ItemTest extends \PHPUnit_Framework_TestCase
{
    private $item;

    public function setUp()
    {
        $this->item = new Item;
    }

    public function testAddChild()
    {
        $itemChild = new Item;
        $this->item->addChild($itemChild);

        $this->assertEquals(0, count($this->item->parents));
        $this->assertEquals(1, count($this->item->children));
        $this->assertEquals($itemChild, $this->item->children[0]);
        $this->assertTrue($this->item->hasChild($itemChild));
        $this->assertFalse($itemChild->hasChild($this->item));
        $this->assertEquals(2, count($this->item->descendants()));
        $this->assertEquals(1, count($this->item->descendants(false)));
        $this->assertEquals(1, count($this->item->ancestors()));
        $this->assertEquals(0, count($this->item->ancestors(false)));

        $this->assertEquals(1, count($itemChild->parents));
        $this->assertEquals(0, count($itemChild->children));
        $this->assertEquals($this->item, $itemChild->parents[0]);
        $this->assertTrue($itemChild->hasParent($this->item));
        $this->assertFalse($this->item->hasParent($itemChild));
    }

    public function testAddParent()
    {
        $itemParent = new Item;
        $this->item->addParent($itemParent);

        $this->assertEquals(1, count($this->item->parents));
        $this->assertEquals(0, count($this->item->children));
        $this->assertEquals($itemParent, $this->item->parents[0]);
        $this->assertTrue($itemParent->hasChild($this->item));
        $this->assertFalse($this->item->hasChild($itemParent));
        $this->assertEquals(1, count($this->item->descendants()));
        $this->assertEquals(0, count($this->item->descendants(false)));
        $this->assertEquals(2, count($this->item->ancestors()));
        $this->assertEquals(1, count($this->item->ancestors(false)));

        $this->assertEquals(0, count($itemParent->parents));
        $this->assertEquals(1, count($itemParent->children));
        $this->assertEquals($this->item, $itemParent->children[0]);
        $this->assertTrue($this->item->hasParent($itemParent));
        $this->assertFalse($itemParent->hasParent($this->item));
    }
}
