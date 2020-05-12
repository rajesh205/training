<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">

            <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>

            <?php
            $batch_details = $this->batch_model->getbatchById($batch_id);
            ?>

            <style>

                .panel-body {
                    margin-left: 10px !important;
                    margin-right: 13px !important;
                }

                .post-info {
                    position: relative !important;
                    background: #fff !important;
                    padding: 30px !important;
                }
            </style>
            <section class="col-md-3">
                <div class="post-info course_details">
                    <div class="panel-body">
                        <h1><strong><?php echo lang('batch_details'); ?> </strong></h1>
                        <div class="desk yellow">
                            <h3><?php echo lang('course_name'); ?> </h3>  <?php
                            $course_id = $this->batch_model->getbatchById($batch_id)->course;
                            $couse_details = $this->course_model->getcourseById($course_id);
                            echo $couse_details->name;
                            ?>
                            <h3><?php echo lang('batch_id'); ?> </h3> <?php echo $this->batch_model->getbatchById($batch_id)->batch_id; ?>
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

            <section class="panel-body1 col-md-9">
                <div class="adv-table editable-table ">
                    <header class="panel-heading">
                        <i class="fa fa-list-alt"></i> <?php echo lang('batch_id'); ?> : <?php
                        echo $batch_details->batch_id;
                        ?>
                         <div class="col-md-3 no-print pull-right"> 
                            <a data-toggle="modal" href="#myModal">
                                <div class="btn-group pull-right">
                                    <button id="add_new" class="btn-xs green">
                                        <i class="fa fa-plus-circle"></i> <?php echo lang('add_student_to_this_batch'); ?>
                                    </button>
                                </div>
                            </a>
                        </div> 
                        <div class="col-md-2 no-print pull-right"> 
                            <a href="routine/viewRoutine?batch=<?php echo $batch_details->id; ?>">
                                <div class="btn-group pull-right">
                                    <button id="add_new" class="btn-xs green">
                                        <i class="fa fa-calendar-alt"></i> <?php echo lang('routine'); ?>
                                    </button>
                                </div>
                            </a>
                        </div>
                       
                    </header>
                    <header class="panel-heading">
                        <div class=""> <?php echo lang('students_of_this_batch'); ?> </div>
                    </header>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('image'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th class="no-print"> <?php echo lang('options'); ?></th>
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
                        foreach ($students as $key => $value) {

                            $student = $this->student_model->getStudentById($value);
                            if (!empty($student)) {
                                ?>
                                <tr class="">
                                    <td style="width:10%;"><img style="width:95%;" src="<?php echo $student->img_url; ?>"></td>
                                    <td> <?php echo $student->name; ?></td>
                                    <td><?php echo $student->email; ?></td>
                                    <td class="center"><?php echo $student->address; ?></td>
                                    <td><?php echo $student->phone; ?></td>
                                    <td class="no-print">
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="batch/deleteStudentFromBatch?student_id=<?php echo $student->id; ?>&batch_id=<?php echo $batch_id; ?>" onclick="return confirm('Are you sure you want to remove this student from the batch?');"><i class="fa fa-trash"> </i> <?php echo lang('remove'); ?></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>



                </div>
            </section>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Student Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_student'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="batch/addStudentToBatch" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('student'); ?> <?php echo lang('name'); ?></label><br>
                        <select class="form-control m-bot15" id='selUser1' name="student" style='width: 70%;'>

                        </select>                 
                    </div>
                    <input type="hidden" name="batch_id" value="<?php echo $batch_id; ?>">





                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Student Modal-->



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

</style>




<script src="common/js/codearistos.min.js"></script>

<script>
                                            $(document).ready(function () {
                                                $(".search-students").keyup(function () {

                                                    var keyword = this.value;
                                                    $('.ajaxoption option').remove();

                                                    $.ajax({
                                                        url: 'batch/getStudentByKey?keyword=' + keyword,
                                                        method: 'POST',
                                                        data: '',
                                                        dataType: 'json',
                                                    }).success(function (response) {

                                                        $.each(response.opp, function (key, value) {
                                                            $(".ajaxoption").append(value);
                                                        });
                                                    });


                                                });
                                            });

</script>
<script>
    $(document).ready(function () {

        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_student'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getStudentinfo',
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
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
