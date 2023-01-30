<?php

namespace App\Http\Livewire\Relatorios;

use App\Models\Produto;
use Livewire\Component;
use App\Models\VendaProduto;
use App\Models\Venda;


class Relatorios extends Component
{
    
    public array $vendasPorDia;
    public array $totalProdutosVendidos;
    public array $valorVendidoPorDia;

    protected $listeners = [
        'Produto::create' => '$refresh',
        'Produto::delete' => '$refresh',
        'Venda::create' => '$refresh',
        'Venda::delete' => '$refresh'
    ];


    public function mount()
    {

        // Renderiza relatorios de Vendas por dia
        $this->calcSalesPerDay();

        // totalização de produtos vendidos
        $this->calcTotalProductsSold();

        // total de vendas por dia
        $this->totalSoldPerDay();

    }

    /*
    * Calcula as vendas lançadas, por dia
    */
    public function calcSalesPerDay() {
        // obtem os elementos organizados pela data da venda
        $vendas = Venda::with('produtos')->orderBy('created_at', 'DESC')->get();
        $listaVendas = [];

        // monta coleção de vendas por dia
        foreach ($vendas as $venda) {
            foreach ($venda->produtos as $produto) {
                $dataDaVenda = $venda->created_at->format('d/m/Y');
                $listaVendas[$dataDaVenda][] = [
                    "produto"    => $produto->name,
                    "quantidade" => $produto->pivot->amount,
                    "preco"      => $produto->pivot->sale_price,
                    "horario_venda" => $venda->created_at->format('H:i')
                ];
            }
        }
        $this->vendasPorDia = $listaVendas;
    }

    // Realiza a totalização dos produtos vendidos
    public function calcTotalProductsSold () {
        $vendas = Venda::with('produtos')->orderBy('created_at', 'DESC')->get();

        $listaProdutos = [];
        if (sizeof($vendas) != 0) {
            foreach ($vendas as $venda) {
                foreach ($venda->produtos as $produto) {
                    // Adiciona os ids do produto como chave do array.
                    // Verifica se o produto já existe no array, incrementando total da venda e quantidade
                    if (array_key_exists("$produto->id", $listaProdutos)) {
                        $listaProdutos["$produto->id"]["totalQtd"] += intval($produto->pivot->amount);
                        $listaProdutos["$produto->id"]["totalValorVenda"] += intval($produto->pivot->sale_price);
                    } else {
                        $listaProdutos["$produto->id"]["totalQtd"] = intval($produto->pivot->amount);
                        $listaProdutos["$produto->id"]["totalValorVenda"] = intval($produto->pivot->sale_price);
                    }
                    $listaProdutos["$produto->id"]["nome"] = $produto->name;
                }
            }
            $this->totalProdutosVendidos = $listaProdutos;
        } else {
            $this->totalProdutosVendidos = [];
        }
    }

    /*
    * Somatório de vendas por dia
    */
    public function totalSoldPerDay() {
        $vendas = Venda::with('produtos')->orderBy('created_at', 'DESC')->get();

        $listaVendas = [];
        if (sizeof($vendas) != 0) {
            foreach ($vendas as $venda) {
                
                $dataDaVenda = $venda->created_at->format('d/m/Y');

                foreach ($venda->produtos as $produto) {
                    // Adiciona o data da venda como chave do array.
                    // Incrementa o valor total da venda na chave da data da venda
                    if (array_key_exists("$dataDaVenda", $listaVendas)) {
                        $listaVendas["$dataDaVenda"] += intval($produto->pivot->sale_price);
                    } else {
                        $listaVendas["$dataDaVenda"] = intval($produto->pivot->sale_price);
                    }
                }
            }
            $this->valorVendidoPorDia = $listaVendas;
        } else {
            $this->valorVendidoPorDia = [];
        }
    }

    public function render()
    {
        return view('livewire.relatorios.relatorios');
    }
}

