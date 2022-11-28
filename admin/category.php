<?php
include 'header.php'; ?>
<div class="admin-content-container">
    <h2 class="admin-heading">All Categories</h2>
    <a class="add-new pull-right" href="add_category.php">Add New</a>
    <?php
    $limit = 10;
    $db = new Database();
    $db->select('categories','*',null,null,'categories.cat_id DESC',$limit);
    $result = $db->getResult();
    if (count($result) > 0) { ?>
        <table class="table table-striped table-hover table-bordered">
            <thead>
            <th>Title</th>
            <th>Action</th>
            </thead>
            <tbody>
            <?php foreach($result as $row) { ?>
                <tr>
                    <td><?php echo $row['cat_title']; ?></td>
                    <td>
                        <a href="edit_cat.php?id=<?php echo $row['cat_id'];  ?>"><i class="fa fa-edit"></i></a>
                        <a class="delete_category" href="javascript:void()" data-id="<?php echo $row['cat_id']; ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php }else{ ?>
        <div class="not-found">!!! No Category Available !!!</div>
    <?php    }  ?>
    <div class="pagination-outer">
        <?php echo $db->pagination('categories',null,null,$limit); ?>
    </div>
</div>
<?php
//    include footer file
    include "footer.php";
?>
