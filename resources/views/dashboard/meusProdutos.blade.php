@extends('layouts.template')

@section('title', 'Meus Produtos')

@section('links')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
@endsection

@section('container')
    <div class="row justify-content-center">
        <h2 class="text-center p-5">Meus Produtos</h2>
        <div class="col-6">
            <div class="text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Cadastrar Produto
                </button>
                <br />
                <br />
                @if ($danger)
                    <div class="alert alert-danger text-center" role="alert">
                        {{ $danger }}
                    </div>
                @endif
                @if ($success)
                    <div class="alert alert-success text-center" role="alert">
                        {{ $success }}
                    </div>
                @endif
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar Produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('meusProdutosAction') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Informe o nome">
                                </div>
                                <div class="form-group">
                                    <label for="img">Imagem</label>
                                    <br />
                                    <input type="file" class="form-control-file" id="img" name="img">
                                </div>
                                <div class="form-group">
                                    <label for="preco">Preço</label>
                                    <input type="number" class="form-control" id="preco" name="preco"
                                        placeholder="Informe o preço">
                                </div>
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="descricao">Tags</label>
                                    <input id="tags" name='tags' value="" class="form-control">
                                </div>
                                <p style="font-size: 12px">OBS: Após escrever cada tag aperte ENTER ou clique duas vezes na
                                    tag para EDITAR</p>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            @if (!empty($products) && count($products) > 0)
                <section>
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-5 mb-md-0">
                                <div class="text-center">
                                    <div class="card testimonial-card">
                                        <div class="card-up" style="background-color: #9d789b;"></div>
                                        <div class="avatar mx-auto bg-white" style="width:100%;height: 200px;">
                                            <img src="/uploads/images/{{ $product->img }}" class="img-fluid" />
                                        </div>
                                        <div class="card-body">
                                            <h4 class="mb-4">{{ ucwords($product->name) }}</h4>
                                            <hr />
                                            <p class="dark-grey-text mt-4">
                                                <input id="tags2{{ $product->id }}"
                                                    value="{{ str_replace('#', ',', $product->tags) }}"
                                                    class="form-control" readonly>
                                                <script>
                                                    var input2{{ $product->id }} = document.querySelector('#tags2{{ $product->id }}');
                                                    var tags2{{ $product->id }} = new Tagify(input2{{ $product->id }});
                                                </script>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="text-center">
                                    <!-- Button VIEW trigger modal -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal1{{ $product->id }}">
                                        Ver
                                    </button>
                                    <!-- Button UPDATE trigger modal -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal2{{ $product->id }}">
                                        Editar
                                    </button>
                                    <!-- Button DELETE trigger modal -->
                                    <a href="{{ route('meusProdutosDeleteAction', ['id' => $product->id]) }}"
                                        onclick="return confirm('Tem certeza que deseja excluir esse produto?')"
                                        ype="button" class="btn btn-danger">
                                        Excluir
                                    </a>
                                </div>
                                <!-- Modal VIEW -->
                                <div class="modal fade" id="exampleModal1{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel1{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1{{ $product->id }}">
                                                    Produto: {{ ucwords($product->name) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="name">Nome</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            value="{{ ucwords($product->name) }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="img">Imagem</label>
                                                        <br />
                                                        <img src="/uploads/images/{{ $product->img }}"
                                                            class="img-fluid" style="width:100%;height: 200px;" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="preco">Preço</label>
                                                        <input type="text" class="form-control" id="preco" name="preco"
                                                            value="R$ {{ number_format($product->preco, 2, ',', '.') }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descricao">Descrição</label>
                                                        <textarea class="form-control" id="descricao" name="descricao"
                                                            rows="3" readonly>{{ $product->descricao }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tags">Tags</label>
                                                        <input id="tags3{{ $product->id }}"
                                                            value="{{ str_replace('#', ',', $product->tags) }}"
                                                            class="form-control" readonly>
                                                        <script>
                                                            var input3{{ $product->id }} = document.querySelector('#tags3{{ $product->id }}');
                                                            var tags3{{ $product->id }} = new Tagify(input3{{ $product->id }});
                                                        </script>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal UPDATE -->
                                <div class="modal fade" id="exampleModal2{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel2{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel2{{ $product->id }}">
                                                    Produto: {{ ucwords($product->name) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('meusProdutosUpdateAction') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Nome</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            value="{{ $product->name }}" placeholder="Informe o nome">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="img">Imagem</label>
                                                        <br />
                                                        <img src="/uploads/images/{{ $product->img }}"
                                                            class="img-fluid" style="width:100%;height: 200px;" />
                                                        <br />
                                                        <input type="file" class="form-control-file" id="img" name="img">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="preco">Preço</label>
                                                        <input type="number" class="form-control" id="preco" name="preco"
                                                            value="{{ $product->preco }}" placeholder="Informe o preço">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="descricao">Descrição</label>
                                                        <textarea class="form-control" id="descricao" name="descricao"
                                                            rows="3">{{ $product->descricao }}</textarea>
                                                    </div>
                                                    <label for="tags">Tags</label>
                                                    <input id="tags4{{ $product->id }}"
                                                        value="{{ str_replace('#', ',', $product->tags) }}" name="tags"
                                                        class="form-control">
                                                    <script>
                                                        var input4{{ $product->id }} = document.querySelector('#tags4{{ $product->id }}');
                                                        var tags4{{ $product->id }} = new Tagify(input4{{ $product->id }}, {
                                                            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join('#')
                                                        });
                                                    </script>
                                                    <p style="font-size: 12px">OBS: Após escrever cada tag aperte ENTER ou
                                                        clique duas vezes na
                                                        tag para EDITAR</p>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    Nenhum produto cadastrado!
                </div>
            @endif
        </div>
    </div>
@section('ajax')

    <script>
        var input = document.querySelector('#tags');
        var tags = new Tagify(input, {
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join('#')
        });
    </script>

@endsection
@endsection
