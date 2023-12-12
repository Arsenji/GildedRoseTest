<?php

use GildedRose\GildedRose;
use GildedRose\Item;

require_once __DIR__ . '/../src/GildedRose.php';
require_once __DIR__ . '/../src/Item.php';

$items = [
    new Item('Aged Brie', 1, 30),
    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 20),
    // Добавьте другие товары, если необходимо
];

$gildedRose = new GildedRose($items);

$gildedRose->updateQuality();

print_r($items);
