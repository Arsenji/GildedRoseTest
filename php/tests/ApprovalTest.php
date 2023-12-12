<?php

declare(strict_types=1);

namespace Tests;

use ECSPrefix202306\Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;
use ApprovalTests\Approvals;

class ApprovalTest extends TestCase
{
    public function testUpdateQualityMethodCallsUpdateItem(): void
    {
        $itemA = new Item('ItemA', 1, 10);
        $itemB = new Item('ItemB', 2, 20);

        $gildedRose = new GildedRose([$itemA, $itemB]);
        $gildedRose->updateQuality();

        $this->assertSame(0, $itemA->sellIn);
        $this->assertSame(9, $itemA->quality);
        $this->assertSame(1, $itemB->sellIn);
        $this->assertSame(19, $itemB->quality);
    }

    public function testUpdateSulfuras(): void
    {
        $sulfuras = new Item('Sulfuras, Hand of Ragnaros', 5, 80);
        $gildedRose = new GildedRose([$sulfuras]);
        $gildedRose->updateQuality();

        $this->assertSame(5, $sulfuras->sellIn);
        $this->assertSame(80, $sulfuras->quality);
    }

    function testQualityNeverIncreasesMoreThan50()
    {
        $items = [
            $itemA = new Item('Aged Brie', 1, 50),
            $itemB = new Item('Aged Brie', 0, 50),
            $itemC = new Item('Backstage passes to a TAFKAL80ETC concert', 15, 50),
            $itemD = new Item('Backstage passes to a TAFKAL80ETC concert', 10, 50),
            $itemE = new Item('Backstage passes to a TAFKAL80ETC concert', 5, 50),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $itemA->quality);
        $this->assertEquals(50, $itemB->quality);
        $this->assertEquals(50, $itemC->quality);
        $this->assertEquals(50, $itemD->quality);
        $this->assertEquals(50, $itemE->quality);
    }

    public function testQuality(): void
    {
        $qualityMax = new Item('Aged Brie', 1, 50);
        $qualityMin = new Item('ItemMin', 1, 0);
        $gildedRose = new GildedRose([$qualityMax, $qualityMin]);
        $gildedRose->updateQuality();

        $this->assertEquals(0, $qualityMin->quality);
        $this->assertEquals(50, $qualityMax->quality);
    }

    public function testUpdateBackstagePassQuality(): void
    {
        $items = [
            $itemA = new Item('Backstage passes to a TAFKAL80ETC concert', 20, 8),
            $itemB = new Item('Backstage passes to a TAFKAL80ETC concert', 8, 10),
            $itemC = new Item('Backstage passes to a TAFKAL80ETC concert', 4, 11),
            $itemD = new Item('Backstage passes to a TAFKAL80ETC concert', -1, 11),
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertSame(9, $itemA->quality);
        $this->assertSame(12, $itemB->quality);
        $this->assertSame(14, $itemC->quality);
        $this->assertSame(0, $itemD->quality);
    }

    public function testUpdateExpiredItemForAgedBrieIncreasesQuality(): void
    {
        $agedBrie = new Item('Aged Brie', -1, 30);
        $gildedRose = new GildedRose([$agedBrie]);

        $gildedRose->updateQuality();

        $this->assertEquals(31, $agedBrie->quality);
    }

    public function testUpdateExpiredItemForBackstagePassSetsQualityToZero(): void
    {
        $backstagePass = new Item('Backstage passes to a TAFKAL80ETC concert', -1, 25);
        $gildedRose = new GildedRose([$backstagePass]);

        $gildedRose->updateQuality();

        $this->assertEquals(0, $backstagePass->quality);
    }

    public function testUpdateExpiredItemForDefaultDecreasesQuality(): void
    {
        $item = new Item('ItemA', -1, 15);
        $gildedRose = new GildedRose([$item]);

        $gildedRose->updateQuality();

        $this->assertEquals(14, $item->quality);
    }
}
