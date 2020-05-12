<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php echo lang('staff'); ?> <?php echo lang('attendence'); ?> <?php echo lang('report'); ?>
            </header>


            <div class="panel-body">
                <form role="form" action="attendence/staffAttendenceDetails" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="attendence_top">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('staff'); ?> <?php echo lang('type'); ?></label>
                            <select class="form-control" name="staff_type" id="acourse"> 

                                <option value="1" data-id="1" > <?php echo lang('instructor'); ?> </option>
                                <option value="2" data-id="2" > <?php echo lang('employee'); ?> </option>

                            </select> 
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('staff'); ?></label>
                            <select class="form-control" name="user" id="abatch"> 

                            </select>
                        </div>
                    </div>



                    <div class="form-group">
                        <button type="submit" name="submit" value="submit" class="btn btn-info pull-right">  <?php echo lang('attendence'); ?> <?php echo lang('report'); ?></button>
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
