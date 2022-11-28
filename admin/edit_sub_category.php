<?php
// include header file
    include 'header.php'; ?>
        <div class="admin-content-container">
            <h3 class="admin-heading">Update Sub Category</h3>
            <?php  
                $sub_cat_id = $_GET['id'];
                $db = new Database();
                $db->select('sub_categories','*',null,"sub_cat_id ='{$sub_cat_id}'",null,null);
                $result = $db->getResult();
                if (count($result) > 0) {
                    foreach($result as $row) {?>
                    <div class="row">
                        <!-- Form -->
                        <form id="updateSubCategory" class="add-post-form col-md-6" method ="POST">
                            <input type="hidden" name="sub_cat_id" value="<?php echo $row['sub_cat_id']; ?>" >
                            <div class="form-group">
                                <label>Sub Category Title</label>
                                <input type="text" name="sub_cat_name" class="form-control sub_category" value="<?php echo $row['sub_cat_title']; ?>"  placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <?php
                                $db->select('categories','*',null,null,null,null);
                                $result2 = $db->getResult(); ?>
                                <select name="parent_cat" class="form-control parent_cat">
                                    <option value="">Select Category</option>
                                    <?php if (count($result2) > 0) {  ?>
                                        <?php foreach($result2 as $row2) { ?>
                                            <option <?php if($row2['cat_id'] == $row['cat_parent']) echo 'selected="selected"';  ?> value="<?php echo $row2['cat_id']; ?>"><?php echo $row2['cat_title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="submit" name="sumbit" class="btn add-new" value="Update" />
                        </form>
                        <!-- /Form -->
                    </div>
                    <?php
                    }
                } else { ?>
                    <div class="empty-result">!!! Result Not Found !!!</div>
            <?php } ?>
        </div>
<?php
//    include footer file
include "footer.php";
?>
   

