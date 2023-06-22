<?php

namespace App\Http\Controllers;
use App\Models\Padlet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Eintrag;


class PadletController extends Controller
{
    public function index():JsonResponse
    {
        /*
         * alle Padlets und Beziehungen eager laden: alles gleich laden (auch Daten von Detailansicht)
         * jetzt sollen statt Views JSON-Daten ausgeliefert werden..
         * geh ins Padlet-Model (da sind update &so)
         *  und nimm alle Beziehungen mit
         */
        $padlets = Padlet::with(['user','eintrags'])->get();
        return response()->json($padlets,200);
    }

    public function detail(int $id): JsonResponse
    {
        $padlet = Padlet::with(['user', 'eintrags'])->find($id);
        return $padlet != null ? response()->json($padlet, 200) : response()->json(null, 200);
    }

    //wir fragen hier nach allen Padlets wo der Wert der Variable private, gleich
    //dem Wert der Variable des Padlets ist. ausgegeben soll das json Objekt mit den with-Parametern
    //werden und es soll nur das erste angezeigt werden
    /* wenn ein Ergebnis vorhanden ist, soll das ausgegeben werden und wenn nicht,
     * dann soll nichts ausgegeben werden (einzeiliges if-else)
     * wird nicht genutzt
    public function showprivateonly(bool $private): JsonResponse{
        $padlet = Padlet::where('private', $private)->with(['eintrags'])->first();
        return $padlet != null ? response()->json($padlet,200) : response()->json(null,200);
    }

    //check, obs ein Padlet mit dem Namen gibt, gib true/False zurück
    //wird nicht genutzt
    public function checkname(string $name){
        $padlet = Padlet::where('name', $name)->first();
        return $padlet != null ? response()->json(true,200) : response()->json(false,200);
    }

    //wird nicht genutzt
    public function findbysearchterm(string $searchTerm):JsonResponse {
        $padlets = Padlet::with(['users', 'eintrags'])
            ->where('name', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('erstellungsdatum', 'LIKE', '%'.$searchTerm.'%')
            ->orWhere('private', 'LIKE', '%'.$searchTerm.'%')
            //search termi in users
            ->orWhereHas('users', function($query) use ($searchTerm)
        {
            $query->where('name','LIKE','%'.$searchTerm.'%')
                ->orWhere('name','LIKE','%'.$searchTerm.'%');
        })->get();
        return response()->json($padlets,200);
    }*/


    //create new Padlet

    /*public function save(Request $request) : JsonResponse {
        //parsen, damit die Daten(typen) zsmpassen
        $request = $this->parseRequest($request);
        return response()->json($request, 200);

        //Transactions: brauchn wir, wenn wir in mehreren Tabellen Zustandsänderungen machen
        //wenn irgendwas nicht durchgeht (ein Eintrag zb), bricht das gesamte SQL Statement ab
        DB::beginTransaction();
        try {
            $padlet = Padlet::create($request->all());

            //Einträge speichern
            if (isset($request['eintrags']) && is_array ($request['eintrags'])) {
                foreach ($request['eintrags'] as $eint){
                    $eintrag =
                        //firstOrNew: falls es den Eintrag schon geben sollte, wird er halt zugewiesen, sonst
                        //im Normalfall einfach neu erstellt
                        Eintrag::firstOrNew(['text'=>$eint['text']]);
                    $padlet->eintrags()->save($eintrag);
                }
            }
            //user speichern
            if (isset($request['users']) && is_array ($request['users'])) {
                foreach ($request['users'] as $use){
                    $user =
                        User::firstOrNew(['name'=>$use['name'], 'email'=>$use['email'],'password'=>$use['password']]);
                    $padlet->users()->save($user);
                }
            }
            DB::commit();
            //gültige http response returnen
            return response()->json($padlet, 201);
        }
        catch  (\Exception $e){
            //rollback all queries
            DB::rollBack();
            return response()->json("Padlet konnte leider nicht gespeichert werden: ". $e->getMessage(), 420);
        }
    }
*/
    public function save(Request $request) : JsonResponse {
        //parsen, damit die Daten(typen) zsmpassen
        $request = $this->parseRequest($request);

        //Transactions: brauchn wir, wenn wir in mehreren Tabellen Zustandsänderungen machen
        //wenn irgendwas nicht durchgeht (ein Eintrag zb), bricht das gesamte SQL Statement ab
        DB::beginTransaction();
        try {
            $padlet = Padlet::create($request->all());

            //Einträge speichern
            if (isset($request['eintrags']) && is_array ($request['eintrags'])) {
                foreach ($request['eintrags'] as $eint){
                    $eintrag =
                        //firstOrNew: falls es den Eintrag schon geben sollte, wird er halt zugewiesen, sonst
                        //im Normalfall einfach neu erstellt
                        Eintrag::firstOrNew(['text'=>$eint['text']]);

                    $padlet->eintrags()->save($eintrag);
                }
            }
            //user speichern
            if (isset($request['users']) && is_array ($request['users'])) {
                foreach ($request['users'] as $use){
                    $user =
                        User::firstOrNew(['name'=>$use['name'], 'email'=>$use['email'],'password'=>$use['password']]);
                    $padlet->users()->save($user);
                }
            }
            DB::commit();
            //gültige http response returnen
            return response()->json($padlet, 201);
        }
        catch  (\Exception $e){
            //rollback all queries
            DB::rollBack();
            return response()->json("Padlet konnte leider nicht gespeichert werden: ". $e->getMessage(), 420);
        }
    }

    //modify/convert values if needed
    private function parseRequest(Request $request) : Request {
        //Datum konvertieren
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }

    public function update (Request $request, string $name) : JsonResponse
    {
        DB::beginTransaction();
        //zuerst schauma, obs das Padlet überhaupt gibt (sonst kann man schlecht updaten)
        try {
            $padlet = Padlet::with(['users', 'eintrags'])
                ->where('id', $name)->first();
            if($padlet != null) {
                $request = $this->parseRequest($request);
                $padlet->update($request->all());

                //alte Einträge löschen
                $padlet->eintrags()->delete();
                //neue Einträge speichern
                if (isset($request['eintrags']) && is_array($request['eintrags'])) {
                    foreach ($request['eintrags'] as $ein) {
                        $eintrag = Eintrag::firstOrNew(['text' => $ein['url'], 'title'=>[$ein]]);
                    $padlet->eintrags()->save($eintrag);
                    }
                }
                //user updaten
                $ids = [];
                if (isset($request['users']) && is_array($request['users'])) {
                    foreach ($request['users'] as $use) {
                        array_push($ids,$use['id']);
                    }
                }

                //sync=kombiniertes attach/detach
                $padlet->users()->sync($ids);
                $padlet->save();

                DB::commit();
                $padlet1 = Padlet::with(['users', 'eintrags'])
                    ->where('name', $name)->first();

                //gültige https response returnen
                return response()->json($padlet1, 201);
            }

            return response()->json("Padlet wurde nicht gefunden",420);

        }
        catch (\Exception $e) {
            //rollback all queries
            DB::rollBack();
            return response()->json("Padlet Update war leider nicht erfolgreich: " . $e->getMessage(), 420);
        }
    }

    //Padlet löschen (wenns gefunden werden kann)
    public function delete(string $name) : JsonResponse {
        $padlet = Padlet::where('name', $name)->first();
        if ($padlet != null) {
            $padlet->delete();
            return response()->json('Padlet ('. $name . ') erfolgreich gelöscht', 200);
        }
        else
            return response()->json('Padlet konnte nicht gelöscht werden - es existiert nämlich gar nicht :)', 420);
    }
}



