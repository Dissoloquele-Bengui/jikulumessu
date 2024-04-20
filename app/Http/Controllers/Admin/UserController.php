<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestor;
use App\Models\Hospital;
use App\Models\Logger;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }


    public function index(){

            $data['usuarios'] = User::all();
        if(Auth::user()->nivel == "Admin de Campeonato"){
            $data['usuarios'] = User::where('id',Auth::user()->id)
                ->get();

        }
        $this->loggerData("Listou Usuários");

        return view('admin.usuario.index', $data);

    }
    public function create(){


        return view('admin.usuario.create.index');
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
            'name'=>'required',

        ],[
            'name.required'=>'O name é um campo obrigatório',

        ]);
        //dd($request);
        try{
            $usuario=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'nivel'=>$request->tipo,
                'password'=>Hash::make($request->password),

            ]);

            $this->loggerData(" Cadastrou o usuario " . $request->name);

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
        $data["usuario"] = User::find($id);

        return view('admin.usuario.edit.index',$data);
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
            'name.required'=>'A usuario é um campo obrigatório',

        ]);


        try {
            //code...
            $usuario = User::find($id);

            User::findOrFail($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'nivel'=>$request->tipo,
                'password'=>Hash::make($request->password),//Criptografando a senha em laravel
                'morada'=>$request->morada,
                'nif'=>$request->nif

            ]);
            if($request->tipo=="Paciente"){
                Paciente::where('user_id',$id)->create([
                    'data_nasc'=>$request->data_nasc,
                    'contacto'=>$request->contacto
                ]);
            }else if($request->tipo =="Medico"){
                Medico::where('user_id',$id)->create([
                    'especializacao'=>$request->especializacao,
                    'hospital_id'=>$request->hospital_id
                ]);
            }
            //dd($request->id_restaurante);

            //dd(Gestor::all());
            $this->loggerData("Editou o usuario que possui o id $usuario->id ");

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
            $usuario =User::findOrFail($id);

            User::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o usuario  de id, ($usuario->id)");
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
            $usuario = User::findOrFail($id);
            User::findOrFail($id)->forceDelete();
            $this->loggerData("Purgou o usuario  de id, usuario $usuario->name");
            return redirect()->back()->with('user.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purge.error',1);
        }
    }


}
