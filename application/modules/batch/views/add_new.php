<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($batch->id))
                    echo lang('edit_batch');
                else
                    echo lang('add_batch');
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
                        <form role="form" action="batch/addNew" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                                <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='<?php
                                if (!empty($batch->batch_id)) {
                                    echo $batch->batch_id;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Batch Type</label><br>
                                <select class="form-control" id='type' name="type" style="width: 100% !important;" required="">
                                    <option value="0" >Select Type</option>
                                    <option value="Trainer" >Trainer</option>
                                    <option value="Support" >Support</option>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('employee'); ?></label><br>
                                <select class="form-control" id='employee' name="employee" style="width: 100% !important;">
                                   
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label><br>
                                <select class="form-control" id='selUser1' name="course" style="width: 100% !important;">
                                 <!--   <option value='0'><?php //echo lang('select_course');          ?></option>-->
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('instructor'); ?></label><br>
                                <select class="form-control" id='selUser2' name="instructor" style="width: 100% !important;">
                                <!--   <option value='0'><?php //echo lang('select_course');          ?></option>-->
                                </select>

                            </div>
                            <!--        <div class="form-group">
                                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label>
                                        <select class="form-control" name="course" value=''> 
                            <?php foreach ($courses as $course) { ?>
                                                                    <option value="<?php echo $course->id; ?>" <?php
                                if (!empty($batch->course)) {
                                    if ($batch->course == $course->id) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $course->name; ?> </option>
                            <?php } ?>
                                        </select>
                                    </div>




                                    <div class="form-group">
                                        <label for="exampleInputEmail1"> <?php echo lang('instructor'); ?></label>
                                        <select class="form-control" name="instructor" value=''> 
                            <?php foreach ($instructors as $instructor) { ?>
                                                                    <option value="<?php echo $instructor->id; ?>" <?php
                                if (!empty($batch->instructor)) {
                                    if ($batch->instructor == $course->id) {
                                        echo 'selected';
                                    }
                                }
                                ?> ><?php echo $instructor->name; ?> </option>
                            <?php } ?>
                                        </select>
                                    </div>-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?></label>
                                <input type="text" class="form-control default-date-picker" name="start_date" id="exampleInputEmail1" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?></label>
                                <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='<?php
                                if (!empty($batch->address)) {
                                    echo $batch->address;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <input type="text" class="form-control timepicker1" name="start_time" id="timepicker1" value='<?php
                                if (!empty($batch->start_time)) {
                                    echo $batch->start_time;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <input type="text" class="form-control timepicker1" name="end_time" id="exampleInputEmail1" value='<?php
                                if (!empty($batch->end_time)) {
                                    echo $batch->end_time;
                                }
                                ?>' placeholder="">
                            </div>
                            <?php
                                if (!empty($batch->feedback)) {
                            ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo lang('feedback'); ?></label>
                                    <textarea type="text" class="form-control" name="feedback" id="feedback" placeholder="">
                                        <?php
                                            echo $batch->feedback;
                                        ?>
                                            
                                    </textarea>
                                </div>
                            <?php
                                }
                            ?>
                            


                            <input type="hidden" name="id" value='<?php
                            if (!empty($batch->id)) {
                                echo $batch->id;
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
<script>
    $(document).ready(function () {
        $("#employee").select2({
            placeholder: 'Select Employee',
            allowClear: true,
            ajax: {
                url: 'batch/getEmployees',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_course'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getCourseList',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser2").select2({
            placeholder: '<?php echo lang('select_instructor'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getInstructorinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
</script>