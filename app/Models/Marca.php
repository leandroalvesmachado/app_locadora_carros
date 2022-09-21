<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules()
    {
        $id = $this->id ?? 'null';

        return [
            'nome' => 'required|unique:marcas,nome,'.$id.'|min:3',
            'imagem' => 'required|file|mimes:png'
        ];

        /*
            Unique
            1) Tabela
            2) nome da coluna que será pesquisada na tabela
            3) id do registro que será desconsiderado na pesquisa
        */
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigátorio',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];
    }

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
