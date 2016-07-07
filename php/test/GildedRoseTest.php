<?php

use Arola\GildedRose\AgedBrie;
use Arola\GildedRose\BackstagePass;
use Arola\GildedRose\ConjuredItem;
use Arola\GildedRose\GenericItem;
use Arola\GildedRose\GildedRose;
use Arola\GildedRose\Item;
use Arola\GildedRose\Sulfuras;
use Arola\GildedRose\Article;

class GildedRoseTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    function it_returns_the_correct_name() {
        $items = [ new GenericItem(new Item("foo", 0, 0)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals("foo", $items[0]->getName());
    }

    /**
     * @test
     */
    function it_does_not_decrease_the_quality_after_it_has_reached_0() {
        /** @var Article[] $items */
        $items = [ new GenericItem(new Item("Non special item", -1, 0)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_does_not_decrease_the_quality_of_sulfuras() {
        /** @var Article[] $items */
        $items = [ new Sulfuras(new Item("Sulfuras, Hand of Ragnaros", 0, 80)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(80, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_decreases_the_quality_of_non_special_items_by_one_before_sell_date() {
        /** @var Article[] $items */
        $items = [ new GenericItem(new Item("Non special item", 2, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(9, $items[0]->getQuality());
    }


    /**
     * @test
     */
    function it_decreases_the_quality_of_non_special_items_by_two_after_sell_date() {
        /** @var Article[] $items */
        $items = [ new GenericItem(new Item("Non special item", 0, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(8, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_increases_the_quality_of_aged_brie_by_1_if_its_quality_is_under_50_and_its_sell_date_has_not_passed() {
        /** @var Article[] $items */
        $items = [ new AgedBrie(new Item("Aged Brie", 5, 33)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(34, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_increases_the_quality_of_aged_brie_by_2_if_its_quality_is_under_50_and_its_sell_date_has_passed() {
        /** @var Article[] $items */
        $items = [ new AgedBrie(new Item("Aged Brie", -1, 33)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(35, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_does_not_increase_the_quality_of_aged_brie_if_its_quality_is_50() {
        /** @var Article[] $items */
        $items = [ new AgedBrie(new Item("Aged Brie", -1, 50)) ];
        $gildedRose = $this->givenAGildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(50, $items[0]->getQuality());
    }


    /**
     * @test
     */
    function it_increases_the_quality_of_concert_tickets_by_1_when_there_are_more_than_10_days_left() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 8, 20)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(22, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_increases_the_quality_of_concert_tickets_by_2_when_there_are_between_10_and_5_days_left() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 8, 20)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(22, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_increases_the_quality_of_concert_tickets_by_3_when_there_are_between_5_and_0_days_left() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 4, 20)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(23, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_does_not_increases_the_quality_of_concert_tickets_past_50() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 2, 49)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(50, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_drops_the_quality_of_concert_tickets_to_0_when_sell_date_has_passed() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 0, 20)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(0, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_does_not_decrease_the_sell_in_date_of_sulfuras() {
        /** @var Article[] $items */
        $items = [ new Sulfuras(new Item("Sulfuras, Hand of Ragnaros", 10, 80)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(10, $items[0]->getSellIn());
    }


    /**
     * @test
     */
    function it_decreases_sell_in_value_if_not_sulfuras() {
        /** @var Article[] $items */
        $items = [ new GenericItem(new Item("Whatever", 5, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(4, $items[0]->getSellIn());
    }


    /**
     * @test
     */
    function it_decreases_sell_in_value_of_aged_brie() {
        /** @var Article[] $items */
        $items = [ new AgedBrie(new Item("Aged Brie", 5, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(4, $items[0]->getSellIn());
    }


    /**
     * @test
     */
    function it_decreases_sell_in_value_of_backstage() {
        /** @var Article[] $items */
        $items = [ new BackstagePass(new Item("Backstage passes to a TAFKAL80ETC concert", 5, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(4, $items[0]->getSellIn());
    }

    /**
     * @test
     */
    function it_decreases_the_quality_of_conjured_items_by_2_before_sell_date() {
        /** @var Article[] $items */
        $items = [ new ConjuredItem(new Item("Conjured item", 1, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(8, $items[0]->getQuality());
    }

    /**
     * @test
     */
    function it_decreases_the_quality_of_conjured_items_by_4_after_sell_date() {
        /** @var Article[] $items */
        $items = [ new ConjuredItem(new Item("Conjured item", 0, 10)) ];
        $gildedRose = $this->givenAGildedRose($items);

        $gildedRose->update_quality();

        $this->assertEquals(6, $items[0]->getQuality());
    }

    private function givenAGildedRose(array $items)
    {
        return new GildedRose($items);
    }
}
