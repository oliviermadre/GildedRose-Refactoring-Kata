<?php

namespace Arola\GildedRose;

class AgedBrie extends Article
{
    public function update()
    {
        $this->decreaseSellIn($this->item);
        $this->increaseQuality($this->item);
        
        if ($this->item->sell_in < 0) {
            $this->increaseQuality($this->item);
        }
    }
}