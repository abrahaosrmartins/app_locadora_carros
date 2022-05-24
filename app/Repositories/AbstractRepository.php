<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * @var Model $model
     */
    protected $model;

    /**
     * Class constructor
     *
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * Select related model attributes
     *
     * @param $atributos
     * @return void
     */
    public function selectAtributosRegistrosRelacionados($atributos) {
        $this->model = $this->model->with($atributos);
        //a query está sendo montada
    }

    /**
     * Query filter
     *
     * @param $filtros
     * @return void
     */
    public function filtro($filtros) {
        $filtros = explode(';', $filtros);
        
        foreach($filtros as $key => $condicao) {

            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
            //a query está sendo montada
        }
    }

    /**
     * Select main model attributes
     *
     * @param $atributos
     * @return void
     */
    public function selectAtributos($atributos) {
        $this->model = $this->model->selectRaw($atributos);
    }

    /**
     * Get query result
     *
     * @return mixed
     */
    public function getResultado() {
        return $this->model->get();
    }

    /**
     * Get query result
     *
     * @return mixed
     */
    public function getResultadoPaginado($numeroRegistrosPorPagina) {
        return $this->model->paginate($numeroRegistrosPorPagina);
    }
}
