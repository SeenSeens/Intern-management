<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\BaseRepository;
use InternManagement\App\Services\Interfaces\BaseServiceInterface;
if ( ! defined( 'ABSPATH' ) ) exit;
class BaseService implements BaseServiceInterface {

    protected BaseRepository $repository;

    public function __construct( BaseRepository $repository ) {
        $this->repository = $repository;
    }

    public function all() {
        return $this->repository->all();
    }

    public function find(int $id) {
        return $this->repository->find($id);
    }

    public function create(array $data) {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data) {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id) {
        return $this->repository->delete($id);
    }

    public function offset_paginate(int $page = 1 , int $perPage = 10, array $filters = []){
        return $this->repository->offset_paginate($page, $perPage, $filters);
    }

    public function cursor_paginate(?int $cursor = null, int $limit = 10, array $filters = []){
        return $this->repository->cursor_paginate($cursor, $limit, $filters);
    }

    public function stats(){
        return $this->repository->stats();
    }
}
