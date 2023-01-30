<?php

namespace App\Http\Livewire\Indicador;

use App\Models\Produto;
use Livewire\Component;
use App\Models\VendaProduto;
use App\Models\Venda;


class Indicador extends Component
{
    public int $totalProduto;
    public string $produtoMaisCaro;
    public $vendaMaiorFaturamento;
    public string $produtoMaisVendido;
    public string $produtoMenosVendido;
    public $ticketMedio;
    public string $transacoesRealizadas;
    public string $totalProdutosVendidos;
    public string $produtoMaisBarato;

    protected $listeners = [
        'Produto::create' => '$refresh',
        'Produto::delete' => '$refresh',
        'Venda::create' => '$refresh',
        'Venda::delete' => '$refresh'
    ];


    public function mount()
    {
        $this->totalProduto = Produto::count();

        !$this->totalProduto ? : $this->produtoMaisCaro = Produto::select('name','price')
                                                        ->orderBy('price','desc')->first();

        !$this->totalProduto ? :$this->produtoMaisBarato = Produto::select('name','price')
                                                        ->orderBy('price','asc')->first();
        // indicador de venda com maior faturamento
        $this->vendaMaiorFaturamento = VendaProduto::select('sale_price')
                                            ->orderby('sale_price', 'desc')->first();        
        $this->vendaMaiorFaturamento ? $this->vendaMaiorFaturamento = $this->vendaMaiorFaturamento->sale_price : $this->vendaMaiorFaturamento = 0;
        
        // Indicador produto mais vendido e menos
        $this->calcBestSellingProduct();

        // indicador de ticket médio
        $this->calcAverageTicket();

        // indicador de transações realizadas (vendas)
        Venda::count() ? $this->transacoesRealizadas = Venda::count() : $this->transacoesRealizadas = 0;

        // Indicador de total de produtos vendidos
        $this->calcTotalSailProducts();
    }

    /*
    * Calcula o produto mais vendido e menos vendido
    */
    private function calcBestSellingProduct () {
        $vendaProduto = VendaProduto::all();
        if (sizeof($vendaProduto) != 0) {
            $produtoLista = [];
            foreach ($vendaProduto as $venda) {
                // salva o id do produto como chave no array.
                // vai incrementando a quantidade de produtos vendidos
                if (array_key_exists("$venda->produto_id", $produtoLista)) {
                    $produtoLista["$venda->produto_id"] += (intval($venda->amount) + 0);
                } else {
                    $produtoLista["$venda->produto_id"] = (intval($venda->amount) + 0);
                }
            }

            // Obtém o ID (chave do array) do produto com maior quantidade de vendas no array
            $idProdutoMaisVendido = key(collect($produtoLista)->sortByDesc(function($valor, $chave) {
                return $chave;
            })->toArray());

            // Obtém o ID (chave do array) do produto com menor quantidade de vendas no array
            $idProdutoMenosVendido = key(collect($produtoLista)->sortBy(function($valor, $chave) {
                return $chave;
            })->toArray());

            $produtoMaisVendido = Produto::find($idProdutoMaisVendido);
            $produtoMenosVendido = Produto::find($idProdutoMenosVendido);

            $this->produtoMaisVendido = $produtoMaisVendido->name;
            $this->produtoMenosVendido = $produtoMenosVendido->name;

        } else {
            $this->produtoMaisVendido = "—";
            $this->produtoMenosVendido = "—";
        }
    }

    // Calcula o ticket médio
    public function calcAverageTicket () {
        $qtdVenda = Venda::count();
        $vendaProduto = VendaProduto::all();

        if($qtdVenda && sizeof($vendaProduto) != 0) {
            $totalFaturamento = $vendaProduto->pluck('sale_price')->sum();
            $this->ticketMedio = $totalFaturamento / $qtdVenda;
        } else {
            $this->ticketMedio = 0;
        }
    }

    /*
    * Calcula total de produtos vendidos
    */
    public function calcTotalSailProducts()
    {
        $vendas = Venda::with('produtos')->orderBy('created_at', 'DESC')->get();
        $totalItensVendidos = 0;
        if (sizeof($vendas) != 0) {

            // Incrementa a quantidade de produtos vendidos
            foreach ($vendas as $venda) {
                foreach ($venda->produtos as $produto) {
                    $totalItensVendidos += $produto->pivot->amount;
                }
            }
            
            $this->totalProdutosVendidos = $totalItensVendidos;
        } else {
            $this->totalProdutosVendidos = 0;
        }
    }

    public function render()
    {
        return view('livewire.indicador.indicador');
    }
}

