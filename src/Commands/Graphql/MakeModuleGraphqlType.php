<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Graphql;

use Hesammousavi\LaravelModuleCreator\Traits\GraphqlCommand;
use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModuleGraphqlType extends GeneratorCommand
{
    use RequireModule , GraphqlCommand;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make:graphql-type';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'module:make:graphql-type';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Graphql Type class for the module';
    
    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("modules/{$this->argument('module')}/src/Graphql/Types") . '/' . str_replace('\\', '/', $name) . '.php';
    }


    protected function rootNamespace()
    {
        return str_replace('/', '\\', $this->argument('module')) . '\Graphql\Types';
    }

    protected function getStub()
    {
        return __DIR__ . '/../Stubs/Graphql/type.stub';
    }
}
