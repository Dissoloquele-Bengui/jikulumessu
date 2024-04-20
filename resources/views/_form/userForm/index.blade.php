<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="name">Nome Completo*</label>
            <input type="text"   id="name" name="name" class="form-control" value="{{isset($user) ?$user->name: old('name') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="password">Password*</label>
            <input type="password"    name="password" class="form-control"  required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="email">E-mail*</label>
            <input type="email"   id="email" name="email" class="form-control" value="{{isset($user) ?$user->email: old('email') }}" required>
        </div>
    </div>


    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="tipo">Nível de Acesso*</label>
            <select name="tipo"
                id="nivel{{isset($user)?$user->id:''}}" class="form-control select2">
                    @if (!isset($campeonato_view))
                        <option value="Admin de Campeonato" {{isset($user)?$user->tipo=="Admin de Campeonato"?'selected':'':''}}>Administrador de Campeonato</option>

                        <option value="Administrador" {{isset($user)?$user->tipo=="Administrador"?'selected':'':''}}>Administrador</option>
                    @else
                        <option value="Admin de Campeonato" {{isset($user)?$user->tipo=="Admin de Campeonato"?'selected':'':''}}>Administrador de Campeonato</option>

                    @endif
            </select>
        </div>
    </div>

</div>
