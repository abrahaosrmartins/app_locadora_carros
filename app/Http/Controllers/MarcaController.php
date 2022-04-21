<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @return JsonResponse
     */
    public function store(Request $request)
    public function index(): JsonResponse
    {
        //
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     *
     */
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
