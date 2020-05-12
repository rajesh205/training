<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php echo lang('course_wise_income_report'); ?>
            </header>

            <?php
            if ($settings->date_format == 1) {
                $date_format = 'dd-mm-yyyy';
            } else {
                $date_format = 'mm/dd/yyyy';
            }
            ?>

            <div class="panel-body">
                <form role="form" action="finance/courseWiseIncomeReport" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?> </label>
                            <select class="form-control" name="course" value=''> 
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?php echo $course->id; ?>" <?php
                                    if (!empty($batch->course)) {
                                        if ($batch->course == $course->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> ><?php echo $course->name; ?> </option>
                                        <?php } ?>
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








<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#acourse').on('change', function () {
            // Get the record's ID via attribute                 
            var iid = $(this).find(':selected').data('id');
            $('#abatch').find('option').remove();
            $.ajax({
                url: 'attendence/getStaffsByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var staffs = response.staffs;
                $.each(staffs, function (key, value) {
                    $('#abatch').append($('<option>').text(value.name).val(value.ion_user_id)).end();
                });
            });
        });
    });

    $(document).ready(function () {
        // Get the record's ID via attribute                 
        var iid = $(this).find(':selected').data('id');
        $('#abatch').find('option').remove();
        $.ajax({
            url: 'attendence/getStaffsByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var staffs = response.staffs;
            var staff_type = response.staff_type;
            $.each(staffs, function (key, value) {
                $('#abatch').append($('<option>').text(value.name).val(value.ion_user_id)).end();
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
