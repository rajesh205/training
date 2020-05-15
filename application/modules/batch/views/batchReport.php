<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12 row">
            <header class="panel-heading">
                Batch Status
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="batch/addBatchReport">
                        <div class="btn-group pull-right">
                            <button id="" class="btn-xs green">
                                <i class="fa fa-plus-circle"></i> Add Batch Report
                            </button>
                        </div>
                    </a>
                </div> 
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="col-lg-9">
                                <form class="" method="post" action="batch/reports">
                                    <div class="col-md-3 form-group">
                                        <input type="text" class="form-control default-date-picker col-md-5" required name="start_date" id="exampleInputEmail1" placeholder="">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" class="form-control default-date-picker col-md-5" required name="end_date" id="exampleInputEmail1" placeholder="">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="submit" class="btn btn-info" value="Search">
                                    </div>
                                </form>
                            </div>
                            <?php echo validation_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>                              
                            <div class="col-lg-3"></div>

                        </div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('batch_id'); ?></th>
                                    <th> Status </th>
                                    <th> Course </th>
                                    <th> Date </th>
                                    <th> Start Time </th>
                                    <th> End Time </th>
                                    <th> Total Time </th>
                                    <th> Feedback</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(empty($batch_reports)) {
                                ?>
                                    <tr>
                                        <td colspan="8">
                                            No Report Found
                                        </td>
                                    </tr>
                                <?php
                                }
                                foreach($batch_reports as $report){
                                    $course = $this->batch_model->getCourseByBatch($report->batch);

                                    $time1 = strtotime($report->start_time);
                                    $time2 = strtotime($report->end_time);
                                    $total_time = round(abs($time2 - $time1) / 3600,2);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $report->batch?>
                                    </td>
                                    <td>
                                        <?php echo $report->status?>
                                    </td>
                                    <td>
                                        <?php echo $course[0]['name']?>
                                    </td>
                                    <td>
                                        <?php echo $report->date?>
                                    </td>
                                    <td>
                                        <?php echo $report->start_time?>
                                    </td>
                                    <td>
                                        <?php echo $report->end_time?>
                                    </td>
                                     <td>
                                        <?php echo $total_time?> Hrs
                                    </td>
                                    <td>
                                        <?php echo $report->feedback?>
                                        
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                
                            </tbody>
                        </table>
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
        
    });
</script>