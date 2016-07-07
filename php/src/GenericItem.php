<?php

namespace Arola\GildedRose;

class GenericItem extends Article
{
    public function __construct($name, $sellIn, $quality)
    {
        $this->item = new Item($name, $sellIn, $quality);
    }

    public function update()
    {
        $this->decreaseSellIn($this->item);
        $this->decreaseQuality($this->item);

        if ($this->item->sell_in < 0) {
            $this->decreaseQuality($this->item);
        }
    }
}