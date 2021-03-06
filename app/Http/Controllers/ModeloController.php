<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use App\Models\Marca;
use App\Models\Modelo;
use App\Repositories\ModeloRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    /**
     * @var Marca $marca
     */
    protected $marca;

    /**
     * @var Modelo $modelo
     */
    protected $modelo;

    /**
     * Class constructor
     */
    public function __construct(Marca $marca, Modelo $modelo)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,'.$request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $modeloRepository->selectAtributos($request->atributos);
        }

        return response()->json($modeloRepository->getResultado(), 200);
        // all() -> cria um objeto de consulta e depois faz um get() retornando uma collection
        // get() -> possibilita modificar a consulta antes de retornar a collection
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateModeloRequest $createModeloRequest
     * @return JsonResponse
     */
    public function store(CreateModeloRequest $createModeloRequest): JsonResponse
    {
        $data = [
            'marca_id' => $createModeloRequest->marca_id,
            'nome' => $createModeloRequest->nome,
            'imagem' => $createModeloRequest->file('imagem')->store('imagens/modelos', 'public'),
            'numero_portas' => $createModeloRequest->numero_portas,
            'lugares' => $createModeloRequest->lugares,
            'air_bag' => $createModeloRequest->air_bag,
            'abs' => $createModeloRequest->abs
        ];

        $modelo = $this->modelo->create($data);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Modelo $modelo
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->modelo->with('marca')->find($id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateModeloRequest $updateModeloRequest
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateModeloRequest $updateModeloRequest, int $id): JsonResponse
    {
        $modelo = $this->modelo->find($id);
        if ($modelo === null) {
            return response()->json(['erro' => 'O registro n??o existe no banco de dados'], 404);
        }

        if ($updateModeloRequest->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
            $imagem = $updateModeloRequest->file('imagem');
            $imagem_urn = $imagem->store('imagens/modelos', 'public');
        }

        $modelo->fill($updateModeloRequest->all());
        $updateModeloRequest->file('imagem') ? $modelo->imagem = $imagem_urn : '';
        $modelo->save();

        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $modelo = $this->modelo->find($id);
        if ($modelo === null) {
            return response()->json(['erro' => 'O modelo especificado n??o existe no banco de dados'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);
        $modelo->delete();

        return response()->json(['msg' => 'Registro deletado com sucesso'], 200);
    }
}
