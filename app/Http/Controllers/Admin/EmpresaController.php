<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\EmpresaUsuario;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['empresas']=Empresa::all();

        if(Auth::user()->nivel == "Funcionário"){
            $empresa_user_id = EmpresaUsuario::where('id_user',Auth::id())->first()
                ->id_empresa;
            $data['empresas']=Empresa::where('id',$empresa_user_id)->get();
        }
        $this->loggerData("Listou as Empresas");

        return view('admin.empresa.index', $data);

    }



    public function create(){


        return view('admin.empresa.create.index',$data);
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
            $empresa=Empresa::create([
                'nome'=>$request->nome,


            ]);

             $this->loggerData(" Cadastrou uma empresa " . $request->nome);

            return redirect()->back()->with('empresa.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('empresa.create.error',1);
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
        $data["empresa"] = Empresa::find($id);


        return view('admin.empresa.edit.index',$data);
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
             $empresa = Empresa::find($id);

             $c =Empresa::findOrFail($id)->update([
                'nome'=>$request->nome,

             ]);
            $this->loggerData("Editou a empresa que possui o id $empresa->id  e nome  $empresa->nome");
             return redirect()->back()->with('empresa.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('empresa.update.error',1);
          }
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
            $empresa =Empresa::findOrFail( $id);

            Empresa::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o empresa , ($empresa->nome)");
            return redirect()->back()->with('empresa.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('empresa.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $empresa = Empresa::findOrFail($id);
            Empresa::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a empresa  ($empresa->nome)");
            return redirect()->back()->with('empresa.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('empresa.purge.error',1);
        }
    }


}
