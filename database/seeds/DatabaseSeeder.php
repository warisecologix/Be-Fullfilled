<?php

use App\Admin;
use App\ScoreCard;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ScoreCard::insert([
            [
                'title'=>'FOCUS',
                'color'=>'#ABFAB7',
            ],
            [
                'title'=>'SLEEP',
                'color'=>'#E79EFD',
            ],
            [
                'title'=>'RELATIONSHIPS',
                'color'=>'#F2637E',
            ],
            [
                'title'=>'EXERCISE',
                'color'=>'#88CAFD',
            ],
            [
                'title'=>'NUTRITION',
                'color'=>'#ABB3FA',
            ],
            [
                'title'=>'ME TIME',
                'color'=>'#FAABAB',
            ],
            [
                'title'=>'CREATIVITY',
                'color'=>'#ECE49C',
            ],
            [
                'title'=>'GRATITUDE',
                'color'=>'#C1EE88',
            ]
        ]);
        $this->call([
            TagSeeder::class,
            OrderStatusSeeder::class,
            DailyCheckQuestionSeeder::class
        ]);
//        Admin::insert([
//            [
//                'name'=>'Admin User',
//                'email'=>'admin@gmail.com',
//                'password'=> \Illuminate\Support\Facades\Hash::make('password'),
//            ]
//        ]);

//        ScoreCard::insert([
//            [
//                'title'=>'FOCUS',
//                'color'=>'#ABFAB7',
//            ],
//            [
//                'title'=>'SLEEP',
//                'color'=>'#E79EFD',
//            ],
//            [
//                'title'=>'RELATIONSHIPS',
//                'color'=>'#F2637E',
//            ],
//            [
//                'title'=>'EXERCISE',
//                'color'=>'#88CAFD',
//            ],
//            [
//                'title'=>'NUTRITION',
//                'color'=>'#ABB3FA',
//            ],
//            [
//                'title'=>'ME TIME',
//                'color'=>'#FAABAB',
//            ],
//            [
//                'title'=>'CREATIVITY',
//                'color'=>'#ECE49C',
//            ],
//            [
//                'title'=>'GRATITUDE',
//                'color'=>'#C1EE88',
//            ]
//        ]);
    }
}
