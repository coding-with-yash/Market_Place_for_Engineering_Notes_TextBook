<?php
// include header file
include 'header.php'; ?>

    <div class="admin-content-container">
        <h2 class="admin-heading">Add New Brand</h2>
        <div class="row">
        <?php if (isset($_POST['save'])) {
                include 'config.php';
                if (isset($_POST['title']) && isset($_POST['product_cat'])) {
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $product_cat = mysqli_real_escape_string($conn, $_POST['product_cat']);
                    if ($title != "" && $product_cat != "") {
                        /*sql to select a record*/
                        $sql = "SELECT brand_title FROM brands where brand_title='{$title}' && brand_cat='{$product_cat}'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            echo "<p style = 'color:red;text-align:center;margin: 10px 0';> Category already used.</p>";
                        } else {
                            /*sql to insert a record*/
                            $sql = "INSERT INTO brands (brand_title,brand_cat)
                                    VALUES ('{$title}','{$product_cat}')";
                            /*   echo "$sql"; exit; */
                            if (mysqli_query($conn, $sql)) {
                                header("location:{$hostname}/admin/brands.php");
                            }
                        }
                    } else {
                        ?>
                        <div class="alert alert-danger">Please fill all the fields</div>
                    <?php }
                } else { ?>
                    <div class="alert alert-danger">Please fill all the fields</div>
                <?php
                }
                mysqli_close($conn);
            } ?>
            <!-- Form -->
            <form id="createBrand" class="add-post-form col-md-6" method="POST"
                  autocomplete="off">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="brand_name" class="form-control brand_name" placeholder="Brand Name"/>
                </div>
                <div class="form-group">
                    <label for="">Brand Category</label>
                    <?php
                    $db = new Database();
                    $db->select('categories','*',null,null,null,null);
                    $result = $db->getResult(); ?>
                    <select class="form-control brand_category" name="brand_cat">
                        <option value="" selected disabled>Select Category</option>
                        <?php if (count($result) > 0) { ?>
                            <?php foreach($result as $row) { ?>
                                <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" name="save" class="btn add-new" value="Submit"/></button>
            </form>
            <!-- /Form -->
        </div>
    </div>
<?php
//    include footer file
    include "footer.php";
?>
            