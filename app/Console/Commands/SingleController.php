<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\TextUI\XmlConfiguration\CannotFindSchemaException;

class SingleController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:single-controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create all single controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        Artisan::call("make:controller $name"."/Index$name"."Controller");
        Artisan::call("make:controller $name"."/Create$name"."Controller");
        Artisan::call("make:controller $name"."/Show$name"."Controller");
        Artisan::call("make:controller $name"."/Update$name"."Controller");
        Artisan::call("make:controller $name"."/Delete$name"."Controller");
        Artisan::call("make:service Index ".$name." Index$name"."Service");
        Artisan::call("make:service-interface Index ".$name." Index$name"."ServiceInterface");
        Artisan::call("make:service Create ".$name." Create$name"."Service");
        Artisan::call("make:service-interface Create ".$name." Create$name"."ServiceInterface");
        Artisan::call("make:service Show ".$name." Show$name"."Service");
        Artisan::call("make:service-interface Show ".$name." Show$name"."ServiceInterface");
        Artisan::call("make:service Update ".$name." Update$name"."Service");
        Artisan::call("make:service-interface Update ".$name." Update$name"."ServiceInterface");
        Artisan::call("make:service Delete ".$name." Delete$name"."Service");
        Artisan::call("make:service-interface Delete ".$name." Delete$name"."ServiceInterface");
        Artisan::call("make:resource $name"."/".$name."Resource");
        Artisan::call("make:Request $name"."/Create".$name."Request");
        Artisan::call("make:Request $name"."/Update".$name."Request");
        Artisan::call("make:dto ".$name."DTO");
    }
}
