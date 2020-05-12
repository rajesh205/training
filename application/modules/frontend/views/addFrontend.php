<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($website->id))
                    echo '<i class="fa fa-edit"></i> ' . lang('edit_website');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">

                        <div class="col-md-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="col-lg-3"></div>
                                        <?php echo validation_errors(); ?>
                                        <?php echo $this->session->flashdata('feedback'); ?>                              
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <form role="form" action="frontend/addNew" method="post" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('about'); ?></label>
                                                <textarea name="about" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->about)) {
                                                        echo $website->about;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('facebook') . " " . lang('link'); ?></label>
                                                <input type="text" class="form-control" name="facebook" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->facebook)) {
                                                    echo $website->facebook;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('twitter') . " " . lang('link'); ?></label>
                                                <input type="text" class="form-control" name="twitter" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->twitter)) {
                                                    echo $website->twitter;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('tumblr') . " " . lang('link'); ?></label>
                                                <input type="text" class="form-control" name="tumblr" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->tumblr)) {
                                                    echo $website->tumblr;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('slider1') . " " . lang('image'); ?></label>
                                                <input type="file" name="img_url1">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('slider2') . " " . lang('image'); ?></label>
                                                <input type="file" name="img_url2">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"><?php echo lang('slider3') . " " . lang('image'); ?></label>
                                                <input type="file" name="img_url3">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor1'); ?></label>
                                                <input type="text" class="form-control" name="instructor1" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->instructor1)) {
                                                    echo $website->instructor1;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor1detail'); ?></label>
                                                <textarea name="instructor1detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->instructor1detail)) {
                                                        echo $website->instructor1detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor2'); ?></label>
                                                <input type="text" class="form-control" name="instructor2" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->instructor2)) {
                                                    echo $website->instructor2;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor2detail'); ?></label>
                                                <textarea name="instructor2detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->instructor2detail)) {
                                                        echo $website->instructor2detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course1'); ?></label>
                                                <input type="text" class="form-control" name="course1" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->course1)) {
                                                    echo $website->course1;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course1detail'); ?></label>
                                                <textarea name="course1detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->course1detail)) {
                                                        echo $website->course1detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course2'); ?></label>
                                                <input type="text" class="form-control" name="course2" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->course2)) {
                                                    echo $website->course2;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course2detail'); ?></label>
                                                <textarea name="course2detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->course2detail)) {
                                                        echo $website->course2detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course3'); ?></label>
                                                <input type="text" class="form-control" name="course3" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->course3)) {
                                                    echo $website->course3;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('course3detail'); ?></label>
                                                <textarea name="course3detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->course3detail)) {
                                                        echo $website->course3detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor3'); ?></label>
                                                <input type="text" class="form-control" name="instructor3" id="exampleInputEmail1" value='<?php
                                                if (!empty($website->instructor3)) {
                                                    echo $website->instructor3;
                                                }
                                                ?>' placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo lang('instructor3detail'); ?></label>
                                                <textarea name="instructor3detail" cols="68" rows="10" id="exampleInputEmail1" value='' placeholder=""><?php
                                                    if (!empty($website->instructor3detail)) {
                                                        echo $website->instructor3detail;
                                                    }
                                                    ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($website->id)) {
                                            echo $website->id;
                                        }
                                        ?>'>

                                        <div class="col-md-12">
                                            <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                                        </div>
                                    </form>

                                </div>
                            </section>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
