<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestor;
use App\Models\Hospital;
use App\Models\Logger;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Equipa;
use App\Models\Jogador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JogadorController extends Controller
{
    //


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }


    public function index(){

        $data['jogadores'] = Jogador::join('equipas','equipas.id','jogadores.id_equipa')
            ->select('jogadores.*','equipas.nome as equipa')
            ->get();
        $data['equipas'] = Equipa::all();
        $this->loggerData("Listou Jogadores");

        return view('admin.jogador.index', $data);

    }
    public function create(){


        return view('admin.jogador.create.index');
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
            'nome'=>'required',

        ],[
            'nome.required'=>'O nome é um campo obrigatório',

        ]);
        //dd($request);
        try{
            $jogador=Jogador::create([
                'nome'=>$request->nome,
                'data_nascimento'=>$request->data_nascimento,
                'posicao'=>$request->posicao,
                'id_equipa'=>$request->id_equipa,
                'numero'=>$request->numero
               
            ]);

            $this->loggerData(" Cadastrou o jogador " . $request->name);

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
        $data["jogador"] = Jogador::find($id);

        return view('admin.jogador.edit.index',$data);
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
            'name'=>'required',

        ],[
            'name.required'=>'A jogador é um campo obrigatório',

        ]);


        try {
            //code...
            $jogador = Jogador::find($id);

            Jogador::findOrFail($id)->update([

                'nome'=>$request->nome,
                'data_nascimento'=>$request->data_nascimento,
                'posicao'=>$request->posicao,
                'id_equipa'=>$request->id_equipa,
                'numero'=>$request->numero

            ]);
            if($request->nivel=="Paciente"){
                Paciente::where('user_id',$id)->create([
                    'data_nasc'=>$request->data_nasc,
                    'contacto'=>$request->contacto
                ]);
            }else if($request->nivel =="Medico"){
                Medico::where('user_id',$id)->create([
                    'especializacao'=>$request->especializacao,
                    'hospital_id'=>$request->hospital_id
                ]);
            }
            //dd($request->id_restaurante);

            //dd(Gestor::all());
            $this->loggerData("Editou o jogador que possui o id $jogador->id ");

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
            $jogador =Jogador::findOrFail($id);

            Jogador::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o jogador  de id, ($jogador->id)");
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
            $jogador = Jogador::findOrFail($id);
            Jogador::findOrFail($id)->forceDelete();
            $this->loggerData("Purgou o jogador  de id, jogador $jogador->name");
            return redirect()->back()->with('user.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purge.error',1);
        }
    }


}
