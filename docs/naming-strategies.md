
# Supported naming strategies

Currently, there're 4 strategies supported by Mapper:

* [`DataMapper\Strategy\IdentityNamingStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/NamingStrategy/IdentityNamingStrategy.php)
which copy original name.

* [`DataMapper\Strategy\MapNamingStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/NamingStrategy/MapNamingStrategy.php)
which remap hydrated keys from_name -> new_name.

* [`DataMapper\Strategy\SnakeCaseNamingStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/NamingStrategy/SnakeCaseNamingStrategy.php)
which format original property name to match PSR snake case object properties names. Can be used for array to object conversion.

* [`DataMapper\Strategy\UnderscoreNamingStrategy`](https://github.com/vklymniuk/dto-mapper/blob/master/src/NamingStrategy/UnderscoreNamingStrategy.php)
which convert original name property to underscore format. Can be used for object to array extraction.
