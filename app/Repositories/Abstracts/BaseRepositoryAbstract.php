<?php

namespace App\Repositories\Abstracts;

use App\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

/**
 * abstract class BaseRepositoryAbstract
 *
 * @package App\Repositories
 */
abstract class BaseRepositoryAbstract
{
    public $recordPerPage = 12;
    public $limit = 20;

    private $app;
    protected $model;
    protected $newModel;


    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    abstract public function filterData(array $filter, $query);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param        $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $entity = $this->find($id);
        $entity->fill($data);
        return $entity->save();
    }

    /**
     * @param array $data
     * @param        $id
     * @return mixed
     */
    public function updateOrCreate(array $column, array $data)
    {
        return $this->model->updateOrCreate($column, $data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    /**
     * Get paginated filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilterWithPaginatedData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query->paginate($this->recordPerPage, $columns);
    }

    /**
     * Get all filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilterWithAllData(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }
        if ($this->limit > 0){
            return $query->limit($this->limit)->get($columns);
        } else {
            return $query->get($columns);
        }
    }

    /**
     * Get query filtered data.
     *
     * @param array $filter
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFilterWithQuery(array $filter, array $columns = ['*'])
    {
        $query = $this->getQuery();

        if (!empty($filter)) {
            $this->filterData($filter, $query);
        }

        return $query;
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param $eloquentModel
     *
     * @return Model
     * @throws RepositoryException|\Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setModel($eloquentModel)
    {
        $this->newModel = $this->app->make($eloquentModel);

        if (!$this->newModel instanceof Model) {
            throw new RepositoryException("Class {$this->newModel} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $this->newModel;
    }

}
