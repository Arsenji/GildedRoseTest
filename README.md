# Проект GildedRose

Этот проект представляет собой рефакторинг кода для системы учета товаров в магазине GildedRose.

## Запуск проекта

Прежде чем начать работу с проектом, необходимо убедиться в установленном PHP ^7.4 и Composer.

1. **Установка зависимостей:**

    ```bash
    composer install
    ```

2. **Запуск тестов:**

    ```bash
    vendor/bin/phpunit
    ```

3. **Использование:**
   Для использования GildedRose в своем проекте, создайте экземпляр класса `GildedRose` и передайте массив объектов `Item`. Затем вызовите метод `updateQuality` для обновления качества товаров. 

    ```php
    use GildedRose\GildedRose;
    use GildedRose\Item;

    $items = [
        new Item('Aged Brie', 5, 10),
        // Добавьте другие товары по необходимости
    ];

    $gildedRose = new GildedRose($items);
    $gildedRose->updateQuality();
    print_r($items);
    ```
    Либо можете запустить файл index.php в директории work, с помощью команды введенной в терминале:
    ```php index.php```
    ```
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
    ```

## Структура проекта

- `src/`: Исходный код проекта.
- `work/`: файл для запуска index.php.
- `tests/`: Тесты для проверки корректности работы кода.
- `fixtures/`: Дополнительные файлы и фикстуры, если необходимо.
