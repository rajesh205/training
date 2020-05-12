<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>
            <style>

                .editable-table .search_form{
                    border: 0px solid #ccc !important;
                    padding: 0px !important;
                    background: none !important;
                    float: right;
                    margin-right: 14px !important;
                }


                .editable-table .search_form input{
                    padding: 6px !important;
                    width: 250px !important;
                    background: #fff !important;
                    border-radius: none !important;
                }

                .editable-table .search_row{
                    margin-bottom: 20px !important;
                }

                .panel-body {
                    padding: 15px 0px 15px 0px;
                    background: transparent;
                }

            </style>



            <section class="col-md-3">
                <div class="post-info course_details">
                    <div class="panel-body">
                        <h1><strong><?php echo lang('course_details'); ?> </strong></h1>
                        <div class="desk yellow">
                            <h3><?php echo lang('course_name'); ?> </h3>  <?php
                            $couse_details = $this->course_model->getCourseById($course_id);
                            echo $couse_details->name;
                            ?>
                            <h3><?php echo lang('course_id'); ?> </h3> <?php echo $couse_details->course_id; ?>
                            <h3><?php echo lang('topic'); ?> </h3> <?php echo $couse_details->topic; ?>
                            <h3><?php echo lang('duration'); ?> </h3> <?php
                            echo $couse_details->duration;
                            ;
                            ?>
                            <h3><?php echo lang('course_fee'); ?> </h3> <?php echo $settings->currency; ?> <?php
                            echo $couse_details->course_fee;
                            ?>
                        </div>
                    </div>
                </div>
            </section>






            <div class="panel-body col-md-9">



                <div class="adv-table editable-table ">
                    <div class="clearfix search_row">
                        <button class="export" onclick="javascript:window.print();">Print</button>  



                    </div>

                    <header class="panel-heading">
                        <?php echo lang('batches'); ?>
                    </header>

                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('batch_id'); ?></th>
                                <th> <?php echo lang('instructor'); ?></th>
                                <th> <?php echo lang('start_date'); ?></th>
                                <th> <?php echo lang('end_date'); ?></th>
                                <th> <?php echo lang('students'); ?></th>
                                <th> <?php echo lang('options'); ?></th>
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
                        foreach ($batchs as $batch) {
                            ?>
                            <tr class="">
                                <td><?php echo $batch->batch_id ?></td>
                                <td> <?php echo $this->instructor_model->getInstructorById($batch->instructor)->name; ?></td>
                                <td><?php echo date($date_format, $batch->start_date); ?></td>
                                <td class="center"><?php echo date($date_format, $batch->end_date); ?></td>
                                <td><span class="student_number"><?php echo $this->batch_model->getStudentsNumberByBatchId($batch->id); ?> </span></td>
                                <td><a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=<?php echo $batch->id; ?>"><i class=""> </i> <?php echo lang('batch_details'); ?></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>



                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Batch Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('add_batch'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="course/addBatchToCourse" method="post" enctype="multipart/form-data">
                    <input type="text" name="search-batchs" class="search-batchs">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <select name="batch" class="ajaxoption"></select>
                    </div>

                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">





                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Batch Modal-->


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





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
                            $(document).ready(function () {
                                $(".search-batchs").keyup(function () {

                                    var keyword = this.value;
                                    $('.ajaxoption option').remove();

                                    $.ajax({
                                        url: 'course/getBatchByKey?keyword=' + keyword,
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
