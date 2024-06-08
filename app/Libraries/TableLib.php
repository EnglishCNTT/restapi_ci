<?php

namespace App\Libraries;

use CodeIgniter\Model;

class TableLib
{

    private $model;
    private $group;
    private $columns;
    public function __construct(Model $model, string $group, array $columns)
    {
        $this->model = $model;
        $this->group = $group;
        $this->columns = $columns;
    }

    public function getResponse(array $filers)
    {
        [
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'order' => $order,
            'direction' => $direction,
            'search' => $search
        ] = $filers;

        $page = ceil(($start - 1) / $length + 1);

        if (!empty($search)) {
            $this->applyFilters($search);
        }
        $data = $this->model->orderBy($this->getColumn($order), $direction)->paginate($length, $this->group, $page);
        return [
            'draw' => $draw,
            'recordsTotal' => $this->model->countAll(),
            'recordsFiltered' => $this->model->pager->getTotal($this->group),
            'data' => $data
        ];
    }

    private function getColumn($index)
    {
        return $this->columns[$index];
    }

    private function applyFilters(string $match)
    {
        foreach ($this->columns as $column) {
            $this->model->orLike($column, $match);
        }
    }
}
