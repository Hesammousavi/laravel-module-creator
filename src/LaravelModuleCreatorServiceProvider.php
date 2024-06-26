<?php namespace Hesammousavi\LaravelModuleCreator;


use Hesammousavi\LaravelModuleCreator\Commands\Custom\MakeModuleRepo;
use Hesammousavi\LaravelModuleCreator\Commands\Graphql\MakeModuleGraphqlMutation;
use Hesammousavi\LaravelModuleCreator\Commands\Graphql\MakeModuleGraphqlQuery;
use Hesammousavi\LaravelModuleCreator\Commands\Graphql\MakeModuleGraphqlType;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleController;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleResource;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleEvent;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleException;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleJob;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleListener;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleMigration;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleModel;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleNotification;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModulePolicy;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleRequest;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleRule;
use Hesammousavi\LaravelModuleCreator\Commands\Laravel\MakeModuleSeeder;
use Hesammousavi\LaravelModuleCreator\Commands\MakeModule;
use Illuminate\Support\ServiceProvider;

class LaravelModuleCreatorServiceProvider extends  ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
    }

    public function registerCommands()
    {
        $commands = [
            MakeModule::class,
            MakeModuleMigration::class,
            MakeModuleModel::class,
            MakeModuleSeeder::class,
            MakeModuleController::class,
            MakeModuleRepo::class,
            MakeModuleResource::class,
            MakeModuleRequest::class,
            MakeModulePolicy::class,
            MakeModuleRule::class,
            MakeModuleEvent::class,
            MakeModuleListener::class,
            MakeModuleJob::class,
            MakeModuleNotification::class,
            MakeModuleException::class
        ];

        if(class_exists("Rebing\GraphQL\Support\Facades\GraphQL")) {
            $commands = array_merge($commands, [
                MakeModuleGraphqlType::class,
                MakeModuleGraphqlMutation::class,
                MakeModuleGraphqlQuery::class
            ]);
        }

        $this->commands($commands);
    }

}
