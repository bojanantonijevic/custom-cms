<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Update Category</label>

        <?php 
            if(isset($_GET['update'])){

                $cat_id = escape($_GET['update']);   

                $query = "SELECT * FROM categories WHERE id = $cat_id";
                $select_categories_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_id)){
                $cat_id = $row['id'];
                $cat_title = $row['cat_title'];

                ?>

                <input value="<?php echo $cat_title;?>" class="form-control" type="text" name="cat_title">
            <?php }} ?>

            <?php 

            //UPDATE BTN QUERY
            if(isset($_POST['update'])){
                $cat_title = escape($_POST['cat_title']);

                $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE id = ? " );
                mysqli_stmt_bind_param($stmt, 'si', $cat_title, $cat_id);
                mysqli_stmt_execute($stmt);

                
                if(!$stmt){
                    die("Update query failed".mysqli_error($connection));
                }

              redirect("categories.php");  
            }
        ?>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update">
    </div>
</form>