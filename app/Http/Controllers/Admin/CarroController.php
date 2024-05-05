<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarroUsuario;
use App\Models\Empresa;
use App\Models\Logger;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CarroController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['carros']=CarroUsuario::join('users','users.id','carro_usuarios.id_user')
            ->select('carro_usuarios.*','users.name as proprietario')
            ->get();
        $data['usuarios']=User::where('nivel',"Proprietário")->get();



        $this->loggerData("Listou os Veiculos");

        return view('admin.carro.index', $data);

    }



    public function create(){


        return view('admin.carro.create.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request){
        $request->validate([
            'nome'=>'required',
        ],[
            'nome.required'=>'O nome é um campo obrigatório',


        ]);
        //dd($request);
        try{
            $carro=CarroUsuario::create([
                'id_user'=>$request->usuario_id,
                'marca'=>$request->marca,
                'matricula'=>$request->matricula,
                'modelo'=>$request->modelo
            ]);
             $this->loggerData(" Cadastrou um carro " . $request->nome);

            return redirect()->back()->with('carro.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('carro.create.error',1);
        }


     }


      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }


    public function edit(int $id)
    {
        //
        $data["carro"] = CarroUsuario::find($id);


        return view('admin.carro.edit.index',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



     public function update(Request $request, int $id)
     {
        $request->validate([
            'nome'=>'required',
        ],[
            'nome.required'=>'O nome é um campo obrigatório',

        ]);
          try {
             //code...
             $carro = CarroUsuario::find($id);

             $c =CarroUsuario::findOrFail($id)->update([
                'marca'=>$request->marca,
                'matricula'=>$request->matricula,
                'modelo'=>$request->modelo
             ]);
            $this->loggerData("Editou o carro que possui o id $carro->id  e nome  $carro->nome");
             return redirect()->back()->with('carro.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('carro.update.error',1);
          }
     }
     public function getLocalizacao($id){
        return response()->json(['carro'=>CarroUsuario::where('id_user',$id)->first()], 200);
    }
     public function updateLocalizar(int $id, $password,$latitude, $longitude)
     {
        try {
             //code...
            // $carro = CarroUsuario::find($id);
            //dd(User::find($id));
            // Recupere a senha não criptografada da URL
            $senhaNaoCriptografada = $password;

            // Recupere o usuário da base de dados (você pode ajustar isso de acordo com sua lógica)
            $usuario = User::findOrFail($id);

            // Verifique se o usuário e a senha existem
            if ($usuario && Hash::check($senhaNaoCriptografada, $usuario->password)) {
                $c =CarroUsuario::where('id_user',$id)->update([
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                ]);
                return response()->json("Coordenadas actualizadas com sucesso!", 200);

            }else{
                return response()->json("Coordenadas não foram actualizadas!", 200);

            }
        } catch (\Throwable $th) {
            return response()->json("Coordenadas não foram actualizadas!", 200);
        }
     }
     public function localizar($id){
        $data['carro']=CarroUsuario::find($id);

        return view('admin.carro.localizacao',$data);


     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        try {
            //code...
            $carro =CarroUsuario::findOrFail( $id);

            CarroUsuario::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o carro , ($carro->nome)");
            return redirect()->back()->with('carro.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('carro.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $carro = CarroUsuario::findOrFail($id);
            CarroUsuario::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a carro  ($carro->nome)");
            return redirect()->back()->with('carro.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('carro.purge.error',1);
        }
    }


}
