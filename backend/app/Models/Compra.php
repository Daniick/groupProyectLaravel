<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_factura',
        'proveedore_id',
    ];

    public function proveedore()
    {
        return $this->belongsTo(Proveedore::class, 'proveedore_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }
}
