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
    public const TABLE_NAME = "myDbTableName";
    
    
    public DaysOfWeekEnum $dayOfTheWeek;
    public string $description;
    public ?DateTime $creationDate;
    public ?DateTime $lastModificationDate;
    public ?DateTime $deletionDate;
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
    #[Pure] public function __construct(int            $id,
                                        DaysOfWeekEnum $dayOfTheWeek,
                                        string         $description,
                                        ?DateTime      $creationDate = null,
                                        ?DateTime      $lastModificationDate = null,
                                        ?DateTime      $deletionDate = null) {
        parent::__construct($id);
        $this->dayOfTheWeek = $dayOfTheWeek;
        $this->description = $description;
        $this->creationDate = $creationDate;
        $this->lastModificationDate = $lastModificationDate;
        $this->deletionDate = $deletionDate;
    }
    
    
    /**
     * @inheritDoc
     */
    public function getDatabaseTableName() : string {
        return self::TABLE_NAME;
    }
    
}