<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project IDAO.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-16
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Abstracts;

/**
 * TODO: Interface documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
interface IDAO {
    
    public function getById(int $id) : ?AbstractDTO;
    
    public function create(AbstractDTO $dto) : AbstractDTO;
    
    public function update(AbstractDTO $dto) : AbstractDTO;
    
    public function delete(AbstractDTO $dto) : void;
    
    public function deleteById(int $id) : void;
    
}