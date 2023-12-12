<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const AGED_BRIE = 'Aged Brie';
    private const BACKSTAGE_PASS = 'Backstage passes to a TAFKAL80ETC concert';
    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    private const MAX_QUALITY = 50;
    private const BACKSTAGE_PASS_DOUBLE_INCREASE_THRESHOLD = 10;
    private const BACKSTAGE_PASS_TRIPLE_INCREASE_THRESHOLD = 5;

    /**
     * @param Item[] $items
     * @throws \InvalidArgumentException
     */
    public function __construct(private array $items)
    {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    private function updateItem(Item $item): void
    {
        if ($item->name === self::SULFURAS) {
            return; // Sulfuras не меняется, нет необходимости обновлять
        }

        if ($item->sellIn < 0) {
            $this->updateExpiredItem($item);
        } else {
            $this->updateQualityBasedOnItemType($item);
            $item->sellIn--;
        }
    }


    private function updateQualityBasedOnItemType(Item $item): void
    {
        switch ($item->name) {
            case self::AGED_BRIE:
                $this->increaseQuality($item);
                break;
            case self::BACKSTAGE_PASS:
                $this->updateBackstagePassQuality($item);
                break;
            default:
                $this->decreaseQuality($item);
        }
    }

    private function increaseQuality(Item $item): void
    {
        if ($item->quality < self::MAX_QUALITY) {
            $item->quality++;
        }
    }

    private function decreaseQuality(Item $item): void
    {
        if ($item->quality > 0) {
            $item->quality--;
        }
    }

    private function updateBackstagePassQuality(Item $item): void
    {
        $this->increaseQuality($item);

        if ($item->sellIn < self::BACKSTAGE_PASS_DOUBLE_INCREASE_THRESHOLD) {
            $this->increaseQuality($item);
        }

        if ($item->sellIn < self::BACKSTAGE_PASS_TRIPLE_INCREASE_THRESHOLD) {
            $this->increaseQuality($item);
        }

        if ($item->sellIn < 0) {
            $item->quality = 0;
        }
    }

    private function updateExpiredItem(Item $item): void
    {
        switch ($item->name) {
            case self::AGED_BRIE:
                $this->increaseQuality($item);
                break;
            case self::BACKSTAGE_PASS:
                $item->quality = 0;
                break;
            default:
                $this->decreaseQuality($item);
        }
    }
}


