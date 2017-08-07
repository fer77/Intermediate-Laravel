<?php

use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    public function run()
    {
        // Defaults in the UserFactory.php can be overwritten, by passing them here:
        factory('App\Lesson', 50);
    }
}
