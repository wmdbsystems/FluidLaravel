Allows you to use [Fluid](https://typo3.org/) seamlessly in [Laravel 5.1](http://laravel.com/).

# Requirements

Fluid >=X.X.X requires Laravel 5.1.

# Installation

Require this package with Composer

```bash
composer require wmdbsystems/fluidlaravel 1.0.x
```

Once Composer has installed or updated your packages you need to register FluidLaravel with Laravel itself. Open up config/app.php and find the providers key towards the bottom and add:

```php
'FoT3\FluidLaravel\ServiceProvider',
```

# Configuration

FluidLaravel's configuration file can be extended in your ConfigServiceProvider, under the `fluid` key. You can find the default configuration file at `vendor/wmdbsystems/fluidlaravel/config`.  

You _should_ use Artisan to copy the default configuration file from the `/vendor` directory to `/config/fluidlaravel.php` with the following command:

```bash
php artisan vendor:publish --provider="FoT3\FluidLaravel\ServiceProvider"
```

If you make changes to the `/config/fluidlaravel.php` file you will most likely have to run the `fluid:clean` Artisan command for the changes to take effect.

# Usage

You call the Fluid template like you would any other view:

```php
// Without the file extension
View::make('viewName', [...])
```

# Artisan Commands

FluidLaravel offers a command for CLI Interaction.

Empty the Fluid cache:
```
$ php artisan fluid:clean
```