@extends('layouts.template')

@section('title', 'Cadastro')

@section('container')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="text-center p-5">
                <h1>Faça seu Cadastro</h1>
            </div>
            <form id="cadastroForm">
                <div role="alert" id="msg"></div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Informe seu nome">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Informe seu e-mail">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Informe sua senha">
                </div>
                <br />
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>

@section('ajax')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#cadastroForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('actionCadastro') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#cadastroForm').serialize(),
                success: function(data) {
                    if (data.success == true) {
                        $('#cadastroForm').trigger('reset');
                        $('#msg').removeClass('alert alert-danger text-center').addClass(
                            'alert alert-success text-center').html(data.message);
                    } else {
                        $('#msg').removeClass('alert alert-success text-center').addClass(
                            'alert alert-danger text-center').html(data.message);
                    }
                }
            });
        });
    </script>
@endsection
@endsection
