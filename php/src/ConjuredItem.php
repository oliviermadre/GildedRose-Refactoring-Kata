<?php

namespace Arola\GildedRose;

class ConjuredItem extends GenericItem
{
    public function __construct($sellIn, $quality)
    {
        $this->item = new Item('Conjured Item', $sellIn, $quality);
    }

    protected function decreaseQuality(Item $item)
    {
        parent::decreaseQuality($item);
        parent::decreaseQuality($item);
    }

}