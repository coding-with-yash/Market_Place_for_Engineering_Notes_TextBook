<?php
// include header file
include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">Dashboard</h2>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $db = new Database();
                    $db->select('products','product_id',null,'qty < 1',null,0);
                    $qty = $db->getResult();
                    if(!empty($qty)){  ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="active"><td colspan="2">OUT OF Stock</td></tr>
                            </thead>
                            <tbody>
                                <?php foreach($qty as $q){ ?>
                                    <tr>
                                    <td>Product Code</td>
                                    <td><?php echo 'PDR00'.$q['product_id']; ?></td>
                                </tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
            </div>
            <div class="col-md-4">
                <?php
                    $db = new Database();
                    $db->select('products','COUNT(product_id) as p_count',null,null,null,0);
                    $products = $db->getResult();
                ?>
                <div class="detail-box">
                    <span class="count"><?php echo $products[0]['p_count']; ?></span>
                    <span class="count-tag">Products</span>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $db = new Database();
                    $db->select('categories','COUNT(cat_id) as c_count',null,null,null,0);
                    $category = $db->getResult();
                ?>
                <div class="detail-box">
                    <span class="count"><?php echo $category[0]['c_count']; ?></span>
                    <span class="count-tag">Categories</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $db = new Database();
                        $db->select('sub_categories','COUNT(sub_cat_id) as sub_count',null,null,null,0);
                        $sub_category = $db->getResult();
                    ?>
                    <span class="count"><?php echo $sub_category[0]['sub_count']; ?></span>
                    <span class="count-tag">Sub Categories</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $db = new Database();
                        $db->select('brands','COUNT(brand_id) as b_count',null,null,null,0);
                        $brands = $db->getResult();
                    ?>
                    <span class="count"><?php echo $brands[0]['b_count']; ?></span>
                    <span class="count-tag">Brands</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $db = new Database();
                        $db->select('order_products','COUNT(order_id) as o_count',null,null,null,0);
                        $orders = $db->getResult();
                    ?>
                    <span class="count"><?php echo $orders[0]['o_count']; ?></span>
                    <span class="count-tag">Orders</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-box">
                    <?php
                        $db = new Database();
                        $db->select('user','COUNT(user_id) as u_count',null,null,null,0);
                        $users = $db->getResult();
                    ?>
                    <span class="count"><?php echo $users[0]['u_count']; ?></span>
                    <span class="count-tag">Users</span>
                </div>
            </div>
        </div>
    </div>
<?php
//    include footer file
    include "footer.php";

?>
