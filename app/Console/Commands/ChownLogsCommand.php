<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Process;

class ChownLogsCommand extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:chown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta comando CHOWN a los archivos Logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (in_array(PHP_OS_FAMILY, ['Linux', 'macOS'])) {
            Process::run('chown www-data:www-data storage/logs/laravel*.log');
            Process::run('chown www-data:www-data storage/logs/**/*.log');
            $this->info('Ejecutado con exito comando chown a logs.');
        } else {
            $this->info('No se ejecuto comando chown de logs por no estar en Linux o MacOS');
        }
    }
}
