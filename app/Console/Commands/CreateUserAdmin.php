<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateUserAdmin';

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
        echo "Creating 50 User Admin\n";
        foreach(range(1, 50) as $num){
            User::create([
                'nama' => 'Panitia Simulasi',
                'email' => 'panitia'.$num.'@test.com',
                'password' => Hash::make('panitiasimulasi'),
                'role' => '2',
                'status' => '6',
            ]);
        }
        echo "Done\n";
        return 0;
    }
}
