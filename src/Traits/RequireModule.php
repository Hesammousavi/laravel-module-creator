<?php namespace Hesammousavi\LaravelModuleCreator\Traits;

use Illuminate\Filesystem\Filesystem;

trait RequireModule
{
    public function checkModuleExists()
    {
        if(! (new Filesystem)->isDirectory(base_path("modules/{$this->argument('module')}")))
            throw new \Exception("{$this->argument('module')} module not found");
    }

    public function handle()
    {
        $this->checkModuleExists();

        parent::handle();
    }
}
