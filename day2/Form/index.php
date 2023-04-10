<?php
session_start();
// session_destroy();
$currentIndex = $_SESSION["currentIndex"] ?? 0;
// Helper Functions File
require_once("./FormHandler.php");
$handler = new FormHandler('employess.xml');
// Initialize variables for employee data



$data = $handler->displayData($currentIndex);
extract($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["add"])) {
        $handler->saveDataInXML();
    } elseif (isset($_POST["next"])) {
        $handler->getNextData($_SESSION["currentIndex"]);
    } elseif (isset($_POST["prev"])) {
        $handler->getPrevData($_SESSION["currentIndex"]);
    } elseif (isset($_POST['update'])) {
        $handler->updateData();
    } elseif (isset($_POST['search'])) {
        // var_dump($_POST['name']);
        $handler->searchByName($_POST['name']);
        extract($data);
    } elseif (isset($_POST['delete'])) {
        $handler->deleteData($_SESSION["currentIndex"]);
    }
}

// var_dump($data);
// var_dump($_SESSION["currentIndex"]);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Employee </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2> Employees Count is <?= $handler->countData ?> </h2>

                <h2> Employee Number <?= $_SESSION['currentIndex'] + 1; ?></h2>
                <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input value="<?= $name ?>" type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input value="<?= $phone ?>" type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input value="<?= $address ?>" type="text" class="form-control" id="address" placeholder="Enter address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input value="<?= $email ?>" type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block" name="add">Add</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-dark btn-block" name="prev">Previous</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-dark btn-block" name="next">Next</button>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">

                        <div class="col-md-4">
                            <input type='hidden' name='currentIndex' value='<?= $currentIndex ?>'>
                            <button type='submit' class="btn btn-primary btn-block" name='update' class='btn btn-primary'>Update</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info btn-block" name="search">Search</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-danger btn-block" name="delete">Delete</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>