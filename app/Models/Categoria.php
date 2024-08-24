<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'icone',
        'descricao',
    ];


    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function getIconeUrlAttribute()
    {
        return asset('storage/' . $this->icone);
    }



    public function scopeSearch($query, $request)
    {
        return $query
            ->when($request->nome, function ($query, $nome) {
                return $query->where('nome', 'like', '%' . $nome . '%');
            });
    }

}
