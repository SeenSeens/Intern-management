<?php
namespace InternManagement\App\Controllers\Api;

use InternManagement\App\Services\ProjectService;
use InternManagement\Core\ApiController;
use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) exit;

class ProjectController extends ApiController{

    private ProjectService $projectService;

    public function __construct(){
        parent::__construct();
        $this->projectService = new ProjectService();

    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/projects', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                //'permission_callback' => [$this, 'permission']
                'permission_callback' => '__return_true'
            ]
        ]);

        register_rest_route($this->namespace, '/project/', [
            [
                'methods'  => 'POST',
                'callback' => [$this, 'store'],
                'permission_callback' => '__return_true',
            ]
        ]);

        register_rest_route($this->namespace, '/project/(?P<id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'show'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'destroy'],
                'permission_callback' => '__return_true',
            ]
        ]);

        register_rest_route($this->namespace, '/projects/stats', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'stats'],
                'permission_callback' => '__return_true',
            ]
        ]);
    }

    // LIST (OFFSET OR CURSOR)
    public function index(WP_REST_Request $request){
        $mode = $request->get_param('mode') ?? 'offset';

        if ($mode === 'cursor') {

            $cursor = $request->get_param('cursor');
            $limit  = $request->get_param('limit') ?? 10;

            $result = $this->projectService->cursor_paginate(
                $cursor ? (int)$cursor : null,
                (int)$limit,
                $this->filters($request)
            );

        } else {

            $page    = $request->get_param('page') ?? 1;
            $perPage = $request->get_param('per_page') ?? 10;

            $result = $this->projectService->offset_paginate(
                (int)$page,
                (int)$perPage,
                $this->filters($request)
            );
        }

        return $this->success($result);
    }

    // Show
    public function show(WP_REST_Request $request) {
        $id = (int) $request['id'];

        $project = $this->projectService->find($id);

        if (!$project) {
            return $this->error('Project not found', 404);
        }

        return $this->success($project);
    }

    // Store
    public function store(WP_REST_Request $request){
        try {

            $id = $this->projectService->create($request->get_json_params());

            return $this->success([
                'id' => $id
            ], 201);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 422);
        }
    }

    // Update
    public function update(WP_REST_Request $request){
        try {

            $id = (int) $request['id'];

            $updated = $this->projectService->update(
                $id,
                $request->get_json_params()
            );

            return $this->success([
                'updated' => $updated
            ]);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 422);
        }
    }

    //delete
    public function destroy(WP_REST_Request $request){
        $id = (int) $request['id'];

        $deleted = $this->projectService->delete($id);

        return $this->success([
            'deleted' => $deleted
        ]);
    }

    //stats
    public function stats(){
        return $this->success(
            $this->projectService->stats()
        );
    }
    protected function filters(WP_REST_Request $request): array{
        return [
            'status'     => $request->get_param('status'),
            'manager_id' => $request->get_param('manager_id'),
        ];
    }
    private function permission(): bool{
        return $this->require_login();
    }
}

