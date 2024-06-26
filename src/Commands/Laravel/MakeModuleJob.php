<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Laravel;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\JobMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleJob extends JobMakeCommand
{
    use RequireModule;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'm:make:job';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'm:make:job';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Job class for module';

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
