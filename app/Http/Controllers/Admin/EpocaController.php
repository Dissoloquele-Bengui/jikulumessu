<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Epoca;
use App\Models\Logger;

class EpocaController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['epocas']=Epoca::all();


        $this->loggerData("Listou as Epocas");

        return view('admin.epoca.index', $data);

    }



    public function create(){


        return view('admin.epoca.create.index',$data);
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
            $epoca=Epoca::create([
                'nome'=>$request->nome,


            ]);

             $this->loggerData(" Cadastrou uma epoca " . $request->nome);

            return redirect()->back()->with('epoca.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('epoca.create.error',1);
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
        $data["epoca"] = Epoca::find($id);


        return view('admin.epoca.edit.index',$data);
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
             $epoca = Epoca::find($id);

             $c =Epoca::findOrFail($id)->update([
                'nome'=>$request->nome,

             ]);
            $this->loggerData("Editou a epoca que possui o id $epoca->id  e nome  $epoca->nome");
             return redirect()->back()->with('epoca.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('epoca.update.error',1);
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
            $epoca =Epoca::findOrFail( $id);

            Epoca::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o epoca , ($epoca->nome)");
            return redirect()->back()->with('epoca.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('epoca.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $epoca = Epoca::findOrFail($id);
            Epoca::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a epoca  ($epoca->nome)");
            return redirect()->back()->with('epoca.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('epoca.purge.error',1);
        }
    }


}
