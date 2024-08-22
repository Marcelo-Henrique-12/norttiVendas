<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';
    protected $fillable = ['total', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'vendas_produtos')->withPivot('quantidade');
    }

    public function scopeSearch($query, $request)
    {
        return $query
            ->when($request->data, function ($query, $data) {
                return $query->whereDate('created_at', $data);
            })->when($request->ordenar, function ($query, $ordenar) {
                if ($ordenar === 'data_crescente') {
                    return $query->orderBy('created_at', 'asc');
                } elseif ($ordenar === 'data_decrescente') {
                    return $query->orderBy('created_at', 'desc');
                }
            }) ->when($request->produto_id, function ($query, $produto_id) {
                return $query->whereHas('produtos', function ($query) use ($produto_id) {
                    $query->where('produto_id', $produto_id);
                });
            });
    }
}
