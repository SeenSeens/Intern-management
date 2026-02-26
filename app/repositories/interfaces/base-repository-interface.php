<?php
namespace InternManagement\App\Repositories\Interfaces;
if ( ! defined( 'ABSPATH' ) ) exit;
interface BaseRepositoryInterface {
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
