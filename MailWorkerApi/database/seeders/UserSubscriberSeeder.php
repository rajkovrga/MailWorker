<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::query()->cursor();

        foreach ($users as $user)
        {
            for ($i = 0; $i < rand(0,200); $i++)
            {
                $randNum = rand(0, 401);
                try {
                    $user->subscribers()->attach($randNum, ['id' => $user->id . $randNum]);
                }
                catch (\Exception $e)
                {
                    continue;
                }
            }
        }
    }
}
