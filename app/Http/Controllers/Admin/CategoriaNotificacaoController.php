<?php

namespace App\Http\Controllers\DP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriaNotificacao;
use App\Models\Logger;

class CategoriaNotificacaoController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['categoria_notificacoes']=CategoriaNotificacao::all();


        $this->loggerData("Listou as Categorias das Notificações");

        return view('admin.categoria_notificacao.index', $data);

    }



    public function create(){


        return view('admin.categoria_notificacao.create.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request){
        $request->validate([
            'vc_nome'=>'required',
        ],[
            'vc_nome.required'=>'O nome é um campo obrigatório',


        ]);
        //dd($request);
        try{
            $categoria_notificacao=CategoriaNotificacao::create([
                'vc_nome'=>$request->vc_nome,
                'lt_descricao'=>$request->lt_descricao,


            ]);

             $this->loggerData(" Cadastrou uma categoria de notificação " . $request->vc_nome);

            return redirect()->back()->with('categoria_notificacao.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('categoria_notificacao.create.error',1);
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
        $data["categoria_notificacao"] = CategoriaNotificacao::find($id);


        return view('admin.categoria_notificacao.edit.index',$data);
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
            'vc_nome'=>'required',
        ],[
            'vc_nome.required'=>'O nome é um campo obrigatório',

        ]);
          try {
             //code...
             $categoria_notificacao = CategoriaNotificacao::find($id);

             $c =CategoriaNotificacao::findOrFail($id)->update([
                'vc_nome'=>$request->vc_nome,
                'lt_descricao'=>$request->lt_descricao,

             ]);
            $this->loggerData("Editou a categoria de notificação que possui o id $categoria_notificacao->id  e nome  $categoria_notificacao->vc_nome");
             return redirect()->back()->with('categoria_notificacao.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('categoria_notificacao.update.error',1);
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
            $categoria_notificacao =CategoriaNotificacao::findOrFail( $id);

            CategoriaNotificacao::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o categoria de notificação , ($categoria_notificacao->vc_nome)");
            return redirect()->back()->with('categoria_notificacao.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('categoria_notificacao.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $categoria_notificacao = CategoriaNotificacao::findOrFail($id);
            CategoriaNotificacao::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a categoria de notificação  ($categoria_notificacao->vc_nome)");
            return redirect()->back()->with('categoria_notificacao.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('categoria_notificacao.purge.error',1);
        }
    }


}
