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
                        <th> <?php echo lang('date'); ?></th>
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
                foreach ($attendences as $attendence) {
                    $student_number = 0;
                    $present = 0;
                    ?>
                    <tr class="">
                        <td> <?php echo date('d-m-y', $attendence->date); ?></td>
                        <td>
                            <?php
                            $attendence_details = $attendence->attendence;
                            $students_details = explode(',', $attendence_details);
                            foreach ($students_details as $key => $value) {
                                $students = explode('*', $value);

                                $student_number = $student_number + 1;
                                if ($students[1] == 1) {
                                    $present = $present + 1;
                                }
                            }

                            echo $present / $student_number * 100;
                            ?> %
                        </td>
                        <td>
                            <a type="button" class="btn btn-info btn-xs btn_width editbutton"  href="attendence/attendenceDetails?id=<?php echo $attendence->id; ?>" ><i class="fa fa-edit"></i> <?php echo lang('details'); ?></a>   
                            <a class="btn btn-info btn-xs btn_width delete_button" href="attendence/delete?id=<?php echo $attendence->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"> </i> <?php echo lang('delete'); ?></a>
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
