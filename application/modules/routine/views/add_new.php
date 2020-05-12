<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($routine->routine)) {
                    echo lang('edit_routine');
                } else {
                    echo lang('add_routine');
                }
                ?>
            </header>


            <?php
            if (!empty($routine->routine)) {
                $routine_details = explode('*', $routine->routine);


                foreach ($routine_details as $key => $value) {
                    $weekdayDetails = explode(',', $value);

                    if ($weekdayDetails[0] == 'monday') {
                        $monday = $weekdayDetails[0];
                        $monday_start_time = $weekdayDetails[1];
                        $monday_end_time = $weekdayDetails[2];
                    }

                    if ($weekdayDetails[0] == 'tuesday') {
                        $tuesday = $weekdayDetails[0];
                        $tuesday_start_time = $weekdayDetails[1];
                        $tuesday_end_time = $weekdayDetails[2];
                    }

                    if ($weekdayDetails[0] == 'wednesday') {
                        $wednesday = $weekdayDetails[0];
                        $wednesday_start_time = $weekdayDetails[1];
                        $wednesday_end_time = $weekdayDetails[2];
                    }


                    if ($weekdayDetails[0] == 'thursday') {
                        $thursday = $weekdayDetails[0];
                        $thursday_start_time = $weekdayDetails[1];
                        $thursday_end_time = $weekdayDetails[2];
                    }

                    if ($weekdayDetails[0] == 'friday') {
                        $friday = $weekdayDetails[0];
                        $friday_start_time = $weekdayDetails[1];
                        $friday_end_time = $weekdayDetails[2];
                    }


                    if ($weekdayDetails[0] == 'saturday') {
                        $saturday = $weekdayDetails[0];
                        $saturday_start_time = $weekdayDetails[1];
                        $saturday_end_time = $weekdayDetails[2];
                    }

                    if ($weekdayDetails[0] == 'sunday') {
                        $sunday = $weekdayDetails[0];
                        $sunday_start_time = $weekdayDetails[1];
                        $sunday_end_time = $weekdayDetails[2];
                    }

                    $weekdayDetails = NULL;
                }
            }
            ?>



            <div class="panel-body">
                <form role="form" action="routine/addNew" method="post" enctype="multipart/form-data">
                    <?php if (empty($routine->routine)) { ?>
                        <div class="routine_top">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?></label>
                                <select class="form-control" name="course" id="acourse"> 
                                    <?php foreach ($courses as $course) { ?>
                                        <option value="<?php echo $course->id; ?>" data-id="<?php echo $course->id; ?>" <?php
                                        if (!empty($routine->routine)) {
                                            if ($course->id == $routine->course) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> ><?php echo $course->name; ?> 
                                        </option>
                                    <?php } ?>
                                </select> 
                            </div> 

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('batch'); ?></label>
                                <select class="form-control" name="batch_id" id="abatch"> 
                                </select>
                            </div>
                        </div>

                    <?php } else { ?>
                        <?php $batch_details = $this->batch_model->getBatchById($routine->batch_id); ?>
                        <div class="routine_top">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label>
                                <?php
                                $course_details = $this->course_model->getCourseById($batch_details->course);
                                echo $course_details->name;
                                ?> 
                            </div> 

                            <div class="form-group">
                                <label for="exampleInputEmail1">  <?php echo lang('batch'); ?></label>
                                <?php echo $batch_details->batch_id; ?>                  
                            </div>
                        </div>
                    <?php } ?>

                    <div class="section">
                        <div class="col-md-12">        
                            <div class="form-group col-md-4"> 
                                <input type="checkbox" name="monday" value="monday" <?php
                                if (!empty($monday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('monday'); ?></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_monday" id="exampleInputEmail1" value='<?php
                                    if (!empty($monday_start_time)) {
                                        echo $monday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_monday" format="hh:mm" id="exampleInputEmail1" value='<?php
                                    if (!empty($monday_end_time)) {
                                        echo $monday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>                       
                                </div>
                            </div>      
                        </div>

                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="tuesday" value="tuesday" <?php
                                if (!empty($tuesday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('tuesday'); ?></label>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_tuesday" id="exampleInputEmail1" value='<?php
                                    if (!empty($tuesday_start_time)) {
                                        echo $tuesday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_tuesday" id="exampleInputEmail1" value='<?php
                                    if (!empty($tuesday_end_time)) {
                                        echo $tuesday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>

                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="wednesday" value="wednesday" <?php
                                if (!empty($wednesday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('wednesday'); ?></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_wednesday" id="exampleInputEmail1" value='<?php
                                    if (!empty($wednesday_start_time)) {
                                        echo $wednesday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_wednesday" id="exampleInputEmail1" value='<?php
                                    if (!empty($wednesday_end_time)) {
                                        echo $wednesday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>

                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="thursday" value="thursday" <?php
                                if (!empty($thursday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('thursday'); ?></label>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_thursday" id="exampleInputEmail1" value='<?php
                                    if (!empty($thursday_start_time)) {
                                        echo $thursday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_thursday" id="exampleInputEmail1" value='<?php
                                    if (!empty($thursday_end_time)) {
                                        echo $thursday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>


                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="friday" value="friday" <?php
                                if (!empty($friday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('friday'); ?></label>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_friday" id="exampleInputEmail1" value='<?php
                                    if (!empty($friday_start_time)) {
                                        echo $friday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_friday" id="exampleInputEmail1" value='<?php
                                    if (!empty($friday_end_time)) {
                                        echo $friday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>

                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="saturday" value="saturday" <?php
                                if (!empty($saturday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('saturday'); ?></label>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_saturday" id="exampleInputEmail1" value='<?php
                                    if (!empty($saturday_start_time)) {
                                        echo $saturday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_saturday" id="exampleInputEmail1" value='<?php
                                    if (!empty($saturday_end_time)) {
                                        echo $saturday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>

                        <div class="col-md-12">        
                            <div class="form-group col-md-4">
                                <input type="checkbox" name="sunday" value="sunday" <?php
                                if (!empty($sunday)) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="exampleInputEmail1" class="label_for_time">  <?php echo lang('sunday'); ?></label>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="start_time_sunday" id="exampleInputEmail1" value='<?php
                                    if (!empty($sunday_start_time)) {
                                        echo $sunday_start_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                <div class="input-group bootstrap-timepicker">
                                    <input type="text" class="form-control timepicker-default" name="end_time_sunday" id="exampleInputEmail1" value='<?php
                                    if (!empty($sunday_end_time)) {
                                        echo $sunday_end_time;
                                    }
                                    ?>'>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-clock"></i></button>
                                    </span>
                                </div>
                            </div>      
                        </div>

                        <input type="hidden" name="id" value="<?php
                        if (!empty($routine->id)) {
                            echo $routine->id;
                        }
                        ?>">

                    </div>



                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php
                            if (!empty($routine->routine)) {
                                echo lang('update') . ' ' . lang('routine');
                            } else {
                                echo lang('add_routine');
                            }
                            ?>
                        </button>
                    </div>

                </form>
            </div>
        </section>






        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#acourse').on('change', function () {
            // Get the record's ID via attribute                 
            var iid = $(this).find(':selected').data('id');
            $('#abatch').find('option').remove();
            $.ajax({
                url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var batchs = response.batches;
                $.each(batchs, function (key, value) {
                    $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
                });
            });
        });
    });

    $(document).ready(function () {
        // Get the record's ID via attribute                 
        var iid = $(this).find(':selected').data('id');
        $('#abatch').find('option').remove();
        $.ajax({
            url: 'batch/getBatchByCourseIdByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var batchs = response.batches;
            $.each(batchs, function (key, value) {
                $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.timepicker-default').timepicker({
            timeFormat: 'h:mm p',
            interval: 15,
            minTime: '10',
            //  maxTime: '6:00pm',
<?php if (empty($routine->id)) { ?>
            defaultTime: 'current',
<?php } else { ?>
            defaultTime: false,
<?php } ?>
            startTime: '10:00',
            dynamic: true,
            dropdown: false,
            scrollbar: false,
        });
    });</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>




