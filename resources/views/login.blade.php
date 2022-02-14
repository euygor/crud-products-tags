@extends('layouts.template')

@section('title', 'Login')

@section('container')
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="text-center p-5">Faça seu Login</h1>
            <form id="loginForm">
                <div role="alert" id="msg"></div>
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
                <button type="submit" class="btn btn-primary">Entrar</button>
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

        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('actionLogin') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#loginForm').serialize(),
                success: function(data) {
                    if (data.success == true) {
                        window.location.href = '{{ route('home') }}';
                    } else {
                        $('#loginForm').trigger('reset');
                        $('#msg').removeClass('alert alert-danger text-center').addClass(
                            'alert alert-danger text-center').html(data.message);
                    }
                }
            });
        });
    </script>
@endsection
@endsection
