<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'foto',
        'valor',
        'categoria_id',
        'quantidade'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getFotoUrlAttribute()
    {
        return asset('storage/' . $this->foto);
    }

    public function scopeSearch($query, $request)
    {
        return $query
            ->when($request->nome, function ($query, $nome) {
                return $query->where('nome', 'like', '%' . $nome . '%');
            })
            ->when($request->categoria_id, function ($query, $categoria_id) {
                return $query->where('categoria_id', $categoria_id);
            });
    }
}
