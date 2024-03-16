<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project DTOTrait.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Abstracts;

/**
 * TODO: Trait documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
trait DTOTrait {
    protected static string $primaryKeyColumnName = "id";
    public int $id;
    
}