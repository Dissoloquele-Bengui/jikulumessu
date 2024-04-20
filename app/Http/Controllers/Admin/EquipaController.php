<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipa;
use App\Models\Logger;

class EquipaController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['equipas']=Equipa::all();


        $this->loggerData("Listou as Equipas");

        return view('admin.equipa.index', $data);

    }



    public function create(){


        return view('admin.equipa.create.index',$data);
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
      //  dd($request);
        try{
            $equipa=Equipa::create([
                'nome'=>$request->nome,
                'logo'=>upload($request->logo)
            ]);

             $this->loggerData(" Cadastrou uma equipa " . $request->nome);

            return redirect()->back()->with('equipa.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('equipa.create.error',1);
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
        $data["equipa"] = Equipa::find($id);


        return view('admin.equipa.edit.index',$data);
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
             $equipa = Equipa::find($id);

             $c =Equipa::findOrFail($id)->update([
                'nome'=>$request->nome,
                'logo'=>upload($request->logo)

             ]);
             if($isset($request->logo)){
                $c =Equipa::findOrFail($id)->update([
                    'nome'=>$request->nome,
                    'logo'=>upload($request->logo)
    
                 ]);
             }else{
                $c =Equipa::findOrFail($id)->update([
                    'nome'=>$request->nome,
                 ]);
             }
            $this->loggerData("Editou a equipa que possui o id $equipa->id  e nome  $equipa->nome");
             return redirect()->back()->with('equipa.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('equipa.update.error',1);
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
            $equipa =Equipa::findOrFail( $id);

            Equipa::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o equipa , ($equipa->nome)");
            return redirect()->back()->with('equipa.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('equipa.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $equipa = Equipa::findOrFail($id);
            Equipa::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a equipa  ($equipa->nome)");
            return redirect()->back()->with('equipa.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('equipa.purge.error',1);
        }
    }


}
