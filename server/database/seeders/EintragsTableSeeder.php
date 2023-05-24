<?php

namespace Database\Seeders;

use App\Models\Kommentar;
use App\Models\Padlet;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EintragsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eintrag1 = new \App\Models\Eintrag();
        $eintrag1->text = "1. Eintrag zum 1. Padlet yuhu";
        $eintrag1->user_id = 1;
        $eintrag1->padlet_id = 1;
        //
        //$eintrag1->save();
        //das war vorher im PadletsTableSeeder aber ich glaub das gehört hierher
        //user zu den einträgen hinzufügen, diesesmal nicht savemany sondern associate
        //$user = User::all()->first();
        //$eintrag1->users()->associate($user);

        $eintrag1->save();

        /*woas ned
        $eintrag1 = Padlet::all()->first();
        $eintrag1->padlets()->associate($eintrag1);
        $eintrag1->save();
       */

        $eintrag2 = new \App\Models\Eintrag();
        $eintrag2->text = "2. Eintrag zum 1. Padlet yeah";
        $eintrag2->user_id = 1;
        $eintrag2->padlet_id = 1;

        $eintrag2->save();

        //$user = User::all()->first();
        //$eintrag2->users()->associate($user);

        //$eintrag2->save();

        //Ratings zum Eintrag hinzufügen
        $rating1 = new Rating();
        $rating1->rating = '5';
        $rating1->user_id = 1;
        $rating1->eintrag_id = 1;
        $eintrag1->ratings()->save($rating1);

        $eintrag1->save();

        //Kommentare zum Eintrag hinzufügen
        $kommentar1 = new Kommentar();
        $kommentar1->text = 'Wow. ein super Eintrag!';
        $kommentar1->user_id = 1;
        $kommentar1->eintrag_id = 1;

        $kommentar2 = new Kommentar();
        $kommentar2->text = 'Dieser Eintrag 2 ist der Wahnsinn.';
        $kommentar2->user_id = 1;
        $kommentar2->eintrag_id = 1;

        $eintrag2->kommentars()->saveMany([$kommentar1,$kommentar2]);
    }
}
