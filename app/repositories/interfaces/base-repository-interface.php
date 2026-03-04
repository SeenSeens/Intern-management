<?php
namespace InternManagement\App\Repositories\Interfaces;
if ( ! defined( 'ABSPATH' ) ) exit;
interface BaseRepositoryInterface {
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function offset_paginate(int $page = 1 , int $perPage = 10, array $filters = [], string $orderBy = 'created_at', string $direction = 'DESC');
    public function cursor_paginate(?int $cursor = null, int $limit = 10, array $filters = [], string $cursorColumn = 'id');
    public function stats(string $statusColumn = 'status');
}
