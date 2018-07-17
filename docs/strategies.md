
---
title: Mapper strategies
---

# Supported strategies

Currently, there're 5 strategies supported by Mapper:

* [`DataMapper\Strategy\ChainStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ChainStrategy.php)
which contains the chain of strategies that pass the last mapped value to next strategy call.
You can use it to combine behaviour of different strategies.


* [`DataMapper\Strategy\GetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/GetterStrategy.php)
which calls source object method to extract or format value before injection to mapping destination.

* [`DataMapper\Strategy\XPathGetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/XPathGetterStrategy.php)
which converts source value to array and scan and extract required value from last xpath property name.

* [`DataMapper\Strategy\ClosureStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ClosureStrategy.php)
which applies closure function to source data.

* [`DataMapper\Strategy\CollectionStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/CollectionStrategy.php) which maps array to object by array keys. Can create array of objects and support deep mapping. 