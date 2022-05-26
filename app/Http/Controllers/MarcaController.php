<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json($marcaRepository->getResultadoPaginado(3), 200);
        // all() -> cria um objeto de consulta e depois faz um get() retornando uma collection
        // get() -> possibilita modificar a consulta antes de retornar a collection
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
        $image_urn = $createMarcaRequest->file('imagem')->store('imagens/marcas', 'public');

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

        $marca->fill($updateMarcaRequest->all());

        // se na request houver uma nova imagem, deleta a antiga
        if($updateMarcaRequest->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
            $imagem = $updateMarcaRequest->file('imagem');
            $imagem_urn = $imagem->store('imagens/marcas', 'public');
            $marca->imagem = $imagem_urn;
        }
        $marca->save();

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
