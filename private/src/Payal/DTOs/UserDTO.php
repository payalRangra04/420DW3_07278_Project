<?php
declare(strict_types=1);

namespace Payal\DTOs;

use DateTime;
use Exception;

/**
 *
 */
class UserDTO {
    
    
    public const TABLE_NAME = "users";
    private int $userId;
    private string $userName;
    private string $password;
    private string $email;
    private ?DateTime $creationDate;
    private ?DateTime $modificationDate;
    
    public function __construct() {}
    
    /**
     * @param string $userName
     * @param string $password
     * @param string $email
     * @return self
     */
    public static function fromValues(string $userName, string $password, string $email) : self {
        $instance = new self();
        $instance->setUserName($userName);
        $instance->setPassword($password);
        $instance->setEmail($email);
        return $instance;
    }
    
    /**
     * @param array $dbArray
     * @return self
     * @throws Exception
     */
    public static function fromDbArray(array $dbArray) : self {
        self::validateDbArray($dbArray);
        $instance = new self();
        $instance->setUserId((int) $dbArray['id']);
        $instance->setUserName($dbArray['username']);
        $instance->setEmail($dbArray['email']);
        $instance->setCreationDate(DateTime::createFromFormat('Y-m-d H:i:s', $dbArray['date_created']));
        
        if (!empty($dbArray['date_last_modified'])) {
            $instance->setModificationDate(DateTime::createFromFormat('Y-m-d H:i:s', $dbArray['date_last_modified']));
        }
        return $instance;
    }
    
    /**
     * @throws Exception
     */
    private static function validateDbArray(array $dbArray) : void {
        if (empty($dbArray["id"]) || !is_numeric($dbArray["id"])) {
            throw new Exception("Record array [id] field is missing or non-numeric.");
        }
        if (empty($dbArray["username"])) {
            throw new Exception("Record array does not contain a [username] field.");
        }
        if (empty($dbArray["email"])) {
            throw new Exception("Record array does not contain an [email] field.");
        }
        if (empty($dbArray["date_created"]) ||
            (DateTime::createFromFormat('Y-m-d H:i:s', $dbArray["date_created"]) === false)
        ) {
            throw new Exception("Failed to parse [date_created] field.");
        }
        if (!empty($dbArray["date_last_modified"]) &&
            (DateTime::createFromFormat('Y-m-d H:i:s', $dbArray["date_last_modified"]) === false)
        ) {
            throw new Exception("Failed to parse [date_last_modified] field.");
        }
    }
    
    
    /**
     * @return int
     */
    public function getUserId() : int {
        return $this->userId;
    }
    
    /**
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId) : void {
        $this->userId = $userId;
    }
    
    /**
     * @return string
     */
    public function getUserName() : string {
        return $this->userName;
    }
    
    /**
     * @param string $userName
     * @return void
     */
    public function setUserName(string $userName) : void {
        $this->userName = $userName;
    }
    
    /**
     * @return string
     */
    public function getPassword() : string {
        return $this->password;
    }
    
    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password) : void {
        $this->password = $password;
    }
    
    /**
     * @return string
     */
    public function getEmail() : string {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email) : void {
        $this->email = $email;
    }
    
    /**
     * @return DateTime|null
     */
    public function getCreationDate() : ?DateTime {
        return $this->creationDate;
    }
    
    /**
     * @param DateTime|null $creationDate
     * @return void
     */
    public function setCreationDate(?DateTime $creationDate) : void {
        $this->creationDate = $creationDate;
    }
    
    /**
     * @return DateTime|null
     */
    public function getModificationDate() : ?DateTime {
        return $this->modificationDate;
    }
    
    /**
     * @param DateTime|null $modificationDate
     * @return void
     */
    public function setModificationDate(?DateTime $modificationDate) : void {
        $this->modificationDate = $modificationDate;
    }
    
    public function json() : array {
        
        return [
            "userId" => $this->getUserId(),
            "username" => $this->getUserName(),
            "password" => $this->getPassword(),
            "email" => $this->getEmail(),
            "createionDate" => $this->getCreationDate(),
            "modificationDate" => $this->getModificationDate()
        ];
        
    }
    
}


