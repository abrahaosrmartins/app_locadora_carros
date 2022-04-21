<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarcaController extends Controller
{
    /**
     * @var Marca $marca
     */
    protected $marca;

    /**
     * Class constructor
     *
     * @param Marca $marca
     */
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMarcaRequest $createMarcaRequest
     * @return JsonResponse
     */
    public function store(CreateMarcaRequest $createMarcaRequest): JsonResponse
    {
        $marca = $this->marca->create($createMarcaRequest->validated());

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Registro inexistente no banco de dados'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMarcaRequest $updateMarcaRequest
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateMarcaRequest $updateMarcaRequest, int $id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Registro inexistente no banco de dados'], 404);
        }
        $marca->update($updateMarcaRequest->validated());

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Registro inexistente no banco de dados'], 404);
        }
        $marca->delete();

        return response()->json(['msg' => 'Marca removida com sucesso'], 200);
    }
}
