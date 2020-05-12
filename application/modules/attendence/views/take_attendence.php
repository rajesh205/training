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
            </header>




            <div class="panel-body">
                <form role="form" action="attendence/addNew" method="post" enctype="multipart/form-data">

                    <div class="attendence_top">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('course'); ?> : <?php echo $this->course_model->getCourseById($course)->name; ?> </label>
                             <input type="hidden" name="course" value=" <?php echo $course; ?>">
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?> : <?php echo $this->batch_model->getBatchById($batch)->batch_id; ?> </label>
                             <input type="hidden" name="batch" value=" <?php echo $batch; ?>">
                        </div>
                        
                          <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?> :  </label>
                             <input type="text" name="date" class="default-date-picker">
                        </div>
                    </div>

                    <div class="section">


                        <?php
                        foreach ($students as $key => $value) {

                            $student = $this->student_model->getStudentById($value);
                            ?>

                            <div class="col-md-12">        
                                <div class="form-group col-md-4"> 
                                    <label for="exampleInputEmail1" class="label_for_time">  <?php echo $student->name; ?></label>
                                    <input type="hidden" name="student[]" value=" <?php echo $student->id; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1"> <?php echo lang('status'); ?></label>
                                    <div class="input-group">
                                        
                                        <!--
                                        <input type="checkbox"> Present
                                        <input type="checkbox"> Absent
                                        -->
                                        
                                        <select class="form-control" name="attendence[]" id="acourse"> 

                                            <option value="none"><?php echo lang('select'); ?> --- </option>
                                            <option value="1"><?php echo lang('present'); ?> </option>
                                            <option value="0"><?php echo lang('absent'); ?> </option>

                                        </select>
                                        
                                    </div> 
                                </div>

                            </div>

                        <?php } ?>


                    </div>




                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>

                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#acourse').on('change', function () {
            // Get the record's ID via attribute                 
            var iid = $(this).find(':selected').data('id');
            $('#abatch').find('option').remove();
            $.ajax({
                url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var batchs = response.batches;
                $.each(batchs, function (key, value) {
                    $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
                });
            });
        });
    });

    $(document).ready(function () {
        // Get the record's ID via attribute                 
        var iid = $(this).find(':selected').data('id');
        $('#abatch').find('option').remove();
        $.ajax({
            url: 'batch/getBatchByCourseIdByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var batchs = response.batches;
            $.each(batchs, function (key, value) {
                $('#abatch').append($('<option>').text(value.batch_id).val(value.id)).end();
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
