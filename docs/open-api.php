<?php

/**
 * @OA\Info(
 *     title="Intern Management API",
 *     version="1.0.0",
 *     description="API quản lý thực tập sinh"
 * )
 */

/**
 * @OA\Server(
 *     url="/wp-json/intern",
 *     description="WordPress REST API"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */