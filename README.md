# Kiichi PHP Generator

Simple Package PHP for generate controllers, models and middlewares.

***

### Specifications and Dependencies

- **PHP Version** >= 8.2.0

#### install packages

Run the composer command for install this package.

```
composer require devvime/kiichi-php-generator
```

### Create folder structure

Create the following directories in the project root:

```
├── src
|  ├── Controllers
|  |── Models
|  |── Middlewares
|  |── Routes
|  |  └── api.php
```

### Create Controller

To create a new controller with the assistant, just type the following command, informing the name of the controller and the name of the database table that will be used
EX: php kiichi.phar new-controller controllerName tableName.

```bash
php kiichi.phar new-controller product products
```

```
├── src
|  ├── Controllers
│  |  └── ProductController.php
|  |── Models
|  |  └── Products.php
```

To create the route group in the src/Routes/api.php file add --route /routeGroupName

```bash
php kiichi.phar new-controller product products --route /products
```

Result:

```
├── src
|  ├── Controllers
│  |  └── ProductController.php
|  |── Models
|  |  └── Products.php
|  |── Routes
|  |  └── api.php
```

### Create Middleware

To create a new middleware with the wizard, just type the following command informing the name of the middleware.

```
php kiichi.phar new-middleware product
```

Result:

```
├── src
|  ├── Middlewares
│  |  └── ProductMiddleware.php
```

### Create new email controller

Type the following command.

```
php kiichi.phar new-mail
```

Result:

```
├── src
|  ├── Controllers
│  |  └── EmailServiceController.php
```