<?php
declare(strict_types=1);

namespace Payal\DAOs;

use Exception;
use Payal\DTOs\PermissionDTO;
use PDO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 *Retrieves all permissions from the database.
 */
class PermissionDAO {
    
    /**
     * @return PermissionDTO[]
     * @throws RuntimeException
     * @throws Exception
     */
    public function getAll() : array {
        $query = "SELECT * FROM " . PermissionDTO::TABLE_NAME . ";";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        $result_set = $statement->fetchAll(PDO::FETCH_ASSOC);
        $permissions = [];
        
        foreach ($result_set as $result) {
            $permissions[] = PermissionDTO::fromDbArray($result);
        }
        return $permissions;
    }
    
    /**
     * Retrieves a permission by its ID.
     *
     * @param int $id
     * @return PermissionDTO|null
     * @throws RuntimeException
     * @throws Exception
     */
    public function getById(int $id) : ?PermissionDTO {
        $query = "SELECT * FROM " . PermissionDTO::TABLE_NAME . " WHERE permissionId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $permission_array = $statement->fetch(PDO::FETCH_ASSOC);
        return $permission_array ? PermissionDTO::fromDbArray($permission_array) : null;
    }
    
    /**
     * Inserts a new permission into the database.
     *
     * @param PermissionDTO $permission
     * @return PermissionDTO
     * @throws RuntimeException
     */
    public function insert(PermissionDTO $permission) : PermissionDTO {
        $query = "INSERT INTO " . PermissionDTO::TABLE_NAME .
            " (permissionKey, permissionName, permissionDescription) VALUES (:permissionKey, :name, :description);";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":permissionKey", $permission->getPermissionKey(), PDO::PARAM_STR);
        $statement->bindValue(":name", $permission->getPermissionName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $permission->getPermissionName(), PDO::PARAM_STR);
        $statement->execute();
        $new_id = (int) $connection->lastInsertId();
        return $this->getById($new_id);
    }
    
    /**
     * Updates an existing permission in the database.
     *
     * @param PermissionDTO $permission
     * @return PermissionDTO
     * @throws RuntimeException
     */
    public function update(PermissionDTO $permission) : PermissionDTO {
        $query =
            "UPDATE " . PermissionDTO::TABLE_NAME . " SET name = :name, description = :description WHERE id = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":name", $permission->getPermissionName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $permission->getPermissionDescription(), PDO::PARAM_STR);
        $statement->bindValue(":id", $permission->getPermissionId(), PDO::PARAM_INT);
        $statement->execute();
        return $this->getById($permission->getPermissionId());
    }
    
    /**
     * Deletes a permission from the database.
     *
     * @param PermissionDTO $id
     * @throws RuntimeException
     */
    public function delete(PermissionDTO $id) : void {
        $query = "DELETE FROM " . PermissionDTO::TABLE_NAME . " WHERE permissionId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
