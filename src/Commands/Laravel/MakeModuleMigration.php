<?php

namespace Hesammousavi\LaravelModuleCreator\Commands\Laravel;

use Hesammousavi\LaravelModuleCreator\Traits\RequireModule;
use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand as LaravelMigrationCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;

class MakeModuleMigration extends Command
{
    use RequireModule;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'm:make:migration
        {module : The name of the module}
        {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file for the module';


    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    public function __construct(Composer $composer ,Filesystem $filesystem)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->file = $filesystem;
    }

    public function handle()
    {
        $this->checkModuleExists();

        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = Str::snake(trim($this->input->getArgument('name')));

        $table = $this->input->getOption('table');

        $create = $this->input->getOption('create') ?: false;

        // If no table was given as an option but a create option is given then we
        // will use the "create" option as the table name. This allows the devs
        // to pass a table name into this option as a short-cut for creating.
        if (! $table && is_string($create)) {
            $table = $create;

            $create = true;
        }

        // Next, we will attempt to guess the table name if this the migration has
        // "create" in the name. This will allow us to provide a convenient way
        // of creating migrations that create new tables for the application.
        if (! $table) {
            [$table, $create] = TableGuesser::guess($name);
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $table, $create);

        $this->composer->dumpAutoloads();
    }

    /**
     * Write the migration file to disk.
     *
     * @param  string  $name
     * @param  string  $table
     * @param  bool  $create
     * @print string
     */
    protected function writeMigration($name, $table, $create)
    {
        $creator = new MigrationCreator($this->file , '');

        $file = $creator->create(
            $name, $this->getMigrationPath(), $table, $create
        );

        $this->line("<info>Created Migration:</info> {$file}");
    }

    protected function getMigrationPath()
    {
        if (! is_null($targetPath = $this->input->getOption('path'))) {
            return $this->laravel->basePath().'/'.$targetPath;
        }

        return base_path("modules/{$this->argument('module')}/src/Database/Migrations");
    }

}
