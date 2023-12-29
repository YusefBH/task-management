<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class CreateServiceInterface extends GeneratorCommand
{
    protected $signature = 'make:service-interface {index} {model} {name}';
    protected $description = 'Command description';
    protected $name = 'ddd';

    public function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/ServiceInterface.stub';
    }


    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services\\' . $this->argument('model') . "\\" . $this->argument('index') . $this->argument('model');
    }

    public function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace("hello", $this->argument('index') . $this->argument('model') . "ServiceInterface", $stub);
    }

}
