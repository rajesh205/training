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
                            <div class="col-lg-3"></div>
                            <?php echo validation_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>                              
                            <div class="col-lg-3"></div>
                        </div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('batch_id'); ?></th>
                                    <th> Status </th>
                                    <th> Date </th>
                                    <th> Feedback</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($batch_reports as $report){
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $report->batch?>
                                    </td>
                                    <td>
                                        <?php echo $report->status?>
                                    </td>
                                    <td>
                                        <?php echo $report->date?>
                                    </td>
                                    <td>
                                        <?php echo $report->feedaback?>
                                        
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