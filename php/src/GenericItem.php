<?php

namespace Arola\GildedRose;

class GenericItem extends Article
{
    public function update()
    {
        $this->decreaseSellIn($this->item);
        $this->decreaseQuality($this->item);

        if ($this->item->sell_in < 0) {
            $this->decreaseQuality($this->item);
        }
    }
}