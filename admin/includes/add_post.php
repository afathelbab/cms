<?php 
    if(isset($_POST["create_post"])) {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['post_image']['name'];
        $post_image_tmp = $_FILES['post_image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date = date('Y-m-d');
        $post_comment_count = 4;

        move_uploaded_file($post_image_tmp, "../images/$post_image");

        // Ensure the connection is available
        global $connection;

        // Escape user inputs for security
        $post_title = mysqli_real_escape_string($connection, $post_title);
        $post_category_id = mysqli_real_escape_string($connection, $post_category_id);
        $post_author = mysqli_real_escape_string($connection, $post_author);
        $post_status = mysqli_real_escape_string($connection, $post_status);
        $post_image = mysqli_real_escape_string($connection, $post_image);
        $post_tags = mysqli_real_escape_string($connection, $post_tags);
        $post_content = mysqli_real_escape_string($connection, $post_content);

        $query = "INSERT INTO posts(post_title, post_category_id, post_author, post_status, post_image, post_tags, post_content, post_date, post_comment_count) ";
        $query .= "VALUES('{$post_title}', {$post_category_id}, '{$post_author}', '{$post_status}', '{$post_image}', '{$post_tags}', '{$post_content}', now(), {$post_comment_count})";

        $create_post_query = mysqli_query($connection, $query);

        if(!$create_post_query) {
            die("Query failed: " . mysqli_error($connection));
        } else {
            echo "Post created successfully!";
        }
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category" id="post_category">
            <?php 
               $query = "SELECT * FROM categories";
               $select_categories = mysqli_query($connection, $query);

               if(!$select_categories) {
                die("Query failed: " . mysqli_error($connection));
                }

               while ($row = mysqli_fetch_assoc($select_categories)) {
                   $cat_id = $row['cat_id'];
                   $cat_title = $row['cat_title'];
                   echo "<option value='{$cat_id}'>{$cat_title}</option>";
               } 
                
            
            ?>

        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish">
    </div>

</form>