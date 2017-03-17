<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Symlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:themes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create synmlink for storage/app/themes folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir =  base_path();
        exec("sudo ln -s $dir/storage/app/themes $dir/public/");
    }
}
