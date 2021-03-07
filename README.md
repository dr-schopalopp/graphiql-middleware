# GraphiQL PSR-15 Middleware

[![Latest Version](https://img.shields.io/packagist/v/dr-schopalopp/graphiql-middleware.svg?style=flat-square)](https://packagist.org/packages/dr-schopalopp/graphiql-middleware)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Add a [GraphiQL](https://github.com/graphql/graphiql) interface to your application with this PSR-15 middleware.

This is basically a copy of [graphiql-middleware](https://github.com/rromanovsky/graphiql-middleware) adjusted for
PSR-15.

[![](image/screenshot.png)](https://graphql.org/swapi-graphql)

## Install

```shell
composer require dr-schopalopp/graphiql-middleware
```

## Usage

This middleware was developed in a slim project, but it should work with any other PSR-15 compatible framework.

### Slim

```php
// index.php

use DrSchopalopp\GraphiQLMiddleware\GraphiQLMiddleware;

// [...]

// Add Routing Middleware
$app->addRoutingMiddleware();

// [...]

// add middleware after the routing middleware
// to ensure it's reached first by the request  
$app->add(new GraphiQLMiddleware());
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
