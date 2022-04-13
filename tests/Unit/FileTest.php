<?php

namespace Tests\Unit;

use Hesammousavi\LaravelModuleCreator\Exceptions\File\FileNotExistException;
use Hesammousavi\LaravelModuleCreator\Helpers\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase{
    const testFileName = 'test_file.txt';
    const testFileContent = 'test content';

    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestFile();
    }

    private function createTestFile()
    {
        $file = fopen(self::testFileName, 'w');
        fwrite($file, self::testFileContent);
        fclose($file);
    }

    public function testExceptionOnNotExistingFile()
    {
        $this->expectException(FileNotExistException::class);

        new File('dummy_name');
    }

    public function testReadFile()
    {
        $file = new File(self::testFileName);
        $content = $file->read();

        $this->assertTrue($content === self::testFileContent);
    }

    public function testWriteFile()
    {
        $file = new File(self::testFileName);
        $content = $file->read();

        $this->assertTrue($content === self::testFileContent);

        $newFileContent = 'new content';
        $file->write($newFileContent);
        $newContent = $file->read();

        $this->assertTrue($newContent == $newFileContent);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->deleteTestFile();
    }

    private function deleteTestFile()
    {
        unlink(self::testFileName);
    }
}