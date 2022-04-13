<?php

namespace Hesammousavi\LaravelModuleCreator\Helpers;

class ModuleHandler
{
    private $moduleName;
    private $composerFilePath;

    public function __construct(string $moduleName, string $composerFilePath = 'composer.json')
    {
        $this->moduleName = $moduleName;
        $this->composerFilePath = $composerFilePath;
    }

    public function add(): void
    {
        $this->addRequire();
        $this->addRepository();
    }

    private function addRequire()
    {
        $composerParser = new ComposerParser($this->composerFilePath);
        $require = $composerParser->getOption('require');
        $require[strtolower($this->moduleName)] = 'dev-main';
        $composerParser->setOption('require', $require);
    }

    private function addRepository()
    {
        $composerParser = new ComposerParser($this->composerFilePath);
        $repositories = $composerParser->getOption('repositories');
        if (!is_null($repositories)) {
            $repositories[] = $this->createRepository();
        } else {
            $repositories = [$this->createRepository()];
        }
        $composerParser->setOption('repositories', $repositories);
    }

    private function createRepository(): array
    {
        return [
            'type' => 'path',
            'url' => "modules/$this->moduleName",
        ];
    }
}