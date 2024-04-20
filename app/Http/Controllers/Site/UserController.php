<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Fatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf;
use Throwable;

class UserController extends Controller
{
    public function perfil(){
        return view('site.contacto');
    }
    public function edit(Request $request){
        try{
            //dd($request);
            User::find(Auth::id())->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'morada'=>$request->morada,
            ]);
            if($request->password === $request->conf_pass){
                User::find(Auth::id())->update([
                    'password'=>Hash::make($request->password),//Criptografando a senha em laravel
                ]);
            }else{
                return redirect()->back()->with('perfil.password.error',1);
            }
            //dd(isset($request->imagem));
            if(isset($request->imagem)){
                User::find(Auth::id())->update([
                    'profile_photo_path'=>$this->upload($request->imagem)
                ]);
            }
            return redirect()->back()->with('perfil.edit.success',1);
        }catch(\Throwable $th){
            throw $th;
            dd($th);
            return redirect()->back()->with('perfil.error');
        }

    }
    public function faturas(){
        $data['faturas']=Fatura::where('id_usuario',Auth::id())->get();
        return view('site.facturas',$data);
    }
    public function fatura($id){
        $fatura=Fatura::join('users','faturas.id_usuario','users.id')
            ->select('faturas.*','faturas.id as fatura_id','users.*')
            ->where('faturas.id',$id)
            ->first();

        $data['fatura']=$fatura;

        $data['pratos']=Compra::join('pratos','compras.id_prato','pratos.id')
            ->select('pratos.*','compras.valor as valor','compras.qtd as quantidade')
            ->where('id_fatura',$id)
            ->get();
        $data['fatura']->valor_total=$data['pratos']->sum('valor');
        //dd($data['pratos']);


        $html = view("site/fatura",$data);
        //dd($html);
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Fatura Nº".$fatura->id."/2024" . ".pdf", "I");
    }
    public function upload( $file){

        $nomeFile = uniqid() . '.' . $file->getClientOriginalExtension();
        $caminhoFile = public_path('docs/users/imagens'); // Pasta de destino

        $file->move($caminhoFile, $nomeFile);
        return "docs/users/imagens/".$nomeFile;

    }
}
