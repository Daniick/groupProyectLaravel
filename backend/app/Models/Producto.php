<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'nombre',
        'cod',
        'precio',
        'marca',
        'id_categoria',
        'costo',
        'cantidad',
  
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
