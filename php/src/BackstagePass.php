<?php

namespace Arola\GildedRose;

class BackstagePass extends Article
{
    public function update()
    {
        $this->decreaseSellIn($this->item);
        $this->increaseQuality($this->item);

        if ($this->item->sell_in < 11) {
            $this->increaseQuality($this->item);
        }
        if ($this->item->sell_in < 6) {
            $this->increaseQuality($this->item);
        }

        if ($this->item->sell_in < 0) {
            $this->item->quality = 0;
        }
    }
}