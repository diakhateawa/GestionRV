<?php

namespace App\Http\Controllers;
use App\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add()
    {
        return view('medecin.add');
    }

    public function getAll()
    {
        //Pour la pagination en laravel
        //partis controller  {{ $liste_medecins->links() }} apres </table>
        $liste_medecins = Medecin::paginate(2);
       //$liste_medecins= Medecin::all();
        return view('medecin.list', ['liste_medecins' => $liste_medecins]);
       //return view('medecin.list');
        }

    public function edit($id)
    {
        $medecin = Medecin::find($id);
        return view('medecin.edit', ['medecin' => $medecin]);
    }

    public function update(Request $request)
    {
        //recuper les infos du medcin apartir de l'identifiant
        $medecin = Medecin::find($request->id);
        $medecin->nom = $request->nom; 
        $medecin->prenom = $request->prenom;
        $medecin->telephone= $request->telephone;

        $result = $medecin->save(); // 1ou 0
        return redirect('/medecin/getAll');
    }

    public function delete($id)
    {
        $medecin = Medecin::find($id);
        if($medecin !=null)
        {
            $medecin->delete();
        }
        return $this->getAll();
    }

    public function persist(Request $request)
    {
        $medecin = new Medecin();
        $medecin->nom = $request->nom; 
        $medecin->prenom = $request->prenom;
        $medecin->telephone= $request->telephone;

        $result = $medecin->save(); // 1ou 0
        return view('medecin.add', ['confirmation' =>$result]);
    }
}
