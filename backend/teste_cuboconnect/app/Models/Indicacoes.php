<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicacoes extends Model
{
    use HasFactory;
    protected $fillable = ['name','cpf','telefone','email','Status'];

    public function rules()
    {
        return [
            'name' => 'required',
            'cpf' => 'required | unique:Indicacoes,cpf,'.$this->id,
            'telefone' => 'required',
            'email' => 'required',
            'Status' => 'required',
        ];

    }
    public function feedback()
    {
        return [
            'name' => 'O campo :o Nome é obrigatório',
            'cpf.unique' => 'O CPF já existe',
            'telefone' => 'O campo : Telefone é obrigatório',
            'email' => 'O campo : E-mail é obrigatório',
            'Status' => 'O campo : Status é obrigatório',
        ];

    }
}
