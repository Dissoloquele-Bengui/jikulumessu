<div class="row">
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="name">Nome Completo*</label>
            <input type="text"   id="name" name="name" class="form-control" value="{{isset($user) ?$user->name: old('name') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="password">Password*</label>
            <input type="password"    name="password" class="form-control"  required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="email">E-mail*</label>
            <input type="email"   id="email" name="email" class="form-control" value="{{isset($user) ?$user->email: old('email') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="genero">Genero*</label>
            <select name="genero" class="form-control select2">
                    <option value="Masculino" {{isset($user)?$user->nivel=="Masculino"?'selected':'':''}}>Masculino</option>

                    <option value="Feminino" {{isset($user)?$user->nivel=="Feminino"?'selected':'':''}}>Feminino</option>

            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="tipo">Nível de Acesso*</label>
            <select name="tipo"
                id="nivel{{isset($user)?$user->id:''}}" onchange="{{isset($user)?'addFieldUserUpdate('.$user->id.')':'addFieldUser()'}}" class="form-control select2">
                @if (isset($proprietario_view))
                    <option value="Proprietário" {{isset($user)?$user->nivel=="Proprietário"?'selected':'':''}}>Proprietário de um Veiculo</option>
                @elseif(isset($cliente_view))
                    <option value="Cliente Singular" {{isset($user)?$user->nivel=="Cliente Singular"?'selected':'':''}}>Cliente Singular</option>
                @else
                    <option value="Administrador" {{isset($user)?$user->nivel=="Administrador"?'selected':'':''}}>Administrador</option>
                    <option value="Funcionário" {{isset($user)?$user->nivel=="Funcionário"?'selected':'':''}}>Funcionário</option>
                    <option value="Cliente Singular" {{isset($user)?$user->nivel=="Cliente Singular"?'selected':'':''}}>Cliente Singular</option>
                    <option value="Proprietário" {{isset($user)?$user->nivel=="Proprietário"?'selected':'':''}}>Proprietário de um Veiculo</option>

                @endif
            </select>
        </div>
    </div>

</div>

<div class="row" id="fieldUser{{isset($user)?$user->id:''}}">
    @if (isset($user) )

        @if( $user->nivel=="Cliente Singular")
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto*</label>
                    <input type="number"    name="numero[0]" value="{{contacto($user->id)[0]}}" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto 2*</label>
                    <input type="number"    name="numero[1]" value="{{contacto($user->id)[1]}}" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto 3*</label>
                    <input type="number"    name="numero[2]" value="{{contacto($user->id)[2]}}" class="form-control"  required>
                </div>
            </div>
        @endif
        @if( $user->nivel == "Proprietário")
            <div class="col-md-6">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto*</label>
                    <input type="number"    name="numero[0]" value="{{contacto($user->id)[0]}}" class="form-control"  required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3 form-group">
                    <label for="id_empresa">Empresa*</label>
                    <select name="id_empresa" id="" class="form-control select2">
                        @foreach($empresas as $empresa)
                            <option value="{{$empresa->id}}" {{$user->id_empresa == $empresa->id ?'selected':''}}>
                                {{$empresa->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> <!-- /.col -->
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="marca">Marca*</label>
                    <input type="text"    name="marca" value="{{$user->marca}}" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="modelo">Modelo*</label>
                    <input type="text"    name="modelo" value="{{$user->modelo}}" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Matricula*</label>
                    <input type="text"    name="matricula" value="{{$user->matricula}}" class="form-control"  required>
                </div>
            </div>
        @endif
        @if( $user->nivel == "Funcionário")

            <div class="col-md-12">
                <div class="mb-3 form-group">
                    <label for="id_empresa">Empresa*</label>
                    <select name="id_empresa" id="" class="form-control select2">
                        @foreach($empresas as $empresa)
                            <option value="{{$empresa->id}}" {{$user->id_empresa == $empresa->id ?'selected':''}}>
                                {{$empresa->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> <!-- /.col -->
        @endif
    @else

        @if( isset($cliente_view))
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto*</label>
                    <input type="number"    name="numero[0]" value="" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto 2*</label>
                    <input type="number"    name="numero[1]" value="" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto 3*</label>
                    <input type="number"    name="numero[2]" value="" class="form-control"  required>
                </div>
            </div>
        @endif
        @if( isset($proprietario_view))
            <div class="col-md-6">
                <div class="mb-3 form-group">
                    <label for="numero">Contacto*</label>
                    <input type="number"    name="numero[0]" value="" class="form-control"  required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3 form-group">
                    <label for="id_empresa">Empresa*</label>
                    <select name="id_empresa" id="" class="form-control select2">
                        @foreach($empresas as $empresa)
                            <option value="{{$empresa->id}}" >
                                {{$empresa->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> <!-- /.col -->
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="marca">Marca*</label>
                    <input type="text"    name="marca" value="" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="modelo">Modelo*</label>
                    <input type="text"    name="modelo" value="" class="form-control"  required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3 form-group">
                    <label for="numero">Matricula*</label>
                    <input type="text"    name="matricula" value="" class="form-control"  required>
                </div>
            </div>
        @endif
    @endif
</div>
