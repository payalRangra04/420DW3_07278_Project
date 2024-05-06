<?php
declare(strict_types=1);

namespace Payal\Controllers;

use Exception;
use HttpException;
use Payal\Services\GroupService;

/**
 *
 *
 */
class GroupController {
    private GroupService $groupService;
    
    public function __construct() {
        $this->groupService = new GroupService();
    }
    
    /**
     * @throws HttpException
     */
    public function listGroups() : void {
        try {
            $groups = $this->groupService->getAllGroups();
            echo json_encode(['data' => $groups]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch groups: " . $exp->getMessage(), 500);
        }
    }
    
    
    /**
     * @throws HttpException
     */
    public function getGroup(int $groupId) : void {
        try {
            $group = $this->groupService->getGroupById($groupId);
            if ($group === null) {
                throw new HttpException("Group not found", 404);
            }
            echo json_encode($group->json());
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch group: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * @throws HttpException
     */
    public function createGroup() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $created_group = $this->groupService->createGroup($input_data['name'], $input_data['description']);
            echo json_encode(['success' => true, 'group' => $created_group->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to create group: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * @return void
     * @throws HttpException
     */
    public function updateGroup() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $updated_group = $this->groupService->updateGroup((int) $input_data["id"], $input_data["name"], $input_data["description"]);
            echo json_encode(['success' => true, 'group' => $updated_group->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to update group: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * @return void
     * @throws HttpException
     */
    public function deleteGroup() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $this->groupService->deleteGroupById($input_data["id"]);
            echo json_encode(['success' => true]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to delete group: " . $exp->getMessage(), 500);
        }
    }
    
}