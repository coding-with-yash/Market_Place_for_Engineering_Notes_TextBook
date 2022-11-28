<?php
// include header file
include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">Add New Product</h2>
        <form id="createProduct" class="add-post-form row" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Product Title</label>
                    <input type="text" class="form-control product_title" name="product_title" placeholder="Product Title" requried/>
                </div>
                <div class="form-group category">
                    <label for="">Product Category</label>
                    <?php
                    $db = new Database();
                    $db->select('categories','*',null,null,'categories.cat_id DESC',null);
                    // $sql = "SELECT * FROM categories ORDER BY categories.cat_id DESC";
                    $categories = $db->getResult();?>
                    <select class="form-control product_category" name="product_cat">
                        <option value="" selected disabled>Select Category</option>
                        <?php if ($categories > 0) {  
                            foreach($categories as $category) { ?>
                            <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_title']; ?></option>
                            <?php } 
                            } ?>
                    </select>
                </div>
                <div class="form-group sub_category">
                    <label for="">Product Sub-Category</label>
                    <select class="form-control product_sub_category" name="product_sub_cat">
                        <option value="" selected disabled>First Select Category</option>
                    </select>
                </div>
                <div class="form-group brand">
                    <label for="">Product Brand</label>
                    <select class="form-control product_brands" name="product_brand">
                        <option value="" selected disabled>First Select Sub Category</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Product Description</label>
                    <textarea class="form-control product_description" name="product_desc" rows="8" cols="80" requried></textarea>
                </div>
                <div class="show-error"></div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Featured Image</label>
                    <input type="file" class="product_image" requried name="featured_img">
                    <img id="image" src="" width="150px"/>
                </div>
                <div class="form-group">
                    <label for="">Product Price</label>
                    <input type="text" class="form-control product_price" name="product_price" requried value="">
                </div>
                <div class="form-group">
                    <label for="">Available Quantity</label>
                    <input type="number" class="form-control product_qty" name="product_qty" requried value="">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control product_status" name="product_status">
                        <option selected value="1">Publish</option>
                        <option value="0">Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn add-new" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
<?php
// include footer file
include "footer.php";
?>
