<?php

namespace Arola\GildedRose;

class ConjuredItem extends GenericItem
{
    protected function decreaseQuality(Item $item)
    {
        parent::decreaseQuality($item);
        parent::decreaseQuality($item);
    }

}