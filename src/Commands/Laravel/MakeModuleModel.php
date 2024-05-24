<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Laravel;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand as LaravelMigrationCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleModel extends ModelMakeCommand
{
    use RequireModule;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'm:make:model';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'm:make:model';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class for module';

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call(MakeModuleMigration::class, [
            'module' => $this->argument('module'),
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call(MakeModuleController::class, array_filter([
            'name' => "{$controller}Controller",
            'module' => $this->argument('module'),
            '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            '--api' => $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'),
        ]));
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("modules/{$this->argument('module')}/src") . '/' . str_replace('\\', '/', $name) . '.php';
    }


    protected function rootNamespace()
    {
        return str_replace('/', '\\', $this->argument('module'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'the name of the module'],
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }
}
