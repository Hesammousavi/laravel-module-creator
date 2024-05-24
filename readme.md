Laravel package for Create Laravel Modules from a template

# Requirements
Laravel 9 or later
PHP 8.0 or later

# Install

You can install the package via composer:
```bash
composer require hesammousavi/laravel-module-creator
```

# Usage

first you must create your module

```bash
php artisan m:make Roocket/User
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
  m:make                   create a new module to develop project
  m:make:controller        Create a new controller class
  m:make:request           Create a new request class
  m:make:resource          Create a new resource class
  m:make:graphql-mutation  Create a new Graphql Mutation class
  m:make:graphql-query     Create a new Graphql Query class
  m:make:graphql-type      Create a new Graphql Type class
  m:make:migration         Create a new migration file
  m:make:model             Create a new Eloquent model class
  m:make:repo              Create a new repo class
  m:make:seeder            Create a new Seeder class
  m:make:rule              Create a new Rule Validation class
  m:make:event             Create a new Event class
  m:make:listener          Create a new Listener class
```


you can build model for your module like

```bash
php artisan m:make:model <module-namespace> <model-name>
php artisan m:make:model Roocket/user User
```
