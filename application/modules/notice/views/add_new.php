<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-user"></i>  <?php
                if (!empty($notice->notice)) {
                    echo lang('edit_notice');
                } else {
                    echo lang('add_notice');
                }
                ?>
            </header>


            <div class="panel-body">
                <form role="form" action="notice/addNew" method="post" enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                        if (!empty($notice->title)) {
                            echo $notice->title;
                        } if (!empty($setval)) {
                            echo set_value('title');
                        }
                        ?>' placeholder="">

                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="description" value="<?php
                            if (!empty($notice->description)) {
                                echo $notice->description;
                            }if (!empty($setval)) {
                                echo set_value('description');
                            }
                            ?>" rows="10"></textarea>
                        </div>
                    </div>


                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('next'); ?></button>

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
