[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/carono/php-commerceml/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/carono/php-commerceml/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/carono/php-commerceml/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/carono/php-commerceml/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/carono/php-commerceml/badges/build.png?b=master)](https://scrutinizer-ci.com/g/carono/php-commerceml/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/carono/commerceml/v/stable)](https://packagist.org/packages/carono/commerceml)
[![Total Downloads](https://poser.pugx.org/carono/commerceml/downloads)](https://packagist.org/packages/carono/commerceml)
[![License](https://poser.pugx.org/carono/commerceml/license)](https://packagist.org/packages/carono/commerceml)

# PHP CommerceML

Библиотека для универсального парсинга [CommerceML2](http://v8.1c.ru/edi/edi_stnd/90/92.htm) файлов.

# Установка
`composer require carono/commerceml`

# Каталог и товары

```php
// $filePath - полный путь до XML файла import.xml или контент
$cml = new CommerceML();
$cml->loadImportXml('/fullpath/import.xml'); // Загружаем товары
$cml->loadOffersXml('/fullpath/offers.xml'); // Загружаем предложения
```

# Работа с товарами и предложениями

```php
foreach ($cml->products as $product){
    echo $product->name; // Выводим название товара (Товары->Товар->Наименование)
    foreach ($product->offers as $offer){
        echo $offer->name; // Выводим название предложения (Предложения->Предложение->Наименование)
        echo $offer->prices[0]->cost; // Выводим первую цену предложения (Предложения->Предложение->Цены->Цена->ЦенаЗаЕдиницу)
    }
}
```

## \Zenwalker\CommerceML\CommerceML  

|Метод|XML|Описание|
|-----|----|--------|
|catalog|Каталог|Объект каталога
|classifier|Классификатор|Объект классификатора
|offerPackage|ПакетПредложений|Объект предложений

## \Zenwalker\CommerceML\Model\OfferPackage

|Метод|XML|Описание|
|-----|----|--------|
|offers|Предложения->Предложение|Список всех предложений
|priceTypes|ТипыЦен->ТипЦены|Список всех типов цен

## \Zenwalker\CommerceML\Model\Product

|Метод|XML|Описание|
|-----|----|--------|
|properties|Каталог->Товары->Товар->ЗначенияСвойств|Свойства продукта, `$product->properties[0]->value`|
|requisites|Каталог->Товары->Товар->ЗначенияРеквизитов->ЗначениеРеквизита|Реквизиты продукта, `$product->requisites[0]->value`|
|offers|Предложения->Предложение|Список предложений для продукта
|group|Каталог->Товары->Товар->Группы=>Классификатор->группы->группа|Группа товара `$product->group->name` 
|images|Каталог->Товары->Товар->Картинка|Список картинок у товара

## \Zenwalker\CommerceML\Model\Offer

|Метод|XML|Описание|
|-----|----|--------|
|prices|Предложения->Предложение->Цены->Цена|Все цены предложения
|specifications|Предложения->Предложение->ХарактеристикиТовара->ХарактеристикаТовара|Список всех характеристик предложения