<?php // include header file
include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">All Products</h2>
        <a class="add-new pull-right" href="add_product.php">Add New</a>
        <?php
        $limit = 10;
        $db = new Database();
        $db->select('products','products.product_id,products.product_code,products.product_cat,products.product_sub_cat,products.product_brand,product_title,products.product_price,products.qty,products.product_status,products.featured_image,sub_categories.sub_cat_title,brands.brand_title','sub_categories ON products.product_sub_cat=sub_categories.sub_cat_id LEFT JOIN brands ON products.product_brand=brands.brand_id',null,'products.product_id DESC',$limit);
        $result = $db->getResult();
        if (count($result) > 0) { ?>
            <table id="productsTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th width="100px">Action</th>
                </thead>
                <tbody>
                    <?php foreach($result as $row) { ?>
                    <tr>
                        <td><b><?php echo 'PDR00'.$row['product_id']; ?></b></td>
                        <td><?php echo $row['product_title']; ?></td>
                        <td><?php echo $row['sub_cat_title']; ?></td>
                        <td><?php echo $row['brand_title']; ?></td>
                        <td><?php echo $currency_format.$row['product_price']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td>
                            <?php  if($row['featured_image'] != ''){ ?>
                                <img src="../product-images/<?php echo $row['featured_image']; ?>" alt="<?php echo $row['featured_image']; ?>" width="50px"/>
                            <?php }else{ ?>
                                <img src="images/index.png" alt="" width="50px"/>
                            <?php } ?>
                        </td>
                        <td><?php
                                if($row['product_status'] == '1'){
                                    echo '<span class="label label-success">Active</span>';
                                }else{
                                    echo '<span class="label label-danger">Inactive</span>';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['product_id'];  ?>"><i class="fa fa-edit"></i></a>
                            <a class="delete_product" href="javascript:void()" data-id="<?php echo $row['product_id'] ?>" data-subcat="<?php echo $row['product_sub_cat'] ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <div class="not-found clearfix">!!! No Products Found !!!</div>
        <?php    } ?>
        <div class="pagination-outer">
        <?php   //show pagination
        echo $db->pagination('products','sub_categories ON products.product_sub_cat=sub_categories.sub_cat_id LEFT JOIN brands ON products.product_brand=brands.brand_id',null,$limit);
        ?>
        </div>
    </div>
<?php //    include footer file
    include "footer.php";
?>
