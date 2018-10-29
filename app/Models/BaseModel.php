<?php

namespace App\Models;

use Debugbar;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;

class BaseModel extends Model
{
    protected $filterable;
    protected $filterRelationName;
    protected $filterRelationModel;

    protected $perPage = 50;
    protected $orderBy = [
        'field' => 'created_at',
        'type' => 'desc',
    ];
    private $filterParams = [];
    private $filterRelations = [];

    // mutator

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setFilterOrder($field, $type)
    {
        $this->orderBy = [
            'field' => $field,
            'type' => $type,
        ];
    }

    public function setFilterPerPage(int $perPage)
    {
        $this->perPage = $perPage;
    }

    public function setFilterRelations(array $relations)
    {
        $this->filterRelations = $relations;
    }

    public function setFilterField(string $field, $type, $request)
    {
        if (!in_array($field, $this->filterable)) {
            throw new Exception('Field "' . $field . '" not exist', 404);
        }

        $this->filterParams[] = [
            'type' => $type,
            'field' => $field,
            'request' => $request,
        ];
    }

    public function setFilterRelation($model, $name)
    {
        $this->filterRelationName = $name;
        $this->filterRelationModel = $model;
    }

    /**
     * @param mixed
     * @return BaseModel
     * @throws Exception
     */
    private function makeQuery()
    {

        $q = $this->orderBy($this->orderBy['field'], $this->orderBy['type']);


        if (isset($this->filterRelations)) {
            foreach ($this->filterRelations as $relation) {
                if (!method_exists($this, $relation['relation'])) {
                    throw new Exception('Relations not exist');
                }

//                $field = $relation['field'];
//                $type = $relation['type'];
//                $search = $relation['search'];
//                $q->whereHas($relation['relation'], function ($query) use ($field, $type, $search) {
//                    switch ($type) {
//                        case 'equal':
//                            $query->where($field, $search);
//                            break;
//
//                        case 'between':
//                            $query->whereBetween($field, [$search[0], $search[1]]);
//                            break;
//
//                        case 'like':
//                            $query->where($field, 'like', "%$search%");
//                            break;
//
//                        case 'more':
//                            $query->where($field, '>', "%$search%");
//                            break;
//
//                        case 'less':
//                            $query->where($field, '<', "%$search%");
//                            break;
//                    }
//
//                });
            }

//            $q->with($this->filterRelations);
//            $q = $this->makeFilterRelation($q, 'roles', 29);
//            foreach ($this->filterRelations as $relation) {
////                dd($relation['relation']);
//                if ($this->filterRelationModel == $relation) {
//                    $q->whereHas($relation, function ($query) {
//                        $query->where('name', $this->filterRelationName);
//                    });
//                }
//            }
        }

        if (isset($this->filterParams)) {
            foreach ($this->filterParams as $param) {
                switch ($param['type']) {
                    case 'like':
                        $q->where($param['field'], 'like', "%" . $param['request'] . "%");
                        break;

                    case 'equal':
                        $q->where($param['field'], '=', $param['request']);
                        break;

                    case 'more':
                        $q->where($param['field'], '>', $param['request']);
                        break;

                    case 'less':
                        $q->where($param['field'], '<', $param['request']);
                        break;

                    case 'range':
                        $q->whereBetween($param['field'], [$param['request'][0], $param['request'][1]]);
                        break;
                }
            }
        }

        return $q->paginate($this->perPage);
    }


    /**
     * @param mixed
     * @return BaseModel
     * @throws Exception
     */
    public function getFilterResult()
    {
        $result = $this->makeQuery();
        return $result;
    }


//    public function makeFilterRelation (Builder $query, $model, $id)
//    {
//        foreach ($this->filterRelations as $relation) {
//            if ($model == $relation){
//                return $query->whereHas($relation, function ($q) use ($id) {
//                    $q->where('id', $id);
//                });
//            }
//        }
//    }
}