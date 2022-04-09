<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Custom;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleRepo extends GeneratorCommand
{
    use RequireModule;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make:repo';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'module:make:repo';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repo class for the module';
    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("modules/{$this->argument('module')}/src/Database/Repo") . '/' . str_replace('\\', '/', $name) . '.php';
    }
    
    protected function rootNamespace()
    {
        return str_replace('/', '\\', $this->argument('module')) . '\Database\Repo';
    }

    protected function getStub()
    {
        return __DIR__ . '/../../Stubs/Repo.stub';
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
