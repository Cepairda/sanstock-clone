<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\File;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database Backup';

    /**
     * The process for Backup.
     *
     * @var string
     */
    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $path = storage_path() . '/app/' . config('settings-file.backup_folder');
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        $filename = 'backup-' . Carbon::now()->format('Y.m.d_H-i-s') . '.gz';
        $command = 'mysqldump' .
            ' --user=' . env('DB_USERNAME') .
            ' --password=' . env('DB_PASSWORD') .
            ' --host=' . env('DB_HOST') . ' ' . env('DB_DATABASE') .
            ' | gzip > ' . $path . '/' . $filename;

        $this->process = Process::fromShellCommandline($command);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->process->mustRun();

            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has been failed.');
        }
    }
}
