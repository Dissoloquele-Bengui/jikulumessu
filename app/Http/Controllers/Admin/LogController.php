<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gestor;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['restaurantes'] = Gestor::join('restaurantes', 'gestores.id_restaurante', 'restaurantes.id')
            ->select('restaurantes.*')
            ->where('id_usuario', Auth::user()->id)
            ->get();

        $usuarios = collect();

        foreach ($data['restaurantes'] as $restaurante) {
            $usuariosDoRestaurante = Gestor::join('users', 'gestores.id_usuario', 'users.id')
                ->select('users.*')
                ->where('id_restaurante', $restaurante->id)
                ->get();
            foreach($usuariosDoRestaurante as $usuario){
                $usuario->id_restaurante = $data['restaurantes']->unique('id')->pluck('id')->toArray();
            }
            // Adicionar usuários do restaurante ao conjunto
            $usuarios = $usuarios->merge($usuariosDoRestaurante)->unique('id');
        }

        $usuarios = $usuarios->values()->pluck('id')->toArray();

        if(!Auth::user()->nivel=="Administrador"){
            $data['logs']=Logs::join('users','logs.it_id_user','users.id')
            ->select("logs.*",'users.name as nome')
            ->whereIn('it_id_user',$usuarios)
            ->get();

        }else{
            $data['logs']=Logs::join('users','logs.it_id_user','users.id')
                ->select("logs.*",'users.name as nome')
                ->get();
        }
        return view('admin.logs.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
