<?php

namespace Hesammousavi\LaravelModuleCreator\Helpers;

class ComposerParser
{
    private $file;

    public function __construct($composerFilePath = './composer.json')
    {
        $this->file = new File($composerFilePath);
    }

    public function getOption(string $key)
    {
        if(!array_key_exists($key, $this->decodeFile())) return null;

        return $this->decodeFile()[$key];
    }

    public function setOption(string $key, $value): void
    {
        $composerContent = $this->decodeFile();

        $composerContent[$key] = $value;

        $this->file->write(
            $this->encodeFile($composerContent)
        );
    }

    private function encodeFile($content): string
    {
        return json_encode($content, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    private function decodeFile()
    {
        return json_decode($this->file->read(), true);
    }
}