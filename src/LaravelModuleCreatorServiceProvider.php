<?php namespace Hesammousavi\LaravelModuleCreator;

use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModule;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleController;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleGraphqlMutation;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleGraphqlQuery;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleGraphqlType;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleMigration;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleModel;
use Hesammousavi\LaravelModuleCreator\Console\Commands\MakeModuleSeeder;
use Illuminate\Support\ServiceProvider;

class LaravelModuleCreatorServiceProvider extends  ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
    }

    public function registerCommands()
    {
        $this->commands([
            MakeModule::class,
            MakeModuleMigration::class,
            MakeModuleModel::class,
            MakeModuleSeeder::class,
            MakeModuleController::class,
            MakeModuleGraphqlType::class,
            MakeModuleGraphqlMutation::class,
            MakeModuleGraphqlQuery::class
        ]);
    }

}
