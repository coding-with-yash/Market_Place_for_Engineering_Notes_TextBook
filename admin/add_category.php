<?php
// include header file
include 'header.php'; ?>
<div class="admin-content-container">
    <h2 class="admin-heading">Add New Category</h2>
    
    <!-- Form -->
    <div class="row">
        <form id="createCategory" class="add-post-form col-md-6" method="POST">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="cat" class="form-control category" placeholder="Category Name"  required/>
            </div>
            <input type="submit" name="save" class="btn add-new" value="Submit">
        </form>
    </div>
    <!-- /Form -->
</div>
<?php
//    include footer file
    include "footer.php";
?>