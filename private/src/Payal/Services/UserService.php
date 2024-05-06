<?php
declare(strict_types=1);

namespace Payal\Services;

use Exception;
use Payal\DAOs\UserDAO;
use Payal\DTOs\UserDTO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 *
 */
class UserService {
    private UserDAO $dao;
    
    public function __construct() {
        $this->dao = new UserDAO();
    }
    
    
    /**
     * @return array
     * @throws RuntimeException
     */
    public function getAllUsers() : array {
        try {
            return $this->dao->getAll();
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get all users.", 0, $exp);
        }
    }
    
    /**
     * @param int $id
     * @return UserDTO|null
     * @throws RuntimeException
     */
    public function getUserById(int $id) : ?UserDTO {
        try {
            return $this->dao->getById($id);
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to get user with ID $id.", 0, $exp);
        }
    }
    
    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @return UserDTO
     * @throws RuntimeException
     */
    public function createUser(string $username, string $password, string $email) : UserDTO {
        try {
            $user = UserDTO::fromValues($username, $password, $email);
            return $this->dao->insert($user);
        } catch (Exception $exp) {
            throw new RuntimeException("Failed to create new user.", 0, $exp);
        }
    }
    
    /**
     * @param int    $id
     * @param string $username
     * @param string $password
     * @param string $email
     * @return UserDTO
     * @throws RuntimeException
     */
    public function updateUser(int $id, string $username, string $password, string $email) : UserDTO {
        
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $user = $this->dao->getById($id);
            if ($user === null) {
                throw new RuntimeException("User with ID $id not found.");
            }
            
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            
            $updated_user = $this->dao->update($user);
            $connection->commit();
            
            return $updated_user;
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to update user with ID $id.", 0, $exp);
        }
    }
    
    /**
     * @param int $id
     * @return void
     * @throws RuntimeException
     */
    public function deleteUserById(int $id) : void {
        
        $connection = DBConnectionService::getConnection();
        
        try {
            $connection->beginTransaction();
            
            $user = $this->dao->getById($id);
            if ($user === null) {
                throw new RuntimeException("User with ID $id not found.");
            }
            
            $this->dao->delete($user);
            $connection->commit();
        } catch (Exception $exp) {
            $connection->rollBack();
            throw new RuntimeException("Failed to delete user with ID $id.", 0, $exp);
        }
    }
    
}