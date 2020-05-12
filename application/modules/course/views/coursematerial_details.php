
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">

            <header class="panel-heading">
                <?php echo lang('course'); ?> <?php echo lang('material'); ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="add_new" class="btn-xs green">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?> <?php echo lang('course'); ?> <?php echo lang('material'); ?>
                            </button>
                        </div>
                    </a>
                </div> 

            </header>

            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('course'); ?></th>
                                <th><?php echo lang('title'); ?></th>  
                                <th><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->

<!--  add Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('add_new'); ?> <?php echo lang('course'); ?> <?php echo lang('material'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo validation_errors(); ?>
                <form role="form" name="myform1" class="clearfix" action="course/addCourseMaterial" method="post" enctype="multipart/form-data">                                                                                    
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('name'); ?></label><br>
                        <select class="form-control m-bot15" id='selUser1' name="course" style='width: 100%;'>

                        </select>                 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>
                    
                     <input type="hidden" name="redirect" value='course/courseMaterialDetails'>
                    
                    <input type="hidden" name="id" value=''>
                                        
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    
                    
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Area Modal-->

<!-- Edit sms temp Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('edit'); ?> <?php echo lang('course'); ?> <?php echo lang('material'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo validation_errors(); ?>
                <form role="form" id="smstemp" name="myform" action="course/editCourseMaterialData" method="post" enctype="multipart/form-data">                                                                                    

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('course'); ?> <?php echo lang('name'); ?></label><br>
                        <select class="form-control m-bot15" id='selUser2' name="course" style='width: 100%;'>

                        </select>                 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="" required>
                    </div>

                    <input type="hidden" name="id" value=''>


                    <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('add_to_batch'); ?> </h4>
            </div>
            <div class="modal-body">
                <?php echo validation_errors(); ?>
                <form role="form" id="addbatch" name="myform3" action="course/addbatchMatrial" method="post" enctype="multipart/form-data">                                                                                    

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch'); ?> <?php echo lang('name'); ?></label><br>
                        <select class="form-control m-bot15" id='selUser3' name="batch" style='width: 100%;'>

                        </select>    
                        <input type="hidden" name="materialid" value=''>
                    </div>                                     
                    <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="common/js/codearistos.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton1", function () {
            // e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var type = 'sms';
            $.ajax({
                url: 'course/editCourseMaterial?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#smstemp').find('[name="id"]').val(response.response.id).end();
                $('#smstemp').find('[name="title"]').val(response.response.title).end();
                var option = new Option(response.response.coursename + '-' + response.response.course, response.response.course, true, true);
                $('#smstemp').find('[name="course"]').append(option).trigger('change');
                $('#myModal1').modal('show');
            });
        });
    });</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "course/getCourseMaterialList",
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
                        columns: [0, 1, 2],
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
    });</script>
<script>
    $(document).ready(function () {

        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_course'); ?>',
            allowClear: true,
            ajax: {
                url: 'course/getCourseList',
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
            placeholder: '<?php echo lang('select_course'); ?>',
            allowClear: true,
            ajax: {
                url: 'course/getCourseList',
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
        $(".table").on("click", ".addtobatch", function () {
            var course = $(this).attr('data-course');
            var materialid = $(this).attr('data-id');

            $("#selUser3").select2({
                placeholder: '<?php echo lang('select_course'); ?>',
                allowClear: true,
                ajax: {
                    url: 'course/getBatchListByCourse?course=' + course,
                    type: "get",
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
             $('#addbatch').find('[name="materialid"]').val(materialid).end();
        });
    });</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
