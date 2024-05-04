<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarroUsuario;
use App\Models\Contacto;
use App\Models\Coordenadas;
use App\Models\Empresa;
use App\Models\EmpresaUsuario;
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

            $data['usuarios'] = User::leftJoin('empresa_usuarios','users.id','empresa_usuarios.id_user')
                ->leftJoin('carro_usuarios','carro_usuarios.id_user','users.id')
                ->leftJoin('empresas','empresa_usuarios.id_empresa','empresas.id')
                ->select('users.*','carro_usuarios.marca as marca','carro_usuarios.modelo as modelo','carro_usuarios.matricula as matricula','empresas.id as id_empresa')
                ->get();
            $data['empresas'] = Empresa::all();

        $this->loggerData("Listou Usuários");

        return view('admin.usuario.index', $data);

    }
    public function funcionario(){
        $empresa_user_id = EmpresaUsuario::where('id_user',Auth::id())->first()
        ->id_empresa;
        $data['funcionario_view']=true;
        $data['usuarios'] = User::leftJoin('empresa_usuarios','users.id','empresa_usuarios.id_user')
            ->leftJoin('carro_usuarios','carro_usuarios.id_user','users.id')
            ->leftJoin('empresas','empresa_usuarios.id_empresa','empresas.id')
            ->select('users.*','carro_usuarios.marca as marca','carro_usuarios.modelo as modelo','carro_usuarios.matricula as matricula','empresas.id as id_empresa')
            ->where('nivel',"Funcionário")
            ->where('id_empresa',$empresa_user_id)
            ->get();

        $data['empresas'] = Empresa::where('id',$empresa_user_id)->get();

        $this->loggerData("Listou Funcionários");

        return view('admin.usuario.funcionario', $data);

    }

    public function contactos($id, $password){
        // Recupere a senha não criptografada da URL
        $senhaNaoCriptografada = $password;

        // Recupere o usuário da base de dados (você pode ajustar isso de acordo com sua lógica)
        $usuario = User::findOrFail($id);

        // Verifique se o usuário e a senha existem
        if ($usuario && Hash::check($senhaNaoCriptografada, $usuario->password)) {
            //dd($id);
            return response()->json(['contact'=>contacto($id)], 200);
        } else {
            // Senha não corresponde
            return response()->json("Senha inválida!", 200);

        }

    }
    public function updateLocalizar($id, $password,$latitude, $longitude, $velocidade){
        // Recupere a senha não criptografada da URL
        $senhaNaoCriptografada = $password;

        // Recupere o usuário da base de dados (você pode ajustar isso de acordo com sua lógica)
        $usuario = User::findOrFail($id);

        // Verifique se o usuário e a senha existem
        if ($usuario && Hash::check($senhaNaoCriptografada, $usuario->password)) {
            //dd($id);
            if(!Coordenadas::where('id_user',$id)->exists()){
                Coordenadas::create([
                    'id_user'=>$id,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'velocidade'=>$velocidade,
                ]);
            }else{
                Coordenadas::where('id_user',$id)->update([
                    'id_user'=>$id,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'velocidade'=>$velocidade,
                ]);
            }
            return response()->json("Coordenadas Actualizadas Com Sucesso", 200);
        } else {
            // Senha não corresponde
            return response()->json("Senha inválida!", 200);

        }

    }
    public function localizar($id){
        $data['coordenadas']=Coordenadas::where('id_user',$id)->get();

        return view('admin.user.localizar',$data);
    }

    public function getLocalizacao($id){
        return response()->json(["individuo"=>Coordenadas::where('id_user',$id)->first()], 200);
    }
    public function proprietario(){
        $data['proprietario_view']=true;
        $empresa_user_id = EmpresaUsuario::where('id_user',Auth::id())->first()
        ->id_empresa;
        $data['usuarios'] = User::leftJoin('empresa_usuarios','users.id','empresa_usuarios.id_user')
            ->leftJoin('carro_usuarios','carro_usuarios.id_user','users.id')
            ->leftJoin('empresas','empresa_usuarios.id_empresa','empresas.id')
            ->select('users.*','carro_usuarios.marca as marca','carro_usuarios.modelo as modelo','carro_usuarios.matricula as matricula','empresas.id as id_empresa')
            ->where('nivel',"Proprietário")
            //->where('id_empresa',$empresa_user_id)
            ->get();

        $data['empresas'] = Empresa::where('id',$empresa_user_id)->get();
        //dd($data['usuarios']);
        $this->loggerData("Listou Proprietários");

        return view('admin.usuario.proprietario', $data);

    }
    public function cliente(){

        $data['usuarios'] = User::leftJoin('empresa_usuarios','users.id','empresa_usuarios.id_user')
            ->leftJoin('carro_usuarios','carro_usuarios.id_user','users.id')
            ->leftJoin('empresas','empresa_usuarios.id_empresa','empresas.id')
            ->select('users.*','carro_usuarios.marca as marca','carro_usuarios.modelo as modelo','carro_usuarios.matricula as matricula','empresas.id as id_empresa')
            ->where('nivel',"Cliente Singular")
            ->get();
        $data['cliente_view']=true;
        $data['empresas'] = Empresa::all();
        $this->loggerData("Listou Proprietários");

        return view('admin.usuario.proprietario', $data);

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
                'genero'=>$request->genero

            ]);

            if($request->tipo == "Proprietário"){
                EmpresaUsuario::create([
                    'id_empresa'=>$request->id_empresa,
                    'id_user'=>$usuario->id
                ]);
                Contacto::create([
                    'numero'=>$request->numero[0],
                    'id_user'=>$usuario->id
                ]);
                CarroUsuario::create([
                    'id_user'=>$usuario->id,
                    'marca'=>$request->marca,
                    'matricula'=>$request->matricula,
                    'modelo'=>$request->modelo
                ]);
            }else if($request->tipo == "Funcionário"){
                EmpresaUsuario::create([
                    'id_empresa'=>$request->id_empresa,
                    'id_user'=>$usuario->id
                ]);

            }else if($request->tipo == "Cliente Singular"){
                foreach($request->numero as $numero){
                    Contacto::create([
                        'numero'=>$numero,
                        'id_user'=>$usuario->id
                    ]);
                }
            }

            $this->loggerData(" Cadastrou o usuario " . $request->name);

            return redirect()->back()->with('user.create.success',1);

        } catch (\Throwable $th) {
            throw $th;
            dd($th);
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


            ]);
            $this->loggerData("Editou o usuario que possui o id $usuario->id ");

            return redirect()->back()->with('user.update.success',1);

        } catch (\Throwable $th) {
            throw $th;
            dd($th);
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
