# PHP-Framework

### PHP Framework Core


#### Installation

```
$ composer require alireza-h/php-framework
```


---


`index.php` file in web server root directory
```

require __DIR__ . '/../vendor/autoload.php';

use \Framework\Lib\FrontController;

FrontController::run(dirname(__DIR__));

```