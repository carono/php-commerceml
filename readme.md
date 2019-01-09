[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/carono/php-commerceml/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/carono/commerceml/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/carono/php-commerceml/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/carono/php-commerceml/?branch=master)
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
$cml->loadImportXml($xmlFilePath);
```
