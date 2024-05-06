<?php
declare(strict_types=1);

namespace Payal\DAOs;

use Exception;
use Payal\DTOs\GroupDTO;
use PDO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 * Handles database operations for Groups
 */
class GroupDAO {
    
    /**
     * @throws RuntimeException
     * @throws Exception
     * Retrieves all groups from the database
     */
    public function getAll() : array {
        $query = "SELECT * FROM " . GroupDTO::TABLE_NAME . ";";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        $result_set = $statement->fetchAll(PDO::FETCH_ASSOC);
        $groups = [];
        
        foreach ($result_set as $result) {
            $groups[] = GroupDTO::fromDbArray($result);
        }
        return $groups;
    }
    
    
    /**
     * @param int $id
     * @return GroupDTO|null
     * @throws RuntimeException
     * @throws Exception
     * Retrieves a group by its ID
     */
    public function getById(int $id) : ?GroupDTO {
        $query = "SELECT * FROM " . GroupDTO::TABLE_NAME . " WHERE groupId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $group_array = $statement->fetch(PDO::FETCH_ASSOC);
        return $group_array ? GroupDTO::fromDbArray($group_array) : null;
    }
    
    /**
     * @param GroupDTO $group
     * @return GroupDTO
     * @throws RuntimeException
     * Inserts a new group into the database
     */
    public function insert(GroupDTO $group) : GroupDTO {
        $query =
            "INSERT INTO " . GroupDTO::TABLE_NAME . " (groupName , groupDescription) VALUES (:name, :description);";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":name", $group->getGroupName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $group->getGroupDescription(), PDO::PARAM_STR);
        $statement->execute();
        $new_id = (int) $connection->lastInsertId();
        return $this->getById($new_id);
    }
    
    
    /**
     * @param GroupDTO $group
     * @return GroupDTO
     * @throws RuntimeException
     * Updates an existing group
     */
    public function update(GroupDTO $group) : GroupDTO {
        $query = "UPDATE " . GroupDTO::TABLE_NAME . " SET name = :name, description = :description WHERE id = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":name", $group->getGroupName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $group->getGroupDescription(), PDO::PARAM_STR);
        $statement->bindValue(":id", $group->getGroupId(), PDO::PARAM_INT);
        $statement->execute();
        return $this->getById($group->getGroupId());
    }
    
    /**
     * @param GroupDTO $id
     * @return void
     * @throws RuntimeException
     * Deletes a group from the database
     */
    public function delete(GroupDTO $id): void {
        $query = "DELETE FROM " . GroupDTO::TABLE_NAME . " WHERE groupId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}