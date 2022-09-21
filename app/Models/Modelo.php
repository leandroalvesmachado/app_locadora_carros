<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function rules()
    {
        $id = $this->id ?? 'null';

        return [
            'marca_id' => 'required|exists:marcas,id',
            'nome' => 'required|unique:marcas,nome,'.$id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpg,jpeg',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' //true (1, "1"), false (0, "0")
        ];
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
