<?php

namespace Arola\GildedRose;

class GildedRose {
    /**
     * @var Item[]
     */
    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            if ($item->name == 'Aged Brie') {
                $this->decreaseSellIn($item);
                $this->increaseQuality($item);
                if ($item->sell_in < 0) {
                    $this->increaseQuality($item);
                }
            } elseif ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                $this->decreaseSellIn($item);
                $this->increaseQuality($item);

                if ($item->sell_in < 11) {
                    $this->increaseQuality($item);
                }
                if ($item->sell_in < 6) {
                    $this->increaseQuality($item);
                }

                if ($item->sell_in < 0) {
                    $item->quality = 0;
                }
            } elseif ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $this->decreaseSellIn($item);
                if ($item->quality > 0) {
                    $this->decreaseQuality($item);
                }

                if ($item->sell_in < 0) {
                    if ($item->quality > 0) {
                        $this->decreaseQuality($item);
                    }
                }
            }

        }
    }

    /**
     * @param Item $item
     */
    private function decreaseQuality(Item $item)
    {
        $item->quality = $item->quality - 1;
    }

    /**
     * @param Item $item
     */
    private function increaseQuality(Item $item)
    {
        if ($item->quality < 50) {
            $item->quality = $item->quality + 1;
        }
    }

    /**
     * @param Item $item
     */
    private function decreaseSellIn(Item $item)
    {
        $item->sell_in = $item->sell_in - 1;
    }
}

