<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['users', 'lessons'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->toTruncate as $table) {
            DB::table($table)->truncate(); // Empties the DB's old faker records for the newly created ones.
        }

        $this->call('UsersTableSeeder');
        $this->call('LessonsTableSeeder');
    }
}
