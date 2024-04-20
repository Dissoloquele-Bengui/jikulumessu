<div class="row">
    <div class="col-md-12">
        <div class="mb-3 form-group">
            <label for="nome">Nome*</label>
            <input type="text"   name="nome" class="form-control" value="{{isset($equipa) ?$equipa->nome: old('nome') }}" required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-12">
        <div class="mb-3 form-group">
            <label for="logo">Logo*</label>
            <input type="file"   name="logo" class="form-control"  {{isset($equipa)? 'required' :'' }} >
        </div>
    </div> <!-- /.col -->
</div>
