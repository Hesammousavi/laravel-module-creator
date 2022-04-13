<?php

namespace Tests\Unit;

use Hesammousavi\LaravelModuleCreator\Helpers\ComposerParser;
use PHPUnit\Framework\TestCase;

class ComposerParserTest extends TestCase
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

    public function testAddingOption(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $require = $composerParser->getOption('require');
        $require['test/test'] = 'dev-main';
        $composerParser->setOption(
            'require',
            $require
        );

        $this->assertTrue(
            !is_null($composerParser->getOption('require'))
            && !is_null($composerParser->getOption('require')['illuminate/support'])
            && $composerParser->getOption('require')['test/test'] == 'dev-main'
        );
    }

    public function testSettingOptionSimple(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $composerParser->setOption('name', 'test/test');
        $name = $composerParser->getOption('name');

        $this->assertEquals('test/test', $name);
    }

    public function testSettingOptionArray(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $keywords = ['keyOne', 'keyTwo', 'keyThree'];
        $composerParser->setOption('keywords', $keywords);
        $resultKeywords = $composerParser->getOption('keywords');

        $this->assertEquals($keywords[0], $resultKeywords[0]);
        $this->assertEquals($keywords[1], $resultKeywords[1]);
        $this->assertEquals($keywords[2], $resultKeywords[2]);
    }

    public function testSettingOptionObject(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $composerParser->setOption('require', [
            'test/test' => 'dev-main',
        ]);
        $require = $composerParser->getOption('require');

        $this->assertTrue(!is_null($require['test/test']) && $require['test/test'] == 'dev-main');
    }

    public function testSettingOptionComplex(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $composerParser->setOption('extra', [
            'test' => [
                'providers' => [
                    'one',
                    'two',
                    'three',
                ]
            ],
        ]);
        $extra = $composerParser->getOption('extra');

        $this->assertTrue($extra['test'] === ['providers' => ['one', 'two', 'three']]);
    }

    public function testGettingOption(): void
    {
        $composerParser = new ComposerParser(self::composerFileName);
        $name = $composerParser->getOption('name');

        $this->assertEquals('hesammousavi/laravel-module-creator', $name);
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