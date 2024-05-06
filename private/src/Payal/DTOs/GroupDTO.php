<?php
declare(strict_types=1);

namespace Payal\DTOs;

use DateTime;
use Exception;

class GroupDTO {
    
    public const TABLE_NAME = "groups";
    
    private int $groupId;
    private string $groupName;
    private ?string $groupDescription;
    private DateTime $creationDate;
    private ?DateTime $modificationDate;
    
    public function __construct() {}
    
    /**
     * Constructs a GroupDTO from individual fields
     *
     * @param string $groupName
     * @param string|null $groupDescription
     * @return self
     */
    public static function fromValues(string $groupName, ?string $groupDescription): self {
        $instance = new self();
        $instance->setGroupName($groupName);
        $instance->setGroupDescription($groupDescription);
        return $instance;
    }
    
    /**
     * Creates a GroupDTO from a database array
     *
     * @param array $dbArray
     * @return self
     * @throws Exception
     */
    public static function fromDbArray(array $dbArray): self {
        self::validateDbArray($dbArray);
        $instance = new self();
        $instance->setGroupId((int) $dbArray['groupId']);
        $instance->setGroupName($dbArray['groupName']);
        $instance->setGroupDescription($dbArray['groupDescription'] ?? null);
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
        if (empty($dbArray['groupId']) || !is_numeric($dbArray['groupId'])) {
            throw new Exception("Record array [groupId] field is missing or non-numeric.");
        }
        if (empty($dbArray['groupName'])) {
            throw new Exception("Record array does not contain a [groupName] field.");
        }
        if (empty($dbArray['creationDate']) ||
            (DateTime::createFromFormat('Y-m-d H:i:s.u', $dbArray['creationDate']) === false)) {
            throw new Exception("Failed to parse [creationDate] field.");
        }
    }
    
    // Getters and setters
    public function getGroupId(): int {
        return $this->groupId;
    }
    
    public function setGroupId(int $groupId): void {
        $this->groupId = $groupId;
    }
    
    public function getGroupName(): string {
        return $this->groupName;
    }
    
    public function setGroupName(string $groupName): void {
        $this->groupName = $groupName;
    }
    
    public function getGroupDescription(): ?string {
        return $this->groupDescription;
    }
    
    public function setGroupDescription(?string $groupDescription): void {
        $this->groupDescription = $groupDescription;
    }
    
    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }
    
    public function setCreationDate(DateTime $creationDate): void {
        $this->creationDate = $creationDate;
    }
    
    public function getModificationDate(): ?DateTime {
        return $this->modificationDate;
    }
    
    public function setModificationDate(?DateTime $modificationDate): void {
        $this->modificationDate = $modificationDate;
    }
    
    /**
     * Converts DTO to array suitable for JSON serialization
     *
     * @return array
     */
    public function json() : array {
        return [
            'groupId' => $this->getGroupId(),
            'groupName' => $this->getGroupName(),
            'groupDescription' => $this->getGroupDescription(),
            'creationDate' => $this->getCreationDate(),
            'modificationDate' => $this->getModificationDate()
        ];
    }
}