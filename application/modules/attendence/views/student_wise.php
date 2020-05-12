<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
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
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?> : <?php echo $this->batch_model->getBatchById($batch_details->id)->batch_id; ?> </label>

                    </div>
                </div>
            </div>




            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                <thead>
                    <tr>
                        <th> <?php echo lang('student'); ?>  <?php echo lang('name'); ?> </th>
                        <th> <?php echo lang('percentage'); ?></th>
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
                $counter = 0;
                foreach ($attendences as $attendence) {
                    $attendence_details = $attendence->attendence;
                    $students_details = explode(',', $attendence_details);
                    foreach ($students_details as $key => $value) {
                        $all_students = explode('*', $value);
                        $students[] = $all_students[0];
                    }

                    $counter = $counter + 1;
                }
                if (!empty($students)) {
                    $students = array_unique($students);
                }
                ?>





                <?php
                if (!empty($students)) {
                    foreach ($students as $key => $value) {
                        ?>
                        <tr class="">
                            <td> <?php echo $this->student_model->getStudentById($value)->name; ?></td>
                            <td>
                                <?php
                                $present = 0;
                                foreach ($attendences as $attendence) {
                                    $attendence_details = $attendence->attendence;
                                    $students_info = explode(',', $attendence_details);
                                    foreach ($students_info as $key1 => $value1) {
                                        $student_info_details = explode('*', $value1);
                                        if ($student_info_details[0] == $value) {
                                            if ($student_info_details[1] == 1) {
                                                $present = $present + 1;
                                            }
                                        }
                                    }
                                }
                                echo $present / $counter * 100;
                                ?> %
                            </td>
                            <td>
                                <a type="button" class="btn btn-info btn-xs btn_width editbutton"  href="attendence/attendenceDetailsByStudent?student=<?php echo $value; ?>&batch=<?php echo $batch_details->id; ?>" ><i class="fa fa-edit"></i> <?php echo lang('details'); ?></a>   
                            </td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
