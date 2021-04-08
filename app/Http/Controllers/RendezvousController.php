<?php

namespace App\Http\Controllers;
use App\Rendezvouss;
use App\Medecin;
use Illuminate\Http\Request;
use Illuminate\HttSupport
\Facades\Auth;
class RendezvousController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add()
    {
        $medecins = Medecin::all();
        return view('rendezvous.add', ['medecins' => $medecins]);
    }

    public function getAll()
    {
        //Pour la pagination en laravel
        //partis controller  {{ $liste_rendezvous->links() }} apres </table>
        //$liste_rendezvous = Rendezvous::paginate(2);
       $liste_rendezvous= Rendezvouss::all();
        return view('rendezvous.list', ['liste_rendezvous' => $liste_rendezvous]);
       //return view('rendezvous.list');
        }

    public function edit($id)
    {
        $rendezvous= Rendezvouss::find($id);
        return view('rendezvous.edit', ['rendezvous' => $rendezvous]);
    }

    public function update(Request $request)
    {
        //recuper les infos du medcin apartir de l'identifiant
        $rendezvous= Medecin::find($request->id);
        $rendezvous->libelle = $request->libelle; 
        $rendezvous->date= $request->date;
        $rendezvous->medecins= $request->medecins;
        $rendezvous->user= $request->Auth::id();
        $result = $rendezvous->save(); // 1ou 0
        return redirect('/rendezvous/getAll');
    }

    public function delete($id)
    {
        $rendezvous= Rendezvouss::find($id);
        if($rendezvous!=null)
        {
            $rendezvous->delete();
        }
        return $this->getAll();
    }

    public function persist(Request $request)
    {
        $rendezvous= new Rendezvouss();
        $rendezvous->libelle = $request->libelle; 
        $rendezvous->date= $request->date;
        $rendezvous->medecin= $request->medecin;
        $rendezvous->user= $request->Auth::id();

        $result = $rendezvous->save(); // 1ou 0
        return view('medecin.add', ['confirmation' =>$result]);
    }
}
