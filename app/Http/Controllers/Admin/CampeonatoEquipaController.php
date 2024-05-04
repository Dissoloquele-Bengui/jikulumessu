<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestor;
use App\Models\Hospital;
use App\Models\Logger;
use App\Models\Medico;
use App\Models\Equipa;
use App\Models\Carro;
use App\Models\CarroEquipa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CarroEquipaController extends Controller
{
    //


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }


    public function index(){


        $data['carro_equipas'] = CarroEquipa::join('equipas','equipas.id','carro_equipas.id_equipa')
            ->join('carros','carros.id','carro_equipas.id_carro')
            ->select('carro_equipas.*','equipas.nome as equipa','carros.nome as carro')
            ->get();
        $data['equipas']=Equipa::all();
        $data['carros']=Carro::all();
        $this->loggerData("Listou Equipas/Carro");

        return view('admin.carro_equipa.index', $data);

    }
    public function create(){


        return view('admin.carro_equipa.create.index');
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
            if(CarroEquipa::where('id_equipa',$request->id_equipa)
                ->where('id_carro',$request->id_carro)
                ->exists()){
                    return redirect()->back()->with('carro_equipa.create.error',1);
                }
            $carro_equipa=CarroEquipa::create([
                'id_equipa'=>$request->id_equipa,
                'id_carro'=>$request->id_carro,
            ]);

            $this->loggerData(" Vinculou a equipa de id $request->id_equipa ao carro de id: $request->id_carro" );

            return redirect()->back()->with('carro_equipa.create.success',1);

        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
            return redirect()->back()->with('carro_equipa.create.error',1);
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
        $data["carro_equipa"] = CarroEquipa::find($id);

        return view('admin.carro_equipa.edit.index',$data);
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
            'id_equipa.required'=>'A carro_equipa é um campo obrigatório',

        ]);


        try {
            //code...
            $carro_equipa = CarroEquipa::find($id);

            CarroEquipa::findOrFail($id)->update([
                'id_equipa'=>$request->id_equipa,
                'id_carro'=>$request->id_carro,

            ]);

            $this->loggerData("Editou o carro_equipa que possui o id $carro_equipa->id ");

            return redirect()->back()->with('carro_equipa.update.success',1);

        } catch (\Throwable $th) {

            return redirect()->back()->with('carro_equipa.update.error',1);
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
            $carro_equipa =CarroEquipa::findOrFail($id);

            CarroEquipa::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o carro_equipa  de id, ($carro_equipa->id)");
            return redirect()->back()->with('carro_equipa.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('carro_equipa.destroy.error',1);
        }
    }

    public function purge($id)
    {
        //
        try {
            //code...
            $carro_equipa = CarroEquipa::findOrFail($id);
            CarroEquipa::findOrFail($id)->forceDelete();
            $this->loggerData("Purgou o carro_equipa  de id, carro_equipa $carro_equipa->name");
            return redirect()->back()->with('carro_equipa.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('carro_equipa.purge.error',1);
        }
    }


}
