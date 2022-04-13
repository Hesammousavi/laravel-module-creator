<?php

namespace Hesammousavi\LaravelModuleCreator\Exceptions\File;

use Exception;
use Hesammousavi\LaravelModuleCreator\Helpers\File;

class FileNotExistException extends Exception
{
    public function __construct(File $file)
    {
        parent::__construct('requested file does not exist: ' . $file->getFilePath());
    }
}