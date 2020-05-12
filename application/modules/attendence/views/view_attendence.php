<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                 <?php echo lang('student'); ?> <?php echo lang('attendence'); ?> <?php echo lang('report'); ?>
            </header>


            <div class="panel-body">
                <form role="form" action="attendence/viewAttendenceDetails" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="attendence_top">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?></label>
                            <select class="form-control" name="course" id="acourse"> 
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?php echo $course->id; ?>" data-id="<?php echo $course->id; ?>" <?php
                                    if (!empty($attendence->attendence)) {
                                        if ($course->id == $attendence->course) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> ><?php echo $course->name; ?> 
                                    </option>
                                <?php } ?>
                            </select> 
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('batch'); ?></label>
                            <select class="form-control" name="batch_id" id="abatch"> 

                            </select>
                        </div>
                    </div>

                    
                     
                 
                     <div class="form-group col-md-8">
                       <button type="submit" name="submit" value="submit" class="btn btn-info pull-right"> <?php echo lang('view'); ?> <?php echo lang('date_wise'); ?></button>
                    </div>
                     
                     <div class="form-group col-md-4">
                       <button type="submit" name="submit" value="submit1" class="btn btn-info pull-right"> <?php echo lang('view'); ?> <?php echo lang('student_wise'); ?></button>
                    </div>

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
