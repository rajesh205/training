<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                  <?php
                if (!empty($attendence)) {
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
                            <?php echo $this->course_model->getCourseById($attendence->course)->name; ?> 
                        </label>
                    </div> 
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?> : <?php echo $this->batch_model->getBatchById($attendence->batch)->batch_id; ?> </label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> : <?php echo date('d-m-y', $attendence->date); ?> </label>
                    </div>
                </div>
            </div>




            <table class="table table-striped table-hover table-bordered" id="">
                <thead>
                    <tr>
                        <th> <?php echo lang('student'); ?></th>
                        <th> <?php echo lang('student'); ?> <?php echo lang('id'); ?></th>
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



                <?php
                $attendence_details = $attendence->attendence;
                $students_details = explode(',', $attendence_details);
                foreach ($students_details as $key => $value) {
                    $students = explode('*', $value);
                    ?>
                    <tr class="">
                        <td> <?php echo $this->student_model->getStudentById($students[0])->name; ?> </td>
                        <td> <?php echo $this->student_model->getStudentById($students[0])->id; ?> </td>
                        <td> <?php
                            if ($students[1] == 1) {
                                echo lang('present');
                            } else {
                                echo lang('absent');
                            }
                            ?> </td>
                    </tr>


                    <?php
                }
                ?> 

                </tbody>
            </table>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
