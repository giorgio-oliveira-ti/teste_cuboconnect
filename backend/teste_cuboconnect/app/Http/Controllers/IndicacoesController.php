<?php

namespace App\Http\Controllers;

use App\Models\Indicacoes;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class IndicacoesController extends Controller
{
    public function __construct(Indicacoes $Indicacoe)
    {
            $this->Indicacoe = $Indicacoe;
    }

    public function index(Request $request)
    {
        if($request->has('atributos')){
            $atributos = $request->atributos;
            $indicacoes = $this->Indicacoe->selectRaw($atributos)->get();

            if( $request->has('filtro')){
                $condicoes = explode(':',$request->filtro);
                $indicacoes = $indicacoes->where($condicoes[0],$condicoes[1],$condicoes[2]);
                $teste = explode(':',$indicacoes);

                if(!isset($teste[1])){

                    $indicacoes="0";

                }else{

                    $VerificarCpf = explode(':',$indicacoes);

                    if($VerificarCpf != ""){

                        if(isset($VerificarCpf)){
                            $VerificarCpf = str_replace('"','',$VerificarCpf);
                            $VerificarCpf = str_replace('{','',$VerificarCpf);
                            $VerificarCpf = str_replace('}','',$VerificarCpf);
                            $VerificarCpf = str_replace('cpf','',$VerificarCpf);
                            $VerificarCpf = str_replace('[','',$VerificarCpf);
                            $VerificarCpf = str_replace(']','',$VerificarCpf);
                            $indicacoes = $VerificarCpf;


                        }
                    }
                }
            }

         }else{
             $indicacoes =  $this->Indicacoe->all();
         }

        return response()->json($indicacoes,200);
    }

    public function store(Request $request)
    {
        $request->validate($this->Indicacoe->rules(), $this->Indicacoe->feedback());
        $Indicacoe = $this->Indicacoe->Create($request->all());
        return response()->json($Indicacoe,201);
    }

    public function show($id)
    {
        $Indicacoe = $this->Indicacoe->find($id);
        if( $Indicacoe === null){
            return response()->json(['error'=> 'Indcação não localizado'],404);
        }
         return $Indicacoe;
    }


    public function update(Request $request, $id)
    {
        $Indicacoe = $this->Indicacoe->find($id);
        if( $Indicacoe === null){
            return response()->json(['error'=> 'Insira algum valor para ser feito atualização'],404);
        }

        if($request->method() === 'PATCH'){

           $regrasDinamicas = array();
           foreach($Indicacoe->rules() as $input => $regra){
            if(array_key_exists($input,$request->all())){
                $regrasDinamicas[$input] = $regra;
            }
           }
           $request->validate($regrasDinamicas, $Indicacoe->feedback());
        }else{

            $request->validate($Indicacoe->rules(), $Indicacoe->feedback());
        }
        $Indicacoe->update($request->all());
        return response()->json($Indicacoe,200);
    }


    public function destroy($id)
    {
        $Indicacoe = $this->Indicacoe->find($id);
        if( $Indicacoe === null){
            return response()->json(['error'=> 'Valor não encontrado'],404);
        }
        $Indicacoe->delete();
        return response()->json(['msg' => 'A indicação foi excluida com sucesso!'],200);
    }
}
