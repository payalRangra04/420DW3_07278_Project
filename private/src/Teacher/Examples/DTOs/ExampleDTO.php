<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project ExampleDTO.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\Examples\DTOs;

use DateTime;
use JetBrains\PhpStorm\Pure;
use Teacher\Examples\Enumerations\DaysOfWeekEnum;
use Teacher\GivenCode\Abstracts\AbstractDTO;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
class ExampleDTO extends AbstractDTO {
    
    /**
     * Database table name for this DTO.
     * @const
     */
    public const TABLE_NAME = "ExampleEntity";
    
    
    private DaysOfWeekEnum $dayOfTheWeek;
    private string $description;
    private ?DateTime $creationDate;
    private ?DateTime $lastModificationDate;
    private ?DateTime $deletionDate;
    // ...
    
    /**
     * Contructor
     *
     * @param int            $id
     * @param DaysOfWeekEnum $dayOfTheWeek
     * @param string         $description
     * @param DateTime|null  $creationDate
     * @param DateTime|null  $lastModificationDate
     * @param DateTime|null  $deletionDate
     */
    #[Pure] protected function __construct() {
        parent::__construct();
    }
    
    /**
     * TODO: Function documentation
     *
     * @static
     * @param DaysOfWeekEnum $dayOfTheWeek
     * @param string         $description
     * @return ExampleDTO
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    #[Pure] public static function fromValues(DaysOfWeekEnum $dayOfTheWeek, string $description) : ExampleDTO {
        $object = new ExampleDTO();
        $object->dayOfTheWeek = $dayOfTheWeek;
        $object->description = $description;
        return $object;
    }
    
    /**
     * TODO: Function documentation
     *
     * @static
     * @param array $dbAssocArray
     * @return ExampleDTO
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public static function fromDbArray(array $dbAssocArray) : ExampleDTO {
        $object = new ExampleDTO();
        $object->id = (int) $dbAssocArray["id"];
        $object->dayOfTheWeek = DaysOfWeekEnum::from($dbAssocArray["dayOfTheWeek"]);
        $object->description = $dbAssocArray["description"];
        $object->creationDate = DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["created_at"]);
        $object->lastModificationDate =
            DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["last_modified_at"]);
        $object->deletionDate = DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["deleted_at"]);
        return $object;
    }
    
    
    /**
     * @inheritDoc
     */
    public function getDatabaseTableName() : string {
        return self::TABLE_NAME;
    }
    
    /**
     * Getter for <code>DayOfTheWeek</code>
     *
     * @return DaysOfWeekEnum
     */
    public function getDayOfTheWeek() : DaysOfWeekEnum {
        return $this->dayOfTheWeek;
    }
    
    /**
     * Setter for <code>DayOfTheWeek</code>
     *
     * @param DaysOfWeekEnum $dayOfTheWeek
     */
    public function setDayOfTheWeek(DaysOfWeekEnum $dayOfTheWeek) : void {
        $this->dayOfTheWeek = $dayOfTheWeek;
    }
    
    /**
     * Getter for <code>Description</code>
     *
     * @return string
     */
    public function getDescription() : string {
        return $this->description;
    }
    
    /**
     * Setter for <code>Description</code>
     *
     * @param string $description
     */
    public function setDescription(string $description) : void {
        $this->description = $description;
    }
    
    /**
     * Getter for <code>CreationDate</code>
     *
     * @return DateTime|null
     */
    public function getCreationDate() : ?DateTime {
        return $this->creationDate;
    }
    
    /**
     * Setter for <code>CreationDate</code>
     *
     * @param DateTime|null $creationDate
     */
    public function setCreationDate(?DateTime $creationDate) : void {
        $this->creationDate = $creationDate;
    }
    
    /**
     * Getter for <code>LastModificationDate</code>
     *
     * @return DateTime|null
     */
    public function getLastModificationDate() : ?DateTime {
        return $this->lastModificationDate;
    }
    
    /**
     * Setter for <code>LastModificationDate</code>
     *
     * @param DateTime|null $lastModificationDate
     */
    public function setLastModificationDate(?DateTime $lastModificationDate) : void {
        $this->lastModificationDate = $lastModificationDate;
    }
    
    /**
     * Getter for <code>DeletionDate</code>
     *
     * @return DateTime|null
     */
    public function getDeletionDate() : ?DateTime {
        return $this->deletionDate;
    }
    
    /**
     * Setter for <code>DeletionDate</code>
     *
     * @param DateTime|null $deletionDate
     */
    public function setDeletionDate(?DateTime $deletionDate) : void {
        $this->deletionDate = $deletionDate;
    }
    
}