<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                Batch Status
                 
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
                        <form role="form" action="batch/addBatchReport" method="post" >

                            <div class="form-group">
                                <label for="exampleInputEmail1"> Batch</label>
                                <select name="batch" class="form-control">
                                    <option value="0">Select Batch</option>
                                <?php
                                    foreach($batches as $batch){
                                ?>
                                    <option value="<?php echo $batch->id?>"><?php echo $batch->batch_id?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Status </label>
                                <select name="status" class="form-control">
                                    <option value="0">Select Status</option>
                                    <option value="stopped">Stopped</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Feedback </label>
                                <textarea class="form-control" name="feedaback">
                                    
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                                <input type="text" class="form-control default-date-picker" name="date" id="default-date-picker" value='' placeholder="">
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                            </div>

                        </form>

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