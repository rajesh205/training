<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

        <?php
        $date_format = $settings->date_format;
        if ($date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        ?> 


        <section class="col-md-12 row">
            <section class="col-md-3 no-print">
                <div class="post-info course_details">
                    <div class="panel-body">
                        <h1><strong><?php echo lang('batch_details'); ?> </strong></h1>
                        <div class="desk yellow">
                            <h3><?php echo lang('course_name'); ?> </h3>  <?php
                            $course_id = $this->batch_model->getBatchById($batch)->course;
                            $couse_details = $this->course_model->getCourseById($course);
                            echo $couse_details->name;
                            ?>
                            <h3><?php echo lang('batch_id'); ?> </h3> <?php echo $this->batch_model->getbatchById($batch)->batch_id; ?>
                            <h3><?php echo lang('instructor'); ?> </h3> <?php echo $this->instructor_model->getInstructorById($batch_details->instructor)->name; ?>
                            <h3>
                                <?php echo lang('start_date'); ?> </h3> <?php echo date($date_format, $batch_details->start_date); ?>
                            <h3><?php echo lang('end_date'); ?> </h3>
                            <?php echo date($date_format, $batch_details->end_date); ?>
                            <h3><?php echo lang('course_fee'); ?> </h3> <?php echo $settings->currency; ?> <?php
                            echo $batch_details->course_fee;
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-md-9 course_details panel-body">
                <header class="panel-heading">
                    <?php echo lang('routine'); ?> 
                    <button class="export no-print" onclick="javascript:window.print();">Print</button>   <a type="button" class="btn btn-info btn-xs btn_width details export no-print"  href="routine/editRoutine?id=<?php
                    if (!empty($routine_id)) {
                        echo $routine_id;
                    }
                    ?>"> <?php echo lang('edit'); ?></a>
                    <div class="clearfix search_row  pull-right no-print">
                        <a onclick="javascript:window.print();">
                            <div class="btn-group pull-right">
                                <button class="btn-xs green">
                                    <i class="fa fa-print"></i>  <?php echo lang('print'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                    <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                        <div class="clearfix search_row col-md-4 pull-right no-print">
                            <a href="routine/editRoutine?id=<?php echo $routine->id; ?>">
                                <div class="btn-group pull-right">
                                    <button class="btn-xs green">
                                        <i class="fa fa-edit"></i>  <?php echo lang('edit_routine'); ?>
                                    </button>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </header>

                <footer class="panel margin_top">
                    <div class="text-center hidden_details">
                        <?php echo lang('routine') ?> <br> <?php echo lang('course') ?> :  <?php
                        $batch_details = $this->batch_model->getBatchById($batch);
                        echo $this->course_model->getCourseById($batch_details->course)->name;
                        ?> <br> <?php echo lang('batch_id') ?>: <?php echo $this->batch_model->getBatchById($batch_details->id)->batch_id; ?>

                    </div>
                </footer>

                <table class="table table-striped table-hover table-bordered" id="">
                    <thead>
                        <tr>
                            <th> <?php echo lang('weekday'); ?></th>
                            <th> <?php echo lang('start_time'); ?></th>
                            <th> <?php echo lang('end_time'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <style>

                        .img_url{
                            height:20px;
                            width:20px;
                            background-size: contain; 
                            max-height:20px;
                            border-radius: 100px;
                        }

                    </style>


                    <?php
                    if (!empty($routine->routine)) {
                        $routine_details = explode('*', $routine->routine);
                        ?>
                        <tr class="">
                            <td> 
                                <?php echo lang('monday'); ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'monday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'monday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="">
                            <td> 
                                <?php echo lang('tuesday'); ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'tuesday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'tuesday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="">
                            <td> 
                                <?php echo lang('wednesday'); ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'wednesday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'wednesday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>

                        </tr>

                        <tr class="">
                            <td> 
                                <?php echo lang('thursday'); ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'thursday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'thursday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>
                        </tr>

                        <tr class="">

                            <td> 
                                <?php echo lang('friday'); ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'friday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'friday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>

                        </tr>

                        <tr class="">

                            <td> 
                                <?php echo lang('saturday'); ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'saturday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'saturday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>

                        </tr>

                        <tr class="">
                            <td> 
                                <?php echo lang('sunday'); ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'sunday') {
                                        echo $weekDayDetail[1];
                                    }
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                foreach ($routine_details as $routine_detail) {
                                    $weekDayDetail = explode(',', $routine_detail);
                                    if ($weekDayDetail[0] == 'sunday') {
                                        echo $weekDayDetail[2];
                                    }
                                }
                                ?>
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </section>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<style>

    .image11{
        width:  100px;
        height: 100px;
    }
    .post-info {
        position: relative !important;
        background: #fff !important;
        padding: 12px !important;
    }
    .post-wrap{
        margin-top: 0px !important;
        padding: 30px !important;
    }

    .btn1{
        width: 100% !important;
    }
    .panel{
        background: #f1f2f7 !important;
    }

    .course_details{
        margin-top: 19px;
    }

    .post-info .green{
        border: 1px solid !important;
    }

    .hidden_details{
        display: none;
    }

    @media print{
        .hidden_details{
            display: block;
        }
    }


</style>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
