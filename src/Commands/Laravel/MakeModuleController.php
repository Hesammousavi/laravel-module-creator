<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Laravel;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleController extends ControllerMakeCommand
{
    use RequireModule;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'm:make:controller';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'm:make:controller';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class for module';

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
     * Generate the form requests for the given model and classes.
     *
     * @param  string  $modelClass
     * @param  string  $storeRequestClass
     * @param  string  $updateRequestClass
     * @return array
     */
    protected function generateFormRequests($modelClass, $storeRequestClass, $updateRequestClass)
    {
        $storeRequestClass = 'Store'.class_basename($modelClass).'Request';

        $this->call('m:make:request', [
            'module' => $this->argument('module'),
            'name' => $storeRequestClass,
        ]);

        $updateRequestClass = 'Update'.class_basename($modelClass).'Request';

        $this->call('m:make:request', [
            'module' => $this->argument('module'),
            'name' => $storeRequestClass,
        ]);

        return [$storeRequestClass, $updateRequestClass];
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
