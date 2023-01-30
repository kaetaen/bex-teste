<?php

namespace App\Http\Livewire\Vendas;

use App\Models\Produto;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
use App\Models\Venda;

class Show extends Component
{
    use WithPagination;

    use Actions;
    public string $search ='';

    #escuta todos eventos emitidos e toma uma ação
    protected $listeners=[
        'Venda::create'=>'$refresh',
        'Venda::delete'=>'$refresh',
        'Produto::delete' => '$refresh'
    ];
    # reseta a paginação
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.vendas.show', [
            'vendas'=>  \App\Models\Venda::with(['produtos'])
                            ->whereHas('produtos', function ($query) { 
                                $query->where('name', 'like', '%'.$this->search.'%'); 
                            })->get()

        ]);
    }

    public function message($idSail)
    {
        
        $this->dialog()->confirm([
            'title'       => 'Ola, você esta preste a deletar esta venda?',
            'description' => 'Deseja continuar?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Sim, deletar',
                'method' => 'delete',
                'params' => $idSail,
            ],
            'reject' => [
                'label'  => 'No, cancel',
                'method' => 'render',
            ],
        ]);
        
    }

    public function delete($idSail)
    {
        Venda::where('id', $idSail)->delete();
        $this->notification()->notify([
            'title'       => 'Sucesso!',
            'description' => 'Sua venda foi deletada',
            'icon'        => 'success',
            'timeout'     => 1000
        ]);

        $this->emit('Venda::delete');
    }
}
