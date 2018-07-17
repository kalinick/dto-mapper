
---
title: Mapper strategies
---

# Supported strategies

Currently, 5 strategies are supported by Mapper:

* [`DataMapper\Strategy\ChainStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ChainStrategy.php)
which contains chain of strategies passes last value to next strategy class call.
You can use it to combine behaviour of different strategies.


* [`DataMapper\Strategy\GetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/GetterStrategy.php)
which calls source object method to extract or format value before injection to mapping destination.

* [`DataMapper\Strategy\XPathGetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/XPathGetterStrategy.php)
which convert source value to array and scan and extract required value from last xpath property name.

* [`DataMapper\Strategy\ClosureStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ClosureStrategy.php)
which apply closure function to source data.

* [`DataMapper\Strategy\CollectionStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/CollectionStrategy.php) which map array to object by array keys. Can create array of objects and support deeply mapping.   