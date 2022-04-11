<?php

namespace Hesammousavi\LaravelModuleCreator\Helpers;

use Hesammousavi\LaravelModuleCreator\Exceptions\File\FileIsNotWritableException;
use Hesammousavi\LaravelModuleCreator\Exceptions\File\FileNotExistException;

class File
{
    private $filePath;

    /**
     * @throws FileNotExistException
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        $this->checkFileExistence();
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function read(): string
    {
        $content = $this->readFile();

        return $content;
    }

    /**
     * @throws FileIsNotWritableException
     */
    public function write(string $content): void
    {
        $this->checkIsFileWritable();
        $this->writeFile($content);
    }

    private function readFile(): string
    {
        return file_get_contents($this->filePath);
    }

    private function writeFile(string $content): void
    {
        file_put_contents($this->filePath, $content);
    }

    /**
     * @throws FileIsNotWritableException
     */
    private function checkIsFileWritable(): void
    {
        if (!is_writable($this->filePath)) throw new FileIsNotWritableException($this);
    }

    /**
     * @throws FileNotExistException
     */
    private function checkFileExistence(): void
    {
        if (!file_exists($this->filePath)) throw new FileNotExistException($this);
    }
}