<?php 
session_start();
include("connect.php");
?>
 
                       
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TO DO INFORMATION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <div id="app" class="container mt-5"  v-if="" >
        <?php include("message.php"); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>TO DO LIST</h1>
                        <a href="addlist.php" class="btn btn-info float-end" v-if="show" >Add list</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th> Name</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- <tr>
                                <td v-if="!show" >ID</td>
                                <td> Name</td>
                                <td>Time</td>
                            </tr> -->
                            <?php 
                            
                            $query = "SELECT * FROM users ";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $todo) {
                                    ?>
                                    <tr>
                                        <td><?= $todo["id"];?></td>
                                        <td><?= $todo["name"];?></td>
                                        <td><?= $todo["time"];?></td>

                                        <td>
                                            <a href="todo_view.php?id=<?=$todo['id'];?>" class="btn btn-info btn-sm">View</a>
                                            <a href="updatelist.php?id=<?=$todo['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                            <form action="deletelistlogic.php" method="POST" class="d-inline">
                                                <button type="submit" name="delete_todo" value="<?=$todo['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else {
                                echo "<h5>NO RECORD FOUND</h5>";
                            }
                            ?>
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div> 
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>                            
    <script src="https://unpkg.com/vue@3"></script>
    <script src="code.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>

   <?php 
                            
                            $query = "SELECT * FROM users ";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $todo) {
                                    ?>
                                    <tr>
                                        <td><?= $todo["id"];?></td>
                                        <td><?= $todo["name"];?></td>
                                        <td><?= $todo["time"];?></td>

                                        <td>
                                            <a href="todo_view.php?id=<?=$todo['id'];?>" class="btn btn-info btn-sm">View</a>
                                            <a href="updatelist.php?id=<?=$todo['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                            <form action="deletelistlogic.php" method="POST" class="d-inline">
                                                <button type="submit" name="delete_todo" value="<?=$todo['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else {
                                echo "<h5>NO RECORD FOUND</h5>";
                            }
                            ?>  