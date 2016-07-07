<?php

namespace Arola\GildedRose;

class GildedRose {
    /**
     * @var Article[]
     */
    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}
