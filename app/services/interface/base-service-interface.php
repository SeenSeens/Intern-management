<?php
namespace InternManagement\App\Services\Interfaces;
if ( ! defined( 'ABSPATH' ) ) exit;
interface BaseServiceInterface {
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function offset_paginate(int $page = 1 , int $perPage = 10, array $filters = []);
    public function cursor_paginate(?int $cursor = null, int $limit = 10, array $filters = []);
    public function stats();
}
