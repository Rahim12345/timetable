<?php

namespace Database\Seeders;

use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class TimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $event_count = rand(1,3);

            for ($j = 0; $j < $event_count; $j++)
            {
                if ($i == 0)
                {
                    Timetable::create([
                        'name'=>$faker->text(rand(50,100)),
                        'startDateTime'=>Carbon::now(),
                        'endDateTime'=>Carbon::now(),
                        'description'=>$faker->text(),
                    ]);
                }
                else
                {
                    Timetable::create([
                        'name'=>$faker->text(rand(50,100)),
                        'startDateTime'=>Carbon::now()->addDays($i)->addHours(rand(1,3)),
                        'endDateTime'=>Carbon::now()->addDays($i)->addHours(rand(4,12)),
                        'description'=>$faker->text(),
                    ]);

                    Timetable::create([
                        'name'=>$faker->text(rand(50,100)),
                        'startDateTime'=>Carbon::now()->subDays($i)->addHours(rand(1,3)),
                        'endDateTime'=>Carbon::now()->subDays($i)->addHours(rand(4,12)),
                        'description'=>$faker->text(),
                    ]);
                }
            }
        }
    }
}
