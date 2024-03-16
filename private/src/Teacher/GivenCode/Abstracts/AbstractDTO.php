<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project AbstractDTO.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Abstracts;


/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
abstract class AbstractDTO implements IDTO {
    use DTOTrait;
    
    /**
     * Constructor
     *
     * @param int $id
     */
    public function __construct(int $id) {
        $this->id = $id;
    }
    
    /**
     * @inheritDoc
     */
    public function getPrimaryKeyValue() : int {
        return $this->id;
    }
    
    /**
     * @inheritDoc
     */
    public function getPrimaryKeyColumnName() : string {
        return self::$primaryKeyColumnName;
    }
    
    /**
     * @inheritDoc
     */
    abstract public function getDatabaseTableName() : string;
    
}