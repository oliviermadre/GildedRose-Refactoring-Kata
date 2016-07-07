<?php

namespace Arola\GildedRose;

abstract class Article
{
    /**
     * @var Item
     */
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    abstract public function update();

    /**
     * @param Item $item
     */
    protected function decreaseQuality(Item $item)
    {
        if ($this->item->quality > 0) {
            $item->quality = $item->quality - 1;
        }
    }

    /**
     * @param Item $item
     */
    protected function increaseQuality(Item $item)
    {
        if ($item->quality < 50) {
            $item->quality = $item->quality + 1;
        }
    }

    /**
     * @param Item $item
     */
    protected function decreaseSellIn(Item $item)
    {
        $item->sell_in = $item->sell_in - 1;
    }

    public function getSellIn()
    {
        return $this->item->sell_in;
    }

    public function getQuality()
    {
        return $this->item->quality;
    }

    public function getName()
    {
        return $this->item->name;
    }
}