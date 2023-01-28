<?php

namespace App\Http\Livewire\Vendas;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Venda;
use WireUi\Traits\Actions;

class Create extends Component
{

    use Actions;

    public $products;
    public $amount;
    public $selectedProduct;

    protected $rules=[
        'selectedProduct'=>['required'],
        'amount'=>['required'],
    ];

    protected $messages = [
        'selectedProduct.required' => 'O campo Produto é obrigatório.',
        'amount.required' => 'O campo Quantidade é obrigatório.',
    ];

    public function mount() {
        $this->getProducts();
    }
    
    public function getProducts() {
        $products = Produto::get(['name', 'id'])->toArray();

        $this->products = $products;
    }

    /*
    * Metodo responsável por registrar as vendas
    */
    public function registerSail() {
        $this->validate();

        // Cria uma instancia de venda e recupera o produto selecionad
        // do banco de dados
        $sail = new Venda();
        $sail->save();
        $product = Produto::find($this->selectedProduct);
        
        // calculo do valor total da venda: Preço Produto x Quantidade
        $totalValue = $product->price * $this->amount;

        // Registra a venda
        $sail->produtos()->attach($product, ['amount' => $this->amount,'sale_price' => $totalValue]);
        
        $this->notification()->notify([
            'title'       => 'Sucesso!',
            'description' => 'Sua Venda foi salvo com sucesso',
            'icon'        => 'success',
            'timeout'     =>    2000
        ]);

        // Emite um evento de create para a Venda
        $this->emit('Venda::create');

        $this->clean();
    }

    private function clean(){
        $this->selectedProduct="";
        $this->amount=0;
    }

    public function render()
    {
        return view('livewire.vendas.create');
    }
}
