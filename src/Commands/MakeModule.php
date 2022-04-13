<?php

namespace Hesammousavi\LaravelModuleCreator\Commands;

use Hesammousavi\LaravelModuleCreator\Helpers\ModuleHandler;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MakeModule extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new module to develop project';

    protected $moduleName;

    protected $currentFile;

    public function handle()
    {
        $this->moduleName = $this->argument('name');

        $files = [
            'ServiceProvider.php' => [
                'name' => '{name}ServiceProvider',
                'namespace' => 'Providers',
                'stub' => __DIR__ . '/../Stubs/Providers/ServiceProvider.stub',
                'rootPath' => "/src/Providers/",
                'extensions' => 'php'
            ],
            'routes.php' => [
                'name' => 'routes',
                'stub' => __DIR__ . '/../Stubs/Routes.stub',
                'rootPath' => "/src/Routes/",
                'extensions' => 'php'
            ],
            'composer.json' => [
                'name' => 'composer',
                'stub' => __DIR__ . '/../Stubs/composer.stub',
                'rootPath' => "/",
                'extensions' => 'json',
            ]
        ];

        foreach ($files as $file => $meta) {
            $this->currentFile = $meta;
            parent::handle();
        }

        (new ModuleHandler($this->moduleName))->add();
    }

    public function getNameInput()
    {
        $name = substr( $this->argument('name'), strrpos( $this->argument('name'), '/') + 1);
        return str_replace('{name}' , $name , $this->currentFile['name']);
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceModuleNamesapce($stub , $name)
                    ->replaceClass($stub, $name);
    }


    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = substr( $name, strrpos( $name, '\\') + 1);

        return str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class, $stub);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceModuleNamesapce(&$stub, $name)
    {
        $namespace = str_replace('\\' , '\\\\', $this->rootNamespace());
        $namespaceName = Str::lower(str_replace('\\', '/' , $this->rootNamespace()));
        $moduleName = Arr::last(explode('\\', $namespace));

        $searches = [
            ['{{ moduleNamespace }}' , '{{ moduleNamespaceName }}' , '{{ moduleName }}'] ,
            ['{{moduleNamespace}}' , '{{moduleNamespaceName}}' , '{{moduleName}}']
        ];

        foreach ($searches as $search ) {
            $stub = str_replace($search, [ $namespace  , $namespaceName , $moduleName ], $stub);
        }

        return $this;
    }


    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $rootNamespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        if(isset($this->currentFile['namespace']))
            return "$rootNamespace\\{$this->currentFile['namespace']}";

        return $rootNamespace;
    }


    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return "{$this->getModulePath()}/{$this->getNameInput()}.{$this->currentFile['extensions']}";
    }

    protected function getStub()
    {
        return $this->currentFile['stub'];
    }

    protected function rootNamespace()
    {
        return str_replace('/' , '\\' , $this->moduleName);
    }

    protected function getModulePath()
    {
        return base_path("modules/{$this->moduleName}/{$this->currentFile['rootPath']}");
    }
}
