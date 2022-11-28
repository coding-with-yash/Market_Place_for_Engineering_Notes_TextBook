<?php
// include header file
include 'header.php'; ?>
<div class="admin-content-container">
    <h2 class="admin-heading">Add New Sub Category</h2>
    <div class="row">
    <!-- Form -->
    <form id="createSubCategory" class="add-post-form col-md-6" method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="sub_cat_name" class="form-control sub_category" placeholder="Sub Category Name" />
        </div>
        <div class="form-group">
            <label for="">Parent Category</label>
            <?php
            $db = new Database();
            $db->select('categories','*',null,null,null,null);
            $result = $db->getResult(); ?>
            <select class="form-control parent_cat" name="parent_cat">
                <option value="" selected disabled>Select Category</option>
                <?php if (count($result) > 0) {  ?>
                <?php foreach($result as $row) { ?>
                    <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                <?php } ?>
                <?php } ?>
            </select>
        </div>
        <input type="submit" name="save" class="btn add-new" value="Submit" />
    </form>
    <!-- /Form -->
    </div>
</div>
<?php
//    include footer file
    include "footer.php";
?>
