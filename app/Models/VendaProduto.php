<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Produto;
use App\Models\Venda;

class VendaProduto extends Model
{
    use HasFactory;

    protected $table = 'venda_produto';

    protected $fillable = ['venda_id', 'produto_id', 'amount','sale_price'];

    public function venda() {
        return $this->belongsTo(Venda::class);
    }

    public function produto() {
        return $this->belongsTo(Produto::class);
    }

}
