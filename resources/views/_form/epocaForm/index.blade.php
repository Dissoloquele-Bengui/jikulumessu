<div class="row">
    <div class="col-md-12">
        <div class="mb-3 form-group">
            <label for="nome">Nome*</label>
            <input type="text"   name="nome" class="form-control" value="{{isset($epoca) ?$epoca->nome: old('nome') }}" required>
        </div>
    </div> <!-- /.col -->
</div>
