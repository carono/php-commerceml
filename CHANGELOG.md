# 0.2.4
* Переименован метод \Zenwalker\CommerceML\Model\Classifier::getReferenceBookValue => getReferenceBookValueById
* Переименован метод defaultProperties в propertyAliases в базовом классе модели
* Добавлены тесты
* Добавлен метод getOffers у продукта, возращает все предложения, метод getOffer помечен как устаревший, будет исключен в 0.3.0
* Добавлен метод getOffersById у offerPackage, возращает все предложения, метод getOfferById помечен как устаревший, будет исключен в 0.3.0

# 0.2.3
* Исправлена ошибка при поиске xpath, поиск по ID сделан на точное совпадение, а не на частичное через contains