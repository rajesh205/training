<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                    echo "Add Lead Feedback";
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <?php echo validation_errors(); ?>
                            <?php 
                            
                                if($this->session->flashdata('success')){
                             ?> 
                                <div class="alert alert-warning">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div> 
                             <?php     
                                }
                                
                            ?>                              
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="student/saveFeedback" method="post" enctype="multipart/form-data">
                            
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('student'); ?></label><br>
                                <select class="form-control" id='student' name="student" style="width: 100% !important;">
                                   
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Feedback</label>
                                <textarea  class="form-control" name="feedback" id="exampleInputEmail1" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label><br>
                                <select class="form-control" id='status' name="status" style="width: 100% !important;">
                                   <option value="0">Select Status</option>
                                   <option value="Pending">Pending</option>
                                   <option value="Waiting">Waiting</option>
                                   <option value="Not Interested">Not Interested</option>
                                   <option value="Payment Recieved"> Payment Recieved</option>
                                   <option value="Completed">Completed</option>
                                </select>

                            </div>
                            
                            <input type="hidden" name="id" value='<?php
                            if (!empty($lead->lead_id)) {
                                echo $lead->lead_id;
                            }
                            ?>'>

                            <div class="form-group col-md-12">
                                <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
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
<script type="text/javascript">
    $(document).ready(function() {

        


        $("#student").select2({
            placeholder: 'Select Student',
            allowClear: true,
            ajax: {
                url: 'student/getStudents',
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
    })
</script>