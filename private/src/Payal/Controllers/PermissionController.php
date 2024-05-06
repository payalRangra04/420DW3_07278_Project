<?php
declare(strict_types=1);

namespace Payal\Controllers;

use Exception;
use HttpException;
use Payal\Services\PermissionService;

/**
 * Handles HTTP requests related to permissions.
 */
class PermissionController {
    private PermissionService $permissionService;
    
    public function __construct() {
        $this->permissionService = new PermissionService();
    }
    
    /**
     * Lists all permissions.
     * @throws HttpException
     */
    public function listPermissions() : void {
        try {
            $permissions = $this->permissionService->getAllPermissions();
            echo json_encode(['data' => $permissions]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch permissions: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Retrieves a single permission by its ID.
     * @param int $permissionId
     * @throws HttpException
     */
    public function getPermission(int $permissionId) : void {
        try {
            $permission = $this->permissionService->getPermissionById($permissionId);
            if ($permission === null) {
                throw new HttpException("Permission not found", 404);
            }
            echo json_encode($permission->json());
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch permission: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Creates a new permission.
     * @throws HttpException
     */
    public function createPermission() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $created_permission = $this->permissionService->createPermission($input_data['permissionKey'], $input_data['permissionName'], $input_data['description']);
            echo json_encode(['success' => true, 'permission' => $created_permission->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to create permission: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Updates an existing permission.
     *
     * @throws HttpException
     */
    public function updatePermission() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $updated_permission = $this->permissionService->updatePermission($input_data['id'], $input_data['permissionKey'], $input_data['permissionName'], $input_data['description']);
            echo json_encode(['success' => true, 'permission' => $updated_permission->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to update permission: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Deletes a permission by ID.
     *
     * @throws HttpException
     */
    public function deletePermission() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $this->permissionService->deletePermissionById($input_data["id"]);
            echo json_encode(['success' => true]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to delete permission: " . $exp->getMessage(), 500);
        }
    }
}
