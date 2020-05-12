<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($course->id))
                    echo lang('edit_course');
                else
                    echo lang('add_course');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <?php echo validation_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>                              
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="course/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('id'); ?></label>
                                <input type="text" class="form-control" name="course_id" id="exampleInputEmail1" value='<?php
                                if (!empty($course->course_id)) {
                                    echo $course->course_id;
                                }
                                ?>' placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course'); ?>  <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($course->name)) {
                                    echo $course->name;
                                }
                                ?>' placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('topic'); ?></label>
                                <input type="text" class="form-control" name="topic" id="exampleInputEmail1" value='<?php
                                if (!empty($course->topic)) {
                                    echo $course->topic;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('duration'); ?></label>
                                <input type="text" class="form-control" name="duration" value='<?php
                                if (!empty($course->duration)) {
                                    echo $course->duration;
                                }
                                ?>' id="exampleInputEmail1" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                                <input type="text" class="form-control" name="course_fee" value='<?php
                                if (!empty($course->course_fee)) {
                                    echo $course->course_fee;
                                }
                                ?>' id="exampleInputEmail1" placeholder="">
                            </div>


                            <input type="hidden" name="id" value='<?php
                            if (!empty($course->id)) {
                                echo $course->id;
                            }
                            ?>'>


                            <div class="form-group col-md-12">
                                <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
