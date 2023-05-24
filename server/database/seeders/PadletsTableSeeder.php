<?php

namespace Database\Seeders;

use App\Models\Eintrag;
use App\Models\Rating;
use App\Models\Kommentar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PadletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $padlet1 = new \App\Models\Padlet();
        $padlet1->name = "Nadines 1. Padlet mit Model";
        $padlet1->private = 0;
        $padlet1->user_id = 1;
        $padlet1->erstellungsdatum = new DateTime();
        $padlet1->save();

        //M:N scheiße
        $users = User::all()->pluck("id");
        $padlet1->user()->sync($users);


        //Einträge zum Padlet hinzufügen mit Eintragsseeder
        //$eintrag = Eintrag::find(1);
        //$padlet1->eintrags()->save($eintrag);

        //$eintrag = Eintrag::all();
        //$padlet1->eintrags()->saveMany($eintrag);


        //Eintrag ohne Padlet kann nicht gespeichert werden, deswegen Reihenfolge wichtig
        //$padlet1->save();




        //OLD
        /*macht man dann später mit Model,
        aber hier wird quasi ein zufälliges Padlet erstellt (mit Ausführen von db:seed dann
        DB::table('padlets')->insert([
            'name' => Str::random(8),
            'private' => '0',
            'erstellungsdatum'=> new DateTime(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s")
            ]);*/

        /*$padlet1 = new \App\Models\Padlet();
        $padlet1->name = "Nadines 1. Padlet mit Model";
        $padlet1->private = 0;
        $padlet1->erstellungsdatum = new DateTime();

        $padlet1->save();

        //Einträge zum Padlet hinzufügen, man könnte auch einen Eintragsseeder machen
        $eintrag1 = new \App\Models\Eintrag();
        $eintrag1->text = "1. Eintrag zum 1. Padlet yuhu";

        $eintrag2 = new \App\Models\Eintrag();
        $eintrag2->text = "2. Eintrag zum 1. Padlet yeah";

        //Eintrag ohne Padlet kann nicht gespeichert werden, deswegen Reihenfolge wichtig
       $padlet1->eintrags()->saveMany([$eintrag1,$eintrag2]);

       //Ratings zum Eintrag hinzufügen (vom RatingsTableSeeder)
        $rating = Rating::all();
        $eintrag1->ratings()->associate($rating);

        //Kommentare zum Eintrag hinzufügen
        $kommentar1 = new Kommentar();
        $kommentar1->text = 'Wow. ein super Eintrag!';

        $kommentar2 = new Kommentar();
        $kommentar2->text = 'Dieser Eintrag 2 ist der Wahnsinn.';

        $eintrag2->kommentars()->saveMany([$kommentar1,$kommentar2]);

        //zuerst den User aus der DB holen vorm padlet save
       //$user = User::all()->first();
       //$padlet1->user()->associate($user);
       /*hier associate weil man zurück zum User geht und die einträge werden
       zum Padlet gespeichert, Richtung: N zu 1 = associate, 1 zu N: save oder savemany

       $padlet1->save();
       /*mit save wirds in der DB speichert



       //user testen
       $user = User::all()->pluck("id");
       $padlet1->user()->sync($user);

       $padlet1->save();

       /*$padlet2 = new \App\Models\Padlet();
       $padlet2->name = "Nadines 2. Padlet mit Model";
       $padlet2->private = 1;
       $padlet2->erstellungsdatum = new DateTime();
       $padlet2->save();*/
    }
}
