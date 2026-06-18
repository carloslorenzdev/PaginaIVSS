<?php

use App\Console\Commands\ChownLogsCommand;
use App\Jobs\Sistema\BloquearUsuariosFuncionariosTask;
use App\Jobs\Sistema\CierraSesionesUsuarioTask;
use App\Jobs\Sistema\EliminaArchivosAntiguosTask;
use App\Jobs\Sistema\LimpiaCacheAutoloadTask;
use App\Jobs\Telegram\Activacion2faTask;
use App\Jobs\Telegram\VerificaServicioActivoTask;
use Illuminate\Support\Facades\Schedule;

// SISTEMA
Schedule::command(ChownLogsCommand::class)->environments(['production'])->everyFiveMinutes();
Schedule::job(LimpiaCacheAutoloadTask::class)->dailyAt('00:01');
Schedule::job(CierraSesionesUsuarioTask::class)->dailyAt('00:05');
Schedule::job(BloquearUsuariosFuncionariosTask::class)->dailyAt('00:10');
Schedule::job(EliminaArchivosAntiguosTask::class)->dailyAt('01:00');
// TELEGRAM
Schedule::job(VerificaServicioActivoTask::class)->everyFiveMinutes();
Schedule::job(Activacion2faTask::class)->everyTenSeconds();

// SCHEDULE 0005 hrs QUE CIERRE TODAS LAS SESIONES. LIMPIEZA DE TABLA DE SESIONS o ELIMINE ARCHIVOS. DEPENDIENDO DE SESSION_DRIVER
// JOB/SCHEDULE 0010 hrs para bloquear usuarios que no han iniciado sesión en lo ultimos 3 meses (SOLO USUARIOS FUNCIONARIOS)
// SCHEDULE cada min para actualizar la hora del servidor
    // sudo systemctl restart systemd-timesyncd
    // w32tm /resync
// JOB para enviar codigo al mensaje valido (correctamente escrito)
