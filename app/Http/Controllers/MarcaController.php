<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
        $marcas = $this->marca->with('modelos')->get();
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
        /*
         * método store retorna o nome da imagem
         * método espera, como parâmetro, o nome da pasta de destino, e o disco
         * no caso abaixo, vai ser saldo em storage/app/public/imagens/2XYz2opbjSt27PVge416HVKbyVcunKq4Q7nl5vRB.png
         */
        $image_urn = $createMarcaRequest->file('imagem')->store('imagens', 'public');

        $data = [
            'nome' => $createMarcaRequest->nome,
            'imagem' => $image_urn
        ];

        $marca = $this->marca->create($data);

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
        $marca = $this->marca->with('modelos')->find($id);

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
        // se na request houver uma nova imagem, deleta a antiga
        if($updateMarcaRequest->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }

        $data = [
            'nome' => $updateMarcaRequest->nome,
            'imagem' => $updateMarcaRequest->file('imagem')->store('imagens', 'public')
        ];

        $marca->update($data);
        // TODO: Fix this update
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

        Storage::disk('public')->delete($marca->imagem);
        $marca->delete();

        return response()->json(['msg' => 'Marca removida com sucesso'], 200);
    }
}
