<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\AgendaN;
use App\Models\Aluno;
use App\Models\Notificacoes;
use App\Models\Ap_unidade;
use App\Models\Destinatario;
use App\Models\Edificios;
use App\Models\Logger;
use Illuminate\Http\Request;
use App\Models\CategoriaNotificacao;
use App\Models\EstadoNotificacao;
use App\Models\Andar;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\TurmaProfessor;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }

    public function index(){
        if(Auth::user()->tipo=="Professor"){
            $professor = Professor::where('user_id',Auth::id())->first();
            $data['turmas'] = TurmaProfessor::where('professor_id',$professor->id)
            ->join('turmas','turma_professors.turma_id','turmas.id')
            ->select('turmas.*')
            ->get();
        }else{
            $data['turmas']=Turma::all();
        }

        $data['categorias']=CategoriaNotificacao::all();
        $data['Notificacoes']=Notificacoes::join('categoria_notificacoes','notificacoes.id_categoria','=','categoria_notificacoes.id')
        ->select(
            'notificacoes.*',
            'categoria_notificacoes.vc_nome as categoria',
        )->get();


        $this->loggerData("Listou Notificações");

        return view('admin.Notificacao.index', $data);

    }

    public function create(){

        return view('admin.Notificacao.create.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request){
        $request->validate([
            'vc_assunto'=>'required',
            'lt_descricao'=>'required',
        ],[
            'vc_assunto.required'=>'O Assunto é um campo obrigatório',
            'lt_descricao.required'=>'A Descrição é um campo obrigatório',



        ]);
        //dd($request);
        try{
            $Notificacoes=Notificacoes::create([
                'vc_assunto'=>$request->vc_assunto,
                'lt_descricao'=>$request->lt_descricao,
                'dt_data'=>$request->dt_data,
                'tm_hora'=>$request->tm_hora,
                'id_categoria'=>$request->it_id_categoria,

            ]);

            if(in_array("All",$request->it_id_turma)){
                foreach(Turma::all() as $turma){
                    $alunos = Aluno::join('matriculas','matriculas.aluno_id','alunos.id')
                    ->join('turmas','matriculas.turma_id','turmas.id')
                    ->select('alunos.user_id')
                    ->where('turmas.id',$turma->id)
                    ->get();
                    foreach($alunos as $aluno){
                        $destinatario=Destinatario::create([
                            'it_id_usuario'=>$aluno->user_id,
                            'it_id_notificacoe'=>$Notificacoes->id
                        ]);
                        Estado_Notificacoe::create([
                            'it_id_usuario'=>$aluno->user_id,
                            'it_id_destinatario'=>$destinatario->id,
                            'it_id_notificacoe'=>$Notificacoes->id,
                            'it_estado'=>0
                        ]);
                    }

                }
            }else{
                $turma_id = $request->it_id_turma;
                $alunos = Aluno::join('matriculas','matriculas.aluno_id','alunos.id')
                ->join('turmas','matriculas.turma_id','turmas.id')
                ->select('alunos.user_id')
                ->where('turmas.id',$turma_id)
                ->get();
                foreach($alunos as $aluno){
                    $destinatario=Destinatario::create([
                        'it_id_usuario'=>$aluno->user_id,
                        'it_id_notificacoe'=>$Notificacoes->id
                    ]);
                    Estado_Notificacoe::create([
                        'it_id_usuario'=>$aluno->user_id,
                        'it_id_destinatario'=>$destinatario->id,
                        'it_id_notificacoe'=>$Notificacoes->id,
                        'it_estado'=>0
                    ]);
                }
            }
            $this->loggerData(" Cadastrou uma  Notificação " . $request->vc_assunto);

            return redirect()->back()->with('Notificacao.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('Notificacao.create.error',1);
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
        $data["Notificacoes"] = Notificacoes::find($id);


        return view('admin.Notificacao.edit.index',$data);
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
            'vc_assunto'=>'required',
            'lt_descricao'=>'required',
        ],[
            'vc_assunto.required'=>'O Assunto é um campo obrigatório',
            'lt_descricao.required'=>'A Descrição é um campo obrigatório',

        ]);
        try {
            //code...
            $Notificacoes = Notificacoes::find($id);

            $c =Notificacoes::findOrFail($id)->update([
                'vc_assunto'=>$request->vc_assunto,
                'lt_descricao'=>$request->lt_descricao,
                'dt_data'=>$request->dt_data,
                'tm_hora'=>$request->tm_hora,
                'it_id_categoria'=>$request->it_id_categoria,

            ]);
            Destinatario::where('it_id_notificacoe',$Notificacoes->id)->forcedelete();

            if(in_array("All",$request->it_id_turma)){
                foreach(Turma::all() as $turma){
                    $alunos = Aluno::join('matriculas','matriculas.aluno_id','alunos.id')
                    ->join('turmas','matriculas.turma_id','turmas.id')
                    ->select('alunos.user_id')
                    ->where('turmas.id',$turma->id)
                    ->get();
                    foreach($alunos as $aluno){
                        $destinatario=Destinatario::create([
                            'it_id_usuario'=>$aluno->user_id,
                            'it_id_notificacoe'=>$Notificacoes->id
                        ]);
                        Estado_Notificacoe::create([
                            'it_id_usuario'=>$aluno->user_id,
                            'it_id_destinatario'=>$destinatario->id,
                            'it_id_notificacoe'=>$Notificacoes->id,
                            'it_estado'=>0
                        ]);
                    }

                }
            }else{
                $turma_id = $request->it_id_turma;
                $alunos = Aluno::join('matriculas','matriculas.aluno_id','alunos.id')
                ->join('turmas','matriculas.turma_id','turmas.id')
                ->select('alunos.user_id')
                ->where('turmas.id',$turma_id)
                ->get();
                foreach($alunos as $aluno){
                    $destinatario=Destinatario::create([
                        'it_id_usuario'=>$aluno->user_id,
                        'it_id_notificacoe'=>$Notificacoes->id
                    ]);
                    Estado_Notificacoe::create([
                        'it_id_usuario'=>$aluno->user_id,
                        'it_id_destinatario'=>$destinatario->id,
                        'it_id_notificacoe'=>$Notificacoes->id,
                        'it_estado'=>0
                    ]);
                }
            }
            $this->loggerData("Editou o Notificacoes que possui o id $Notificacoes->id  e nome  $Notificacoes->vc_assunto");
            return redirect()->back()->with('Notificacao.update.success',1);
        } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('Notificacao.update.error',1);
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
            $Notificacoes =Notificacoes::findOrFail( $id);

            Notificacoes::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o Notificacoes , ($Notificacoes->vc_assunto)");
            return redirect()->back()->with('Notificacao.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('Notificacao.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $Notificacoes = Notificacoes::findOrFail($id);
            Notificacoes::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a Notificação  ($Notificacoes->vc_assunto)");
            return redirect()->back()->with('Notificacao.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('Notificacao.purge.error',1);
        }
    }
    public function vizualize(Request $request){
        $data['notificacoes']=EstadoNotificacao::join('notificacoes','estado_notificacoes.id_notificacao','notificacoes.id')
            ->join('categoria_notificacoes','notificacoes.id_categoria','categoria_notificacoes.id')
            ->select('notificacoes.*','categoria_notificacoes.vc_nome as categoria')
            ->where('estado_notificacoes.id',$request->id)
            ->first();
        EstadoNotificacao::where('estado_notificacoes.id',$request->id)->update([
            'estado'=>1
        ]);
        return response()->json($data);
    }


}
