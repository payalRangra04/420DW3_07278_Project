<?php
declare(strict_types=1);

namespace Payal\DTOs;

use DateTime;
use Exception;

/**
 *
 */
class PermissionDTO {
    
    /**
     *
     */
    public const TABLE_NAME = "permissions";
    
    private int $permissionId;
    private string $permissionKey;
    private string $permissionName;
    private ?string $permissionDescription;
    private DateTime $creationDate;
    private ?DateTime $modificationDate;
    
    public function __construct() {}
    
    /**
     * Constructs a PermissionDTO from individual fields
     *
     * @param string $permissionKey
     * @param string $permissionName
     * @param string|null $permissionDescription
     * @return self
     */
    public static function fromValues(string $permissionKey, string $permissionName, ?string $permissionDescription): self {
        $instance = new self();
        $instance->setPermissionKey($permissionKey);
        $instance->setPermissionName($permissionName);
        $instance->setPermissionDescription($permissionDescription);
        return $instance;
    }
    
    /**
     * Creates a PermissionDTO from a database array
     *
     * @param array $dbArray
     * @return self
     * @throws Exception
     */
    public static function fromDbArray(array $dbArray): self {
        self::validateDbArray($dbArray);
        $instance = new self();
        $instance->setPermissionId((int) $dbArray['permissionId']);
        $instance->setPermissionKey($dbArray['permissionKey']);
        $instance->setPermissionName($dbArray['permissionName']);
        $instance->setPermissionDescription($dbArray['permissionDescription'] ?? null);
        $instance->setCreationDate(new DateTime($dbArray['creationDate']));
        
        if (!empty($dbArray['modificationDate'])) {
            $instance->setModificationDate(new DateTime($dbArray['modificationDate']));
        }
        return $instance;
    }
    
    /**
     * Validates the database array for required fields
     *
     * @param array $dbArray
     * @throws Exception
     */
    private static function validateDbArray(array $dbArray): void {
        if (empty($dbArray['permissionId']) || !is_numeric($dbArray['permissionId'])) {
            throw new Exception("Record array [permissionId] field is missing or non-numeric.");
        }
        if (empty($dbArray['permissionKey'])) {
            throw new Exception("Record array does not contain a [permissionKey] field.");
        }
        if (empty($dbArray['permissionName'])) {
            throw new Exception("Record array does not contain a [permissionName] field.");
        }
        if (empty($dbArray['creationDate']) ||
            (DateTime::createFromFormat('Y-m-d H:i:s.u', $dbArray['creationDate']) === false)) {
            throw new Exception("Failed to parse [creationDate] field.");
        }
    }
    
    // Getters and setters
    
    /**
     * @return int
     */
    public function getPermissionId(): int {
        return $this->permissionId;
    }
    
    /**
     * @param int $permissionId
     * @return void
     */
    public function setPermissionId(int $permissionId): void {
        $this->permissionId = $permissionId;
    }
    
    /**
     * @return string
     */
    public function getPermissionKey(): string {
        return $this->permissionKey;
    }
    
    /**
     * @param string $permissionKey
     * @return void
     */
    public function setPermissionKey(string $permissionKey): void {
        $this->permissionKey = $permissionKey;
    }
    
    /**
     * @return string
     */
    public function getPermissionName(): string {
        return $this->permissionName;
    }
    
    /**
     * @param string $permissionName
     * @return void
     */
    public function setPermissionName(string $permissionName): void {
        $this->permissionName = $permissionName;
    }
    
    /**
     * @return string|null
     */
    public function getPermissionDescription(): ?string {
        return $this->permissionDescription;
    }
    
    /**
     * @param string|null $permissionDescription
     * @return void
     */
    public function setPermissionDescription(?string $permissionDescription): void {
        $this->permissionDescription = $permissionDescription;
    }
    
    /**
     * @return DateTime
     */
    public function getCreationDate() : DateTime {
        return $this->creationDate;
    }
    
    /**
     * @param DateTime $creationDate
     * @return void
     */
    public function setCreationDate(DateTime $creationDate) : void {
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
    
    /**
     * Converts DTO to array suitable for JSON serialization
     *
     * @return array
     */
    public function json() : array {
        return [
            'permissionId' => $this->getPermissionId(),
            'permissionKey' => $this->getPermissionKey(),
            'permissionName' => $this->getPermissionName(),
            'permissionDescription' => $this->getPermissionDescription(),
            'creationDate' => $this->getCreationDate()->format('Y-m-d H:i:s.u'),
            'modificationDate' => $this->getModificationDate() ? $this->getModificationDate()->format('Y-m-d H:i:s.u') : null,
        ];
    }
}
