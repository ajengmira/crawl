

            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div class="user-details">
                        <div class="pull-left">
                            <!--img src="<?php echo base_url().$avatar;?>" alt="" class="thumb-md img-circle"-->
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile"><i class="md md-face-unlock"></i> Profile<div class="ripple-wrapper"></div></a></li>
                                    <li><a href="lockscreen"><i class="md md-lock"></i> Lock screen</a></li>
                                    <li><a href="logout"><i class="md md-settings-power"></i> Logout</a></li>
                                </ul>
                            </div>

                            <p class="text-muted m-0"></p>
                        </div>
                    </div>
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="has_sub">
                                <a href="#" class="waves-effect <?php if ($this->uri->segment(1)=='test' or $this->uri->segment(1)=='testcrawl') {echo "active";} ?>"><i class="md md-polymer"></i> <span> Input URL </span> <span class="pull-right"><i class="md md-add"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo base_url(); ?>testcrawl">Test</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>host" class="waves-effect <?php if ($this->uri->segment(1)=='host') {echo "active";} ?>"><i class="md md-dashboard"></i><span> Manage URL </span></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->
