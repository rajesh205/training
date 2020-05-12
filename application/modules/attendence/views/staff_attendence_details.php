<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('staff'); ?> <?php echo lang('attendence'); ?>
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


            <div class="panel-body col-md-6">

                <div class="attendence_top">

                    <div class="form-group">
                        <label for="exampleInputEmail1">  <?php echo lang('staff'); ?>  <?php echo lang('name'); ?> : <?php echo $staff->name; ?></label>

                    </div>




                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('staff'); ?>  <?php echo lang('type'); ?> : <?php
                            if ($staff_type == 1) {
                                echo lang('instructor');
                            } else {
                                echo lang('employee');
                            }
                            ?>
                        </label>   

                    </div> 



                    <div class="form-group">
                        <label for="exampleInputEmail1">  <?php echo lang('year'); ?> : <?php echo $year; ?></label>

                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">  <?php echo lang('month'); ?> : <?php
                            $dateObj = DateTime::createFromFormat('!m', $month);
                            echo $monthName = $dateObj->format('F'); // March; 
                            ?>
                        </label>

                    </div>
                </div>

            </div>


            <div class="panel-body col-md-6">

                <div class="attendence_top no-print">

                    <form method="post" action="attendence/staffAttendenceDetails">
                        <div class="form-group">
                            <label for="exampleInputEmail1">  <?php echo lang('select'); ?>  <?php echo lang('year'); ?> </label>
                            <select class="form-control" name="year" id=""> 

                                <?php
                                for ($i = 0; $i < 50; $i++) {
                                    $cur_year = date('Y');
                                    $cur_year = $cur_year - $i;
                                    ?>
                                    <option value="<?php echo $cur_year; ?>">
                                        <?php echo $cur_year; ?>
                                    <option>
                                        <?php
                                    }
                                    ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">  <?php echo lang('select'); ?>  <?php echo lang('year'); ?> </label>
                            <select class="form-control" name="month" id=""> 
                                <?php
                                for ($j = 1; $j <= 12; $j++) {
                                    $dateObj = DateTime::createFromFormat('!m', $j);
                                    $monthName = $dateObj->format('F'); // March 
                                    ?>
                                    <option value="<?php echo $j; ?>">
                                        <?php echo $monthName; ?>
                                    <option>
                                        <?php
                                    }
                                    ?>

                            </select>
                        </div>
                        <input type="hidden" name="staff_type" value="<?php echo $staff_type; ?>">
                        <input type="hidden" name="user" value="<?php echo $user; ?>">
                        <button type="submit" name="submit" value="" class="btn btn-info"> <?php echo lang('change'); ?> <?php echo lang('date'); ?></button>
                    </form>



                </div>

                <button class="export no-print" onclick="javascript:window.print();">Print</button> 

            </div>

            <footer class="site-footer col-md-12">
                <div class="text-center">
                    <?php echo lang('attendence') ?> <?php echo lang('report') ?>

                </div>
            </footer>

            <table class="table table-striped table-hover table-bordered" id="">
                <thead>
                    <tr>
                        <th> <?php echo lang('date'); ?></th>
                        <th> <?php echo lang('sign_in_time'); ?></th>
                        <th> <?php echo lang('sign_out_time'); ?></th>
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
                foreach ($all_dates as $key => $value) {
                    ?>
                    <tr class="">
                        <td> <?php echo $value; ?></td>
                        <td>
                            <?php
                            foreach ($logs as $log) {
                                if ($value == date('d-m-Y', $log->sign_in_time)) {
                                    echo date('H:i', $log->sign_in_time);
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($logs as $log) {
                                if ($value == date('d-m-Y', (int) $log->sign_out_time)) {
                                    echo date('H:i', $log->sign_out_time);
                                }
                            }
                            ?>
                        </td>
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
