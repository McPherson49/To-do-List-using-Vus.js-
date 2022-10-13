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