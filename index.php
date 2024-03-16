<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project index.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

require_once "private/helpers/init.php";

use Teacher\Examples\DTOs\ExampleDTO;
use Teacher\Examples\Enumerations\DaysOfWeekEnum;

echo "REQUEST URI: " . $_SERVER["REQUEST_URI"] . "<br/><br/>";
echo "DEFINED PATH CONSTANTS:<br/>";
echo PRJ_ROOT_DIR . "<br/>";
echo PRJ_PRIVATE_DIR . "<br/>";
echo PRJ_SRC_DIR . "<br/>";
echo PRJ_FRAGMENTS_DIR . "<br/>";
echo PRJ_PUBLIC_DIR . "<br/>";
echo PRJ_CSS_DIR . "<br/>";
echo PRJ_IMAGES_DIR . "<br/>";
echo PRJ_JS_DIR . "<br/>";
echo PRJ_PAGES_DIRE . "<br/>";
echo WEB_ROOT_DIR . "<br/>";
echo WEB_CSS_DIR . "<br/>";
echo WEB_IMAGES_DIR . "<br/>";
echo WEB_JS_DIR . "<br/>";
echo WEB_PAGES_DIR . "<br/>";

echo "<br/><br/>";

$dto_object = new ExampleDTO(5,
                             DaysOfWeekEnum::FRIDAY,
                             "a description",
                             new DateTime(),
                             new DateTime(),
                             new DateTime());

$serialized_obj = serialize($dto_object);

echo $serialized_obj . "<br/>";

$rebuilt_object = unserialize($serialized_obj);

debug($rebuilt_object);

echo "<br/><br/>";

$json_string = json_encode($dto_object, JSON_PRETTY_PRINT);
echo "<pre>" . $json_string . "</pre>";


echo "<br/><br/>";
$parsed_json = json_decode($json_string, true);

debug($parsed_json);