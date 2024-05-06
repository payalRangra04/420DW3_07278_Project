<?php
declare(strict_types=1);

namespace Payal\Services;

use Exception;
use Payal\DAOs\GroupDAO;
use Payal\DTOs\GroupDTO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 *
 */
class GroupService {
    
    private GroupDAO $dao;
    
    /**
     *
     */
    public function __construct() {
        $this->dao = new GroupDAO();
    }
    
    /**
     * Get all groups from the database.
     *
     * @return GroupDTO[]
     * @throws RuntimeException If there is a database access issue.
     */
    public function getAllGroups() : array {
        try {
            return $this->dao->getAll();
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get all groups.", 0, $exp);
        }
    }
    
    /**
     * Get a single group by its ID.
     *
     * @param int $id The ID of the group.
     * @return GroupDTO|null
     * @throws RuntimeException If there is a database access issue or the group is not found.
     */
    public function getGroupById(int $id) : ?GroupDTO {
        try {
            $group = $this->dao->getById($id);
            if (!$group) {
                throw new RuntimeException("Group with ID $id not found.");
            }
            return $group;
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get group with ID $id.", 0, $exp);
        }
    }
    
    
    /**
     * Creates a new group in the database.
     *
     * @param string $name        The name of the group.
     * @param string $description The description of the group.
     * @return GroupDTO The newly created group DTO.
     * @throws RuntimeException If there is a database access issue.
     */
    public function createGroup(string $name, string $description) : GroupDTO {
        try {
            $group = GroupDTO::fromValues($name, $description);
            return $this->dao->insert($group);
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to create new group.", 0, $exp);
        }
    }
    
    /**
     * Updates an existing group in the database.
     *
     * @param int    $id          The ID of the group to update.
     * @param string $name        New name of the group.
     * @param string $description New description of the group.
     * @return GroupDTO The updated group DTO.
     * @throws RuntimeException If there is a database access issue.
     */
    public function updateGroup(int $id, string $name, string $description) : GroupDTO {
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $group = $this->dao->getById($id);
            if ($group === null) {
                throw new RuntimeException("Group with ID $id not found.");
            }
            
            $group->setGroupName($name);
            $group->setGroupDescription($description);
            
            $updated_group = $this->dao->update($group);
            $connection->commit();
            
            return $updated_group;
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to update group with ID $id.", 0, $exp);
        }
    }
    
    /**
     * Deletes a group from the database by its ID.
     *
     * @param int $id The ID of the group to delete.
     * @throws RuntimeException If there is a database access issue.
     */
    public function deleteGroupById(int $id) : void {
        
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $group = $this->dao->getById($id);
            if ($group === null) {
                throw new RuntimeException("Group with ID $id not found.");
            }
            
            $this->dao->delete($group);
            $connection->commit();
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to delete group with ID $id.", 0, $exp);
        }
    }
}