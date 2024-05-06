<?php
declare(strict_types=1);

namespace Payal\Services;

use Exception;
use Payal\DAOs\PermissionDAO;
use Payal\DTOs\PermissionDTO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 *
 */
class PermissionService {
    private PermissionDAO $dao;
    
    public function __construct() {
        $this->dao = new PermissionDAO();
    }
    
    /**
     * Get all permissions from the database.
     *
     * @return PermissionDTO[]
     * @throws RuntimeException If there is a database access issue.
     */
    public function getAllPermissions(): array {
        try {
            return $this->dao->getAll();
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get all permissions.", 0, $exp);
        }
    }
    
    
    /**
     * Get a single permission by its ID.
     *
     * @param int $id The ID of the permission.
     * @return PermissionDTO|null
     * @throws RuntimeException If there is a database access issue.
     */
    public function getPermissionById(int $id) : ?PermissionDTO {
        try {
            return $this->dao->getById($id);
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get permission with ID $id.", 0, $exp);
        }
    }
    
    
    /**
     * Creates a new permission in the database.
     *
     * @param string $permissionKey
     * @param string $permissionName
     * @param string $description The description of the permission.
     * @return PermissionDTO The newly created permission DTO.
     * @throws RuntimeException If there is a database access issue.
     */
    public function createPermission(string $permissionKey, string $permissionName, string $description) : PermissionDTO {
        try {
            $permission = PermissionDTO::fromValues($permissionKey, $permissionName, $description);
            return $this->dao->insert($permission);
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to create new permission.", 0, $exp);
        }
    }
    
    
    /**
     * Updates an existing permission in the database.
     *
     * @param int    $id          The ID of the permission to update.
     * @param string $permissionKey
     * @param string $permissionName
     * @param string $description New description of the permission.
     * @return PermissionDTO The updated permission DTO.
     * @throws RuntimeException If there is a database access issue.
     */
    public function updatePermission(int $id, string $permissionKey, string $permissionName, string $description) : PermissionDTO {
        
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $permission = $this->dao->getById($id);
            if ($permission === null) {
                throw new RuntimeException("Permission with ID $id not found.");
            }
            
            $permission->setPermissionKey($permissionKey);
            $permission->setPermissionName($permissionName);
            $permission->setPermissionDescription($description);
            
            $updated_permission = $this->dao->update($permission);
            $connection->commit();
            
            return $updated_permission;
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to update permission with ID $id.", 0, $exp);
        }
    }
    
    
    /**
     * Deletes a permission from the database by its ID.
     *
     * @param int $id The ID of the permission to delete.
     * @throws RuntimeException If there is a database access issue.
     */
    public function deletePermissionById(int $id) : void {
        
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $permission = $this->dao->getById($id);
            if ($permission === null) {
                throw new RuntimeException("Permission with ID $id not found.");
            }
            
            $this->dao->delete($permission);
            $connection->commit();
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to delete permission with ID $id.", 0, $exp);
        }
    }
}