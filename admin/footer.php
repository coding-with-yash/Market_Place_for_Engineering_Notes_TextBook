                        <!-- Footer Start-->
                        <div id="admin-footer">
                            <?php
                            $db = new Database();
                            $db->select('options','footer_text',null,null,null,null);
                            $result = $db->getResult();

                            if(count($result) > 0){ ?>
                                <span><?php echo $result[0]['footer_text']; ?></span>
                            <?php }else{ ?>
                                <span>Created By YahooBaba</span>
                            <?php }
                            ?>
                            
                        </div>
                        <!-- Footer End-->
                    </div>
                    <!-- Content End-->
                </div>
            </div>
        </div>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/admin_actions.js" type="text/javascript"></script>
        <script src="js/jquery-te-1.4.0.min.js" type="text/javascript"></script>   
        <!-- https://jqueryte.com/ -->
        <script>
            $('.product_description').jqte({
                link: false,
                unlink: false,
                color: false,
                source: false,
            });
        </script>
    </body>
</html>
