<?php
session_start();
include("connect.php");
// include('includes/function.php');
?>


<!DOCtype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UPDATE TO-DO_LIST PROFILE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div id="app" class="container mt-5">
        <?php
        include("message.php");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>UPDATE TO DO LIST</h2>
                        <a href="index.php" class="btn btn-danger float-end">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="updatelistlogic.php" method="post">
                            <?php
                            if (isset($_GET['id'])) {
                                $query = "SELECT * FROM users  ";
                                $query_run = mysqli_query($conn, $query);
                                // $stmt->execute();
                                if (mysqli_num_rows($query_run) > 0) {
                                    $todo = mysqli_fetch_array($query_run);
                            ?>
                                    <input type="hidden" name="todo_id" value="<?= $todo['id']; ?>">
                                    <div class="mb-3">
                                        <label for=""> Name</label>
                                        <input type="text" class="form-control" v-model="name" value="<?= $todo['name']; ?>" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Time</label>
                                        <input type="text" class="form-control" v-model="time" name="time" value="<?= $todo['time']; ?>">
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary" name="updateList">Update to-do Info</button>
                                    </div>
                        </form>
                            <?php
                                } else {
                                    echo "<h4>NO RECORD  FOUND </h4>";
                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>                            
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="code.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>