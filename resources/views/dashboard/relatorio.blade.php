<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Commerce - Relatório de Relevância</title>
</head>

<body>
    <style>
        .text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-flex {}

    </style>
    <h4 class="text-center">Relatório de Relevância: {{ $date }}</h4>
    <p>OBS: Quanto mais tags maior a relevância do produto.</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço R$</th>
                <th>Quantidade de Tags</th>
            </tr>
        </thead>
        @if (count($products) > 0)
            @foreach ($products as $product)
                <tbody class="text-center">
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->preco, 2, ',', '.') }}</td>
                        <td>{{ $product->qtdTags }}</td>
                    </tr>
                </tbody>
            @endforeach
        @endif
    </table>
    @if (count($products) == 0)
        <p class="text-center">Nenhum produto cadastrado.</p>
    @endif
</body>

</html>
