<?php

namespace Tests\Unit;

use Exception;
use Hesammousavi\LaravelModuleCreator\Helpers\ComposerParser;
use Hesammousavi\LaravelModuleCreator\Helpers\ModuleHandler;
use PHPUnit\Framework\TestCase;

class ModuleHandlerTest extends TestCase
{
    const composerFileName = 'composer-test.json';

    protected function setUp(): void
    {
        parent::setUp();

        $this->copyComposerFile();
    }

    private function copyComposerFile(): void
    {
        copy('composer.json', self::composerFileName);
    }

    public function testAddingModule()
    {
        $moduleHandler = new ModuleHandler('Roocket/User', self::composerFileName);
        $moduleHandler->add();

        $composerParser = new ComposerParser(self::composerFileName);
        $require = $composerParser->getOption('require');
        $repositories = $composerParser->getOption('repositories');

        $this->assertTrue(!is_null($require['roocket/user']) && $require['roocket/user'] == 'dev-main');
        $this->assertTrue(!is_null($repositories));

        foreach ($repositories as $repository){
            if($repository['url'] == 'modules/Roocket/User'){
                return;
            }
        }
        throw new Exception('repository does not exist in composer file');
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->deleteComposerFile();
    }

    private function deleteComposerFile()
    {
        unlink(self::composerFileName);
    }
}