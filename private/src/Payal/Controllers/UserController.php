<?php
declare(strict_types=1);

namespace Payal\Controllers;

use Exception;
use HttpException;
use Payal\Services\UserService;

/**
 * Handles HTTP requests related to users.
 */
class UserController {
    private UserService $userService;
    
    public function __construct() {
        $this->userService = new UserService();
    }
    
    /**
     * Lists all users.
     * @throws HttpException
     */
    public function listUsers() : void {
        try {
            $users = $this->userService->getAllUsers();
            echo json_encode(['data' => $users]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch users: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Retrieves a single user by their ID.
     * @param int $userId
     * @throws HttpException
     */
    public function getUser(int $userId) : void {
        try {
            $user = $this->userService->getUserById($userId);
            if ($user === null) {
                throw new HttpException("User not found", 404);
            }
            echo json_encode($user->json());
        } catch (Exception $exp) {
            throw new HttpException("Failed to fetch user: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Creates a new user.
     * @throws HttpException
     */
    public function createUser() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $created_user =
                $this->userService->createUser($input_data['username'], $input_data['password'], $input_data['email']);
            echo json_encode(['success' => true, 'user' => $created_user->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to create user: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Updates an existing user.
     *
     * @throws HttpException
     */
    public function updateUser() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $updated_user = $this->userService->updateUser($input_data["id"], $input_data['username'], $input_data['password'], $input_data['email']);
            echo json_encode(['success' => true, 'user' => $updated_user->json()]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to update user: " . $exp->getMessage(), 500);
        }
    }
    
    /**
     * Deletes a user by ID.
     *
     * @throws HttpException
     */
    public function deleteUser() : void {
        $input_data = json_decode(file_get_contents('php://input'), true);
        try {
            $this->userService->deleteUserById($input_data["id"]);
            echo json_encode(['success' => true]);
        } catch (Exception $exp) {
            throw new HttpException("Failed to delete user: " . $exp->getMessage(), 500);
        }
    }
}
