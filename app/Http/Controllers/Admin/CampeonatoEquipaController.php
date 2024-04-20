<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestor;
use App\Models\Hospital;
use App\Models\Logger;
use App\Models\Medico;
use App\Models\Equipa;
use App\Models\Campeonato;
use App\Models\CampeonatoEquipa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CampeonatoEquipaController extends Controller
{
    //


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }


    public function index(){
        

        $data['campeonato_equipas'] = CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->get();
        $data['equipas']=Equipa::all();
        $data['campeonatos']=Campeonato::all();
        $this->loggerData("Listou Equipas/Campeonato");

        return view('admin.campeonato_equipa.index', $data);

    }
    public function create(){


        return view('admin.campeonato_equipa.create.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        //dd($request);
        $request->validate([
            'id_equipa'=>'required',

        ],[
            'id_equipa.required'=>'O name é um campo obrigatório',

        ]);
        //dd($request);
        try{
            $campeonato_equipa=CampeonatoEquipa::create([
                'id_equipa'=>$request->id_equipa,
                'id_campeonato'=>$request->id_campeonato,               
            ]);

            $this->loggerData(" Vinculou a equipa de id $request->id_equipa ao campeonato de id: $request->id_campeonato" );

            return redirect()->back()->with('user.create.success',1);

        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
            return redirect()->back()->with('user.create.error',1);
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
        $data["campeonato_equipa"] = CampeonatoEquipa::find($id);

        return view('admin.campeonato_equipa.edit.index',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function update(Request $request, $id)
    {
        //
        //
        //dd($request);
        $request->validate([
            'id_equipa'=>'required',

        ],[
            'id_equipa.required'=>'A campeonato_equipa é um campo obrigatório',

        ]);


        try {
            //code...
            $campeonato_equipa = CampeonatoEquipa::find($id);

            CampeonatoEquipa::findOrFail($id)->update([
                'id_equipa'=>$request->id_equipa,
                'id_campeonato'=>$request->id_campeonato,     

            ]);

            $this->loggerData("Editou o campeonato_equipa que possui o id $campeonato_equipa->id ");

            return redirect()->back()->with('user.update.success',1);

        } catch (\Throwable $th) {

            return redirect()->back()->with('user.update.error',1);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            //code...
            $campeonato_equipa =CampeonatoEquipa::findOrFail($id);

            CampeonatoEquipa::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o campeonato_equipa  de id, ($campeonato_equipa->id)");
            return redirect()->back()->with('user.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.destroy.error',1);
        }
    }

    public function purge($id)
    {
        //
        try {
            //code...
            $campeonato_equipa = CampeonatoEquipa::findOrFail($id);
            CampeonatoEquipa::findOrFail($id)->forceDelete();
            $this->loggerData("Purgou o campeonato_equipa  de id, campeonato_equipa $campeonato_equipa->name");
            return redirect()->back()->with('user.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purge.error',1);
        }
    }


}
