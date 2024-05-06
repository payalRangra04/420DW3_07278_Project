<?php
declare(strict_types=1);

namespace Payal\DAOs;

use Exception;
use Payal\DTOs\UserDTO;
use PDO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 *
 */
class UserDAO {
    /**
     * Retrieves all users from the database.
     *
     * @throws RuntimeException
     * @throws Exception
     */
    public function getAll() : array {
        $query = "SELECT * FROM " . UserDTO::TABLE_NAME . " ;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->execute();
        $result_set = $statement->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        
        foreach ($result_set as $result) {
            $users[] = UserDTO::fromDbArray($result);
        }
        return $users;
    }
    
    
    /**
     * @param int $id
     * Retrieves a user by their ID.
     * @return UserDTO|null
     * @throws RuntimeException
     * @throws Exception
     */
    public function getById(int $id) : ?UserDTO {
        $query = "SELECT * FROM " . UserDTO::TABLE_NAME . " WHERE userId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $user_array = $statement->fetch(PDO::FETCH_ASSOC);
        return $user_array ? UserDTO::fromDbArray($user_array) : null;
    }
    
    
    /**
     * @param UserDTO $user
     * @return UserDTO
     * @throws RuntimeException
     * Inserts a new user into the database.
     */
    public function insert(UserDTO $user) : UserDTO {
        $query = "INSERT INTO " . UserDTO::TABLE_NAME .
            " (username, password, email) VALUES (:username, :password, :email);";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(":password", $user->getPassword(), PDO::PARAM_STR); // consider hashing this value
        $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $statement->execute();
        $new_id = (int) $connection->lastInsertId();
        return $this->getById($new_id);
    }
    
    
    /**
     * @param UserDTO $user
     * @return UserDTO
     * @throws RuntimeException
     * Updates an existing user in the database.
     */
    public function update(UserDTO $user) : UserDTO {
        $query = "UPDATE " . UserDTO::TABLE_NAME .
            " SET username = :username, password = :password, email = :email WHERE id = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
        $statement->bindValue(":email", $user->getEmail());
        $statement->bindValue(":id", $user->getUserId(), PDO::PARAM_INT);
        $statement->execute();
        return $this->getById($user->getUserId());
    }
    
    
    /**
     * @param UserDTO $id
     * @return void
     * @throws RuntimeException
     */
    public function delete(UserDTO $id) : void {
        $query = "DELETE FROM " . UserDTO::TABLE_NAME . " WHERE userId = :id;";
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare($query);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}