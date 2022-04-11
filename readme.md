Laravel package for Create Laravel Modules from a template

# Requirements
Laravel 9 and PHP 8.0

# Install

You can install the package via composer:
```bash
composer require hesammousavi/laravel-module-creator
```

# Usage

first you must create your module

```bash
php artisan module:make Roocket/User
```

finally, run this code :

```
composer update
```

beautifully done


# Your Module Commands 

you have different commands to do anything with your module
```bash
    php artisan
```

you can see these commands for your usage

```
 module
  module:make                   create a new module to develop project
  module:make:controller        Create a new controller class for module
  module:make:graphql-mutation  Create a new Graphql Mutation class for the module
  module:make:graphql-query     Create a new Graphql Query class for the module
  module:make:graphql-type      Create a new Graphql Type class for the module
  module:make:migration         Create a new migration file for the module
  module:make:model             Create a new Eloquent model class for module
  module:make:repo              Create a new repo class for the module
  module:make:seeder            Create a new Seeder class for module
  module:make:rule              Create a new Rule Validation class for module
  module:make:event             Create a new Event class for the module
  module:make:listener            Create a new Listener class for module
```


you can build model for your module like

```bash
php artisan module:make:model <module-namespace> <model-name>
php artisan module:make:model Roocket/user User  
```
