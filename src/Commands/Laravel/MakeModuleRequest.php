<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Laravel;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleRequest extends RequestMakeCommand
{
    use RequireModule;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'm:make:request';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'm:make:request';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request class for module';

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
