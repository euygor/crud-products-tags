@extends('layouts.template')

@section('title', 'Home')

@section('links')
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
@endsection

@section('container')
    <div class="row justify-content-center">
        <h2 class="text-center p-5">Produtos Recentes</h2>
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
