# Kiitchi Generator

Simple Framework PHP for generate controllers, models and middlewares.

***

### Specifications and Dependencies

- **PHP Version** >= 7.0.0

#### install packages

Run the composer command for install this package.

```
composer require devvime/kiichi-generator
```

After, in composer.json insert this script.

```json
"scripts":{
        "new": "php -f vendor/devvime/KiitchiGenerator/src/KiitchiGenerator.php"
    }
```

### Create Controller

To create a new controller with the assistant, just type the following command, informing the name of the controller and the name of the database table that will be used -> EX: composer new controller controllerName tableName.

```
composer new controller product products
```

Result:

```
├── App
|  ├── Controllers
│  |  └── ProductController.php
|  |── Models
|  |  └── Products.php
```

### Create Middleware

To create a new middleware with the wizard, just type the following command informing the name of the middleware.

```
composer new middleware product
```

Result:

```
├── App
|  ├── Middlewares
│  |  └── ProductMiddleware.php
```

### Create new email controller

Type the following command informing the name of the mail controller.

```
composer new mail news
```

Result:

```
├── App
|  ├── Controllers
│  |  └── NewsController.php
```