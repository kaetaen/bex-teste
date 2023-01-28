<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\VendaProduto;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'venda_produto', 'venda_id', 'produto_id')->withPivot(['amount', 'sale_price']);
    }
}
