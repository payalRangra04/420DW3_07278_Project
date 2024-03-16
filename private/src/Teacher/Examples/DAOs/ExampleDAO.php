<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project ExampleDAO.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-16
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\Examples\DAOs;

use PDO;
use Teacher\Examples\DTOs\ExampleDTO;
use Teacher\GivenCode\Abstracts\IDAO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
class ExampleDAO implements IDAO {
    private const GET_QUERY = "SELECT * FROM `" . ExampleDTO::TABLE_NAME . "` WHERE `id` = :id AND `deleted_at` IS NULL ;";
    private const GET_QUERY_WITH_DELETED = "SELECT * FROM `" . ExampleDTO::TABLE_NAME . "` WHERE `id` = :id ;";
    private const CREATE_QUERY = "INSERT INTO `" . ExampleDTO::TABLE_NAME .
    "` (`dayOfTheWeek`, `description`) VALUES (:dayOfWeek, :desc) ;";
    private const UPDATE_QUERY = "UPDATE `" . ExampleDTO::TABLE_NAME .
    "` SET `dayOfTheWeek` = :dayOfWeek, `description` = :desc WHERE `id` = :id ;";
    private const PSEUDO_DELETE_QUERY = "UPDATE `" . ExampleDTO::TABLE_NAME . "` SET `deleted_at` = :dateDeleted WHERE `id` = :id ;";
    private const REAL_DELETE_QUERY = "DELETE FROM `" . ExampleDTO::TABLE_NAME . "` WHERE `id` = :id ;";
    
    
    public function getById(int $id, bool $includeDeleted = false) : ?ExampleDTO {
        $connection = DBConnectionService::getConnection();
        if ($includeDeleted) {
            $statement = $connection->prepare(self::GET_QUERY_WITH_DELETED);
        } else {
            $statement = $connection->prepare(self::GET_QUERY);
        }
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        $array = $statement->fetch(PDO::FETCH_ASSOC) || throw new RuntimeException("No record found for id# [$id].");
        return ExampleDTO::fromDbArray($array);
    }
    
    public function create(object $dto) : ExampleDTO {
        if (!($dto instanceof ExampleDTO)) {
            throw new RuntimeException("Passed dto object is not an instance of [" . ExampleDTO::class . "].");
        }
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::CREATE_QUERY);
        $statement->bindValue(":dayOfWeek", $dto->getDayOfTheWeek()->value, PDO::PARAM_STR);
        $statement->bindValue(":desc", $dto->getDescription(), PDO::PARAM_STR);
        $statement->execute();
        $new_id = (int) $connection->lastInsertId();
        
        return $this->getById($new_id);
    }
    
    public function update(object $dto) : ExampleDTO {
        if (!($dto instanceof ExampleDTO)) {
            throw new RuntimeException("Passed dto object is not an instance of [" . ExampleDTO::class . "].");
        }
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::CREATE_QUERY);
        $statement->bindValue(":dayOfWeek", $dto->getDayOfTheWeek()->value, PDO::PARAM_STR);
        $statement->bindValue(":desc", $dto->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(":id", $dto->getPrimaryKeyValue(), PDO::PARAM_INT);
        $statement->execute();
        return $this->getById($dto->getPrimaryKeyValue());
    }
    
    public function delete(object $dto, bool $realDeletes = false) : void {
        if (!($dto instanceof ExampleDTO)) {
            throw new RuntimeException("Passed dto object is not an instance of [" . ExampleDTO::class . "].");
        }
        $this->deleteById($dto->getPrimaryKeyValue());
    }
    
    public function deleteById(int $id, bool $realDeletes = false) : void {
        $connection = DBConnectionService::getConnection();
        if ($realDeletes) {
            $statement = $connection->prepare(self::REAL_DELETE_QUERY);
        } else {
            $statement = $connection->prepare(self::PSEUDO_DELETE_QUERY);
            $statement->bindValue(":dateDeleted", (new \DateTime())->format(DB_DATETIME_FORMAT), PDO::PARAM_STR);
        }
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}