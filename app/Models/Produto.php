<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Venda;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = ['id','name','price','description'];

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'venda_produto', 'produto_id', 'venda_id')->onDelete('cascade');
    }
}
