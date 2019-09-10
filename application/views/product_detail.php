
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Product Detail</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="#"><?php echo MY_CONSTANT; ?></a></li>
                                    <li><a href="<?php echo base_url(); ?>host">Product</a></li>
                                    <li class="active">Product Detail</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                      <a href="<?php echo base_url();?>scrap"><button class="btn btn-success waves-effect waves-light m-b-5"> <i class="fa fa-chevron-left"></i> <span> Back</span></button></a>
                                      <!--a href="#"><button class="btn btn-warning waves-effect waves-light m-b-5"> <i class="fa fa-edit"></i> <span> Edit</span></button></a-->
                                    </div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>host/update_host" method="post">
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">id</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['id']; ?></p>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Product Name</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['name']; ?></p>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Product Price</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['price']; ?></p>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Product Old Price</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['price_old']; ?></p>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Description</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['description']; ?></p>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Images</label>
                                              <div class="col-sm-10">
                                                <?php
                                                foreach ($images as $img) { ?>
                                                    <p class="form-control-static"><img src="<?php echo $img['image']; ?>" style="max-width:300px;"></p>
                                                <?php }
                                                ?>
                                                  
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Submited Date</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['created_at']; ?></p>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Last Update</label>
                                              <div class="col-sm-10">
                                                <p class="form-control-static"><?php echo $detail['updated_at']; ?></p>
                                              </div>
                                          </div>
                                        </form>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table id="datatable" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Review</th>
                                                            <th>Like</th>
                                                            <th>Dislike</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                        foreach ($reviews as $r) {
                                                            echo '<tr><td>'.$r['review'].'</td><td>'.$r['like'].'  <a href="'.base_url().'test/like/'.$r['product_id'].'/'.$r['id'].'">Like</a></td><td>'.$r['dislike'].'  <a href="'.base_url().'test/dislike/'.$r['product_id'].'/'.$r['id'].'">Dislike</a></td></tr>';
                                                        }

                                                       ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>test/review" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Review</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="review" placeholder="Example: Good quality" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                                <div class="col-md-2">
                                                    <input type="hidden" name="product_id" value="<?php echo $detail['id']; ?>" />
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light m-b-5">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- panel-body -->
                                </div> <!-- panel -->
                            </div> <!-- col -->
                        </div> <!-- End row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
                    Page rendered in <strong>{elapsed_time}</strong> seconds | 2019 © <?php echo MY_CONSTANT; ?>.
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->



        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets/jquery-detectmobile/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets/fastclick/fastclick.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/assets/jquery-blockui/jquery.blockUI.js"></script>


        <!-- CUSTOM JS -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>
	</body>
</html>
