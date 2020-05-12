<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php echo lang('batch_wise_income_report'); ?>
            </header>

            <?php
            if ($settings->date_format == 1) {
                $date_format = 'dd-mm-yyyy';
            } else {
                $date_format = 'mm/dd/yyyy';
            }
            ?>

            <div class="panel-body">
                <form role="form" action="finance/batchWiseIncomeReport" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="attendence_top">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?> </label>
                            <select class="form-control" name="course" id="acourse">
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?php echo $course->id; ?>" data-id="<?php echo $course->id; ?>" <?php
                                    if (!empty($batch->course)) {
                                        if ($batch->course == $course->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> ><?php echo $course->name; ?> </option>
                                        <?php } ?>
                            </select>
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('batch'); ?></label>
                            <select class="form-control" name="batch_id" id="abatch"> 

                            </select>
                        </div>


                        <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('date'); ?> </label>
                        <div class = "input-group input-large"  data-date-format = <?php echo $date_format; ?>>
                            <input type = "text" class = "form-control dpd1" name = "date_from" value = "<?php
                            if (!empty($from)) {
                                echo $from;
                            }
                            ?>" placeholder = " <?php echo lang('date_from'); ?> ">
                            <span class = "input-group-addon"> <?php echo lang('to');
                            ?> </span>
                            <input type="text" class="form-control dpd2" name="date_to" value="<?php
                            if (!empty($to)) {
                                echo $to;
                            }
                            ?>" placeholder=" <?php echo lang('date_to'); ?> ">
                        </div>
                        <div class="row"></div>
                        <span class="help-block"></span> 



                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" class="btn btn-info pull-right">  <?php echo lang('income'); ?> <?php echo lang('report'); ?></button>
                        </div>


                    </div>





                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script src="common/js/ajaxrequest-codearistos.min.js"></script>
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
