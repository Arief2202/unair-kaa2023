<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteUserAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        echo "Deleting 50 User Admin\n";
        foreach(User::where('nama', '=', 'Panitia Simulasi')->get() as $user){
            $user->delete();
        }
        echo "Done\n";
        return 0;
    }
}
