# Kiichi PHP Generator

Simple Package PHP for generate controllers, models and middlewares.

***

### Specifications and Dependencies

- **PHP Version** >= 8.2.0

#### install packages

Run the composer command for install this package.

```
composer require devvime/kiichi-php-generator --dev
```

### Create folder structure

Create the following directories in the project root:

```
├── application
|  ├── Controllers
|  |── Models
|  |── Middlewares
|  |── Routes
|  |  └── server.php
```

### Create Controller

To create a new controller with the assistant, just type the following command, informing the name of the controller and the name of the database table that will be used
EX: php kiichi.phar new-controller controllerName tableName.

```bash
php kiichi.phar new-controller product products
```

```
├── application
|  ├── Controllers
│  |  └── ProductController.php
|  |── Models
|  |  └── Products.php
```

To create the route group in the application/Routes/api.php file add --route /routeGroupName

```bash
php kiichi.phar new-controller product products --route /products
```

Result:

```
├── application
|  ├── Controllers
│  |  └── ProductController.php
|  |── Models
|  |  └── Products.php
|  |── Routes
|  |  └── server.php
```

### Create Middleware

To create a new middleware with the wizard, just type the following command informing the name of the middleware.

```
php kiichi.phar new-middleware product
```

Result:

```
├── application
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
├── application
|  ├── Controllers
│  |  └── EmailServiceController.php
```

### Start the development server

Type the following command.

```
php kiichi.phar start
```

Result:

```
Development Server (http://localhost:8080) started
```

