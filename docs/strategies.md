
# Supported strategies

Currently, there're 7 strategies supported by Mapper:

* [`DataMapper\Strategy\ChainStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ChainStrategy.php)
which contains the chain of strategies that pass the last mapped value to next strategy call.
You can use it to combine behaviour of different strategies.

* [`DataMapper\Strategy\GetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/GetterStrategy.php)
which calls source object property method to extract value.

* [`DataMapper\Strategy\FormatterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/FormatterStrategy.php)
which calls source object method and pass value in to extract value.

* [`DataMapper\Strategy\XPathGetterStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/XPathGetterStrategy.php)
which converts source value to array and scan and extract required value from last xpath property name.

* [`DataMapper\Strategy\ClosureStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/ClosureStrategy.php)
which applies closure function to source property value.

* [`DataMapper\Strategy\CollectionStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/CollectionStrategy.php) which converts  property with object to another object. 

* [`DataMapper\Strategy\SerializerStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/Strategy/SerializerStrategy.php) which maps array to object by array keys. Can create array of objects and support deep mapping.
 