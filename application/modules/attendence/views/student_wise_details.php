<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-user"></i>  <?php
                if (!empty($attendence->attendence)) {
                    echo lang('edit_attendence');
                } else {
                    echo lang('attendence');
                }
                ?>
                <div class="clearfix search_row col-md-4 pull-right no-print">
                    <a onclick="javascript:window.print();">
                        <div class="btn-group pull-right">
                            <button class="btn-xs green">
                                <i class="fa fa-print"></i>  <?php echo lang('print'); ?>
                            </button>
                        </div>
                    </a>
                </div>
            </header>


            <div class="panel-body">
                <div class="attendence_top">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> 
                            <?php echo lang('course'); ?> : 
                            <?php
                            $batch_details = $this->batch_model->getBatchById($batch);
                            echo $this->course_model->getCourseById($batch_details->course)->name;
                            ?> 
                        </label>

                    </div> 

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?> : <?php echo $batch_details->batch_id; ?> </label>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('student'); ?> : <?php echo $this->student_model->getStudentById($student)->name; ?> </label>

                    </div>
                </div>
            </div>




            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                <thead>
                    <tr>
                        <th> <?php echo lang('date'); ?>  <?php echo lang('name'); ?> </th>
                        <th> <?php echo lang('status'); ?></th>
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




                <?php foreach ($attendences as $attendence) { ?>

                    <tr class="">
                        <td> <?php echo date('d-m-y', $attendence->date); ?></td>
                        <td>
                            <?php
                            $attendence_details = $attendence->attendence;
                            $students_info = explode(',', $attendence_details);
                            foreach ($students_info as $key1 => $value1) {
                                $student_info_details = explode('*', $value1);
                                if ($student_info_details[0] == $student) {
                                    if ($student_info_details[1] == 1) {
                                        echo lang('present');
                                    } else {
                                        echo lang('absent');
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>

                <?php } ?>




                </tbody>
            </table>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
