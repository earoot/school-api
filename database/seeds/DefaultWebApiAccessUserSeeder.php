<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultWebApiAccessUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $data['email'] = config('app.default_api_user');
         $data['password'] = Hash::make(config('app.default_api_password'));
         $data['name'] = "API";

         if(isset($data['email']) && isset($data['password'])){
           User::truncate();
           User::create($data);
         } else {
           $this->command->error("ERROR: The DEFAULT_API_USER or DEFAULT_API_PASSWORD values must be set in .env file");
         }
     }
}
