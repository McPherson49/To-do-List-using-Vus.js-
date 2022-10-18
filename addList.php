<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To do Information Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <?php 
        include("message.php");
        ?>
        <div id="app" class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>TO DO INFORMATION</h2>
                        <a href="index.php" class="btn btn-danger float-end" >Back</a>
                    </div>
                    <div class="card-body">
                        <form action="addListlogic.php" method="post" v-if="!show">
                            <div class="mb-3">
                                <label for=""> Name</label>
                                <input type="text" v-model ="name" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Time</label>
                                <input v-model ="time" type="text" class="form-control" name="time" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" @click.prevent="handReturn" class="btn btn-primary" name="save_list">Save To-do Info</button>
                            </div>
                        </form>
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