<?php

namespace Arola\GildedRose;

class Sulfuras extends Article
{
    public function __construct($sellIn, $quality)
    {
        $this->item = new Item("Sulfuras, Hand of Ragnaros", $sellIn, $quality);
    }

    public function update()
    {

    }
}
