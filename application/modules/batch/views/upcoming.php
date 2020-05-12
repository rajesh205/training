<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('upcoming'); ?>  <?php echo lang('batches'); ?>

                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="add_new" class="btn-xs green">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_batch'); ?>
                            </button>
                        </div>
                    </a>
                </div> 
            </header>
            <style>

            </style>
            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>

                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> <?php echo lang('batch_id'); ?></th>
                                <th> <?php echo lang('course'); ?></th>
                                <th> <?php echo lang('instructor'); ?></th>
                                <th> <?php echo lang('start_date'); ?></th>
                                <th> <?php echo lang('end_date'); ?></th>
                                <th> <?php echo lang('students'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <th class="no-print"> <?php echo lang('options'); ?></th>
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

                        </tbody>
                    </table>

                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Batch Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_batch'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="batch/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                        <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label><br>
                        <select class="form-control" id='selUser1' name="course" style="width: 100% !important;">
                         <!--   <option value='0'><?php //echo lang('select_course');         ?></option>-->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('instructor'); ?></label><br>
                        <select class="form-control" id='selUser2' name="instructor" style="width: 100% !important;">
                        <!--   <option value='0'><?php //echo lang('select_course');         ?></option>-->
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="start_date" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Batch Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_batch'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editBatchForm" class="clearfix" action="batch/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch_id'); ?></label>
                        <input type="text" class="form-control" name="batch_id" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?></label><br>
                        <select class="form-control" id='selUser3' name="course" style="width: 100% !important;">
                        <!--   <option value='0'><?php //echo lang('select_course');         ?></option>-->
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('instructor'); ?></label>
                        <select class="form-control" id='selUser4' name="instructor" style="width: 100% !important;">
                       <!--   <option value='0'><?php //echo lang('select_course');         ?></option>-->
                        </select>


                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="start_date" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="end_date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course_fee'); ?></label>
                        <input type="text" class="form-control" name="course_fee" id="exampleInputEmail1" placeholder="">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {
            //  e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editBatchForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'batch/editBatchByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // console.log(response.courses.course_id);
                var start = response.batch.start_date * 1000;
                var end = response.batch.end_date * 1000;
                var d_s = new Date(start);
                var d_e = new Date(end);
<?php
$date_format = $settings->date_format;
if ($date_format == 1) {
    ?>
                    var da_start = d_s.getDate() + '-' + (d_s.getMonth() + 1) + '-' + d_s.getFullYear();
                    var da_end = d_e.getDate() + '-' + (d_e.getMonth() + 1) + '-' + d_e.getFullYear();
<?php } else {
    ?>
                    var da_start = (d_s.getMonth() + 1) + '/' + d_s.getDate() + '/' + d_s.getFullYear();
                    var da_end = (d_e.getMonth() + 1) + '/' + d_e.getDate() + '/' + d_e.getFullYear();
<?php } ?>



                // Populate the form fields with the data returned from server
                $('#editBatchForm').find('[name="id"]').val(response.batch.id).end()
                $('#editBatchForm').find('[name="batch_id"]').val(response.batch.batch_id).end()
                $('#editBatchForm').find('[name="course_fee"]').val(response.batch.course_fee).end()
                // $('#editBatchForm').find('[name="instructor"]').val(response.batch.instructor).end()
                $('#editBatchForm').find('[name="start_date"]').val(da_start).end()
                $('#editBatchForm').find('[name="end_date"]').val(da_end).end()

                var option = new Option(response.batch.coursename + '-' + response.courses.course_id, response.courses.id, true, true);
                $('#editBatchForm').find('[name="course"]').append(option).trigger('change');
                var option1 = new Option(response.batch.instructorname + '-' + response.batch.instructor, response.batch.instructor, true, true);
                $('#editBatchForm').find('[name="instructor"]').append(option1).trigger('change');
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
<script>
    $(document).ready(function () {
        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_course'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getCourseList',
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
        $("#selUser3").select2({
            placeholder: '<?php echo lang('select_course'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getCourseList',
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
        $("#selUser2").select2({
            placeholder: '<?php echo lang('select_instructor'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getInstructorinfo',
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
        $("#selUser4").select2({
            placeholder: '<?php echo lang('select_instructor'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getInstructorinfo',
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
    });
</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "batch/getUpcomingBatchList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
            ],
            aLengthMenu: [
                [1, 2, 50, 100, -1],
                [1, 2, 50, 100, "All"]
            ],
            iDisplayLength: 100,
            "order": [[0, "desc"]],
            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },
        });
        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script>