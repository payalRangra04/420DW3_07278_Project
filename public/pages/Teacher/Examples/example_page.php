<?php
declare(strict_types=1);

include_once __DIR__ . "/../../../../private/helpers/init.php";

use Teacher\Examples\Enumerations\DaysOfWeekEnum;
use Teacher\Examples\Services\ExampleService;

/*
 * 420DW3_07278_Project example_page.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-16
 * (c) Copyright 2024 Marc-Eric Boury 
 */

$example_service = new ExampleService();
$all_example_instances = $example_service->getAllExamples();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Example Page</title>
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . "bootstrap.min.css" ?>">
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . "examples.css" ?>">
    <script type="text/javascript">
        
        const EXAMPLE_API_URL = "<?= WEB_ROOT_DIR . "api/ExampleDto" ?>";
    
    </script>
    <script type="text/javascript" src="<?= WEB_JS_DIR . "jquery-3.7.1.min.js" ?>" defer></script>
    <script type="text/javascript" src="<?= WEB_JS_DIR . "example_page.js" ?>" defer></script>
</head>
<body>
<h1 class="fullwidth text-center">Tests for ExampleDTOs</h1>
<div class="container">
    <div class="row justify-content-center">
        <label class="d-flex col-12 col-md-4 align-items-end align-items-md-center justify-content-md-end"
               for="example-selector">Select an example record:</label>
        <select id="example-selector" class="col-12 col-md-4">
            <option value="" selected disabled>Select one...</option>
            <option value='999999'>FAIL TEST (id# 999999)</option>
            <?php
            foreach ($all_example_instances as $instance) {
                echo "<option value='" . $instance->getId() . "'>" . $instance->getDayOfTheWeek()->value . "</option>";
            }
            ?>
        </select>
        <div class="col-12 col-md-4 row justify-content-center justify-content-md-start">
            <button id="view-instance-button" class="btn btn-primary col-8 col-sm-4 col-md-8 col-lg-6 text-uppercase"
                    type="button">Load example
            </button>
        </div>
    </div>
    <div class="row">
    
    </div>
    <div class="error-display hidden">
        <h1 id="error-class" class="col-12 error-text"></h1>
        <h3 id="error-message" class="col-12 error-text"></h3>
        <div id="error-previous" class="col-12"></div>
        <pre id="error-stacktrace" class="col-12"></pre>
    </div>
</div>
<br/>
<div class="container">
    <form id="example-form" class="row">
        <div class="col-12">
            <label class="form-label" for="example-id">Id: </label>
            <input class="form-control form-control-sm" id="example-id" type="number" name="id" readonly disabled>
        </div>
        <div class="col-12">
            <label class="form-label" for="example-day-of-week">Day of the week:</label>
            <select class="form-select form-select-sm" id="example-day-of-week" name="dayOfTheWeek" required>
                <option value="" selected disabled>Select one...</option>
                <?php
                foreach (DaysOfWeekEnum::cases() as $enum_case) {
                    echo "<option value='" . $enum_case->value . "'>" . $enum_case->name . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label" for="example-description">Description: </label>
            <textarea class="form-control form-control-sm" id="example-description" name="description" rows="6" maxlength="256"></textarea>
        </div>
        <div class="col-12">
            <label class="form-label" for="example-creation-date">Creation date: </label>
            <input class="form-control form-control-sm" id="example-creation-date" type="datetime-local" name="creationDate" readonly disabled>
        </div>
        <div class="col-12">
            <label class="form-label" for="example-modification-date">Last modification date: </label>
            <input class="form-control form-control-sm" id="example-modification-date" type="datetime-local" name="lastModificationDate"
                   readonly disabled>
        </div>
        <div class="col-12">
            <label class="form-label" for="example-deletion-date">Deletion date: </label>
            <input class="form-control form-control-sm" id="example-deletion-date" type="datetime-local" name="deletionDate" readonly disabled>
        </div>
        <div class="col-12 d-flex justify-content-around button-row">
            <button id="create-button" type="button" class="btn btn-primary text-uppercase">Create</button>
            <button id="clear-button" type="button" class="btn btn-info text-uppercase" disabled>Clear Form</button>
            <button id="update-button" type="button" class="btn btn-success text-uppercase" disabled>Update</button>
            <button id="delete-button" type="button" class="btn btn-danger text-uppercase" disabled>Delete</button>
        </div>
    </form>
</div>
</body>
</html>
