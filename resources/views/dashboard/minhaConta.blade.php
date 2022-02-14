@extends('layouts.template')

@section('title', 'Minha Conta')

@section('container')
    <div class="row justify-content-center">
        <div class="col-6">
            <h2 class="text-center p-5">Avatar</h2>
            <form method="POST" action="{{route('actionMinhaContaAvatar')}}" enctype="multipart/form-data">
                @csrf
                <div class="text-center">
                    <img src="{{Auth::user()->avatar ? '/uploads/avatar/'.Auth::user()->avatar:'/images/avatar.png'}}" class="rounded-circle" style="width: 150px;" alt="Avatar"/>
                </div>
                <br />
                @if ($danger)
                <div class="alert alert-danger text-center" role="alert">
                    {{$danger}}
                </div>
                @endif
                @if ($success)
                <div class="alert alert-success text-center" role="alert">
                    {{$success}}
                </div>
                @endif
                @if ($warning)
                <div class="alert alert-warning text-center" role="alert">
                    {{$warning}}
                </div>
                @endif
                <div class="form-group">
                    <br />
                    <input type="file" class="form-control-file" id="file" name="file">
                    <br />
                    <br />
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
            <h3 class="text-center pt-5">Meus Dados</h3>
            <form id="atualizarForm">
                <div role="alert" id="msg"></div>
                <div class="form-group">
                    <label for="email">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Informe seu nome" value="{{Auth::user()->name}}">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Informe seu e-mail" value="{{Auth::user()->email}}">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Informe sua nova senha">
                </div>
                <br />
                <button type="submit" class="btn btn-primary">Atualizar</button>
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

        $('#atualizarForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('actionMinhaConta') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#atualizarForm').serialize(),
                success: function(data) {
                    if (data.success == true) {
                        console.log(data.message);
                        $('#msg').removeClass('alert alert-danger text-center').addClass('alert alert-success text-center').html(data.message);
                    } else {
                        $('#msg').removeClass('alert alert-success text-center').addClass('alert alert-danger text-center').html(data.message);
                    }
                }
            });
        });
    </script>
@endsection
@endsection
