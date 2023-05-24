<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        /*hier geben wir an, welche Seeders beim allgemeinen migrieren beachtet werden sollten
        + Reihenfolge is wichtig! (User zuerst, weil sonst sind in Padlets Users angegeben, die er
         noch gar nicht geladen hat */
        $this->call(UsersTableSeeder::class);
        $this->call(PadletsTableSeeder::class);
        $this->call(EintragsTableSeeder::class);
    }
}
