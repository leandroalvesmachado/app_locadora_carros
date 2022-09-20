<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $marcas = Marca::all();
        $marcas = $this->marca->all();
        
        return response()
            ->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // stateless
        // Accept: application/json (API validação) status code 422
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $image = $request->file('imagem');
        $image->store('imagens','public');

        $marca = $this->marca->create($request->all());

        return response()
            ->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            // return [
            //     'erro' => 'Recurso pesquisado não existe'
            // ];

            return response()
                ->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        return response()
            ->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()
                ->json(['erro' => 'Impossível realizar a atualização. Recurso pesquisado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = [];

            // percorrendo todas as regras definidas no Model
            foreach ($marca->rules() as $input => $regra) {
                // coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        $marca->update($request->all());

        return response()
            ->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()
                ->json(['erro' => 'Impossível realizar a exclusão. Recurso pesquisado não existe'], 404);
        }

        $marca->delete();

        return response()
            ->json(['msg' => 'A marca foi removida com sucesso.'], 200);
    }
}
