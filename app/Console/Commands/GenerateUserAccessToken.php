<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user_access_token {user : The ID or email of the User} {name=Channex API : The name of generated token} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generate User Access Token for API.";

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
     * @return int
     */
    public function handle()
    {
        $user = $this->argument('user');

        if(is_numeric($user)){
            $user = User::find($user);
        } else if(is_string($user)){
            $user = User::where('email', $user)->first();
        }

        if(!$user){
            $this->error('No user found with the given key!');
            return 0;
        }

        $token = $user->createToken($this->argument('name'));

        $this->info("Access token generate successfully!");
        $this->info($this->argument('name') .": ". $token->plainTextToken);

        return 0;
    }
}
