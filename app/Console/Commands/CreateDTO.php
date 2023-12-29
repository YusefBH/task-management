<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class CreateDTO extends GeneratorCommand
{
    protected $signature = 'make:dto {name}';
    protected $description = 'Command description';

    public function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/DTO.stub';
    }


    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\DTO\\';
    }

    public function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace("hello", $this->argument('name'), $stub);
    }
}
