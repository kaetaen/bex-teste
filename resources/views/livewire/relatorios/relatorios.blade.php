<div class="my-2">

    <x-card class="border-info-800 my-2  " title="Relatórios">

        <div class="relatorios">
            <div class="overflow-auto h-52 mt-4">
                <div class="text-center border shadow text-gray-800 text-2xl">📋 Produtos Vendidos por Dia</div>
                @if ($vendasPorDia)
                    
                    @foreach($vendasPorDia as $dataDaVenda => $produtos)
                    <table wire:loading.class="hidden"
                        class="table-auto border-collapse w-full mt-4">
                        <thead>
                        <tr class="text-center">
                            
                            <th colspan="4" class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8"> {{ $dataDaVenda }}
                            </th>
                        </tr>
                        </tr>
                        <tr class="rounded-lg text-sm font-medium text-gray-700 text-left table-row"
                            style="font-size: 0.9674rem">
                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8"> Produto
                            </th>

                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Quantidade
                            </th>
                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Preço
                            </th>

                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">
                            Horario da venda
                            </th>
                        </tr>

                        </thead>
                        <tbody class="text-sm font-normal text-gray-700 w-full">
                            @foreach($produtos as $produto)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-2 ">

                                <td class="px-4 py-1">{{ $produto["produto"] }} </td>
                                <td class="px-4 py-1">{{ $produto["quantidade"] }}</td>
                                <td class="px-4 py-1">R$ {{ $produto["preco"] }}</td>
                                <td class="px-4 py-1">{{ $produto["horario_venda"] }}</td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    @endforeach
                @else
                    <div class="text-center text-gray-800 text-1xl">Nenhuma venda foi efetuada</div>
                @endif

            </div>

            <div class="overflow-auto h-52 mt-4">
                <div class="text-center border shadow text-gray-800 text-2xl">📋 Totalização de produtos vendidos (Quantidade e Valor) </div>
                @if ($totalProdutosVendidos)
                    
                    <table wire:loading.class="hidden" class="table-auto border-collapse w-full mt-4">
                        <thead>
                        </tr>
                        <tr class="rounded-lg text-sm font-medium text-gray-700 text-left table-row"
                            style="font-size: 0.9674rem">
                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8"> Produto
                            </th>

                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Quantidade Total
                            </th>
                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Valor Total
                            </th>
                        </tr>

                        </thead>
                        <tbody class="text-sm font-normal text-gray-700 w-full">
                            @foreach($totalProdutosVendidos as $produto)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-2 ">
                                <td class="px-4 py-1">{{ $produto["nome"] }} </td>
                                <td class="px-4 py-1">{{ $produto["totalQtd"] }}</td>
                                <td class="px-4 py-1">R$ {{ $produto["totalValorVenda"] }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <div class="text-center text-gray-800 text-1xl">Nenhuma venda foi efetuada</div>
                @endif

            </div>

            <div class="overflow-auto h-52 mt-4">
                <div class="text-center border shadow text-gray-800 text-2xl">📋 Totalização de vendas por dia </div>
                @if ($valorVendidoPorDia)
                    
                    <table wire:loading.class="hidden" class="table-auto border-collapse w-full mt-4">
                        <thead>
                        </tr>
                        <tr class="rounded-lg text-sm font-medium text-gray-700 text-left table-row"
                            style="font-size: 0.9674rem">
                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8"> Data
                            </th>

                            <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Valor Total
                            </th>
                        </tr>

                        </thead>
                        <tbody class="text-sm font-normal text-gray-700 w-full">
                            @foreach($valorVendidoPorDia as $dataDaVenda => $valorVenda)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-2 ">
                                <td class="px-4 py-1">{{ $dataDaVenda }} </td>
                                <td class="px-4 py-1">R$ {{ $valorVenda }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <div class="text-center text-gray-800 text-1xl">Nenhuma venda foi efetuada</div>
                @endif

            </div>
        </div>


    </x-card>
</div>