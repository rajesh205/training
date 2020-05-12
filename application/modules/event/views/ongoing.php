<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-calendar"></i>  <?php echo lang('ongoing'); ?> <?php echo lang('events'); ?>
                <div class="clearfix search_row col-md-6 pull-right">
                        <a data-toggle="modal" href="#myModal">
                            <div class="btn-group">
                                <button class="btn-xs green">
                                    <i class="fa fa-plus-circle"></i>  <?php echo lang('add_event'); ?>
                                </button>
                            </div>
                        </a>
                         <a href="event">
                            <div class="btn-group">
                                <button class="btn-xs green">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('all'); ?> <?php echo lang('events'); ?>
                                </button>
                            </div>
                        </a>
                        <a>
                            <div class="btn-group">
                                <button class="btn-xs">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('ongoing'); ?>
                                </button>
                            </div>
                        </a>
                         <a href="event/upcoming">
                            <div class="btn-group">
                                <button class="btn-xs green">
                                    <i class="fa fa-calendar"></i>  <?php echo lang('upcoming'); ?>
                                </button>
                            </div>
                        </a> 
                    </div>
            </header>
            <style>

                .editable-table .search_form{
                    border: 0px solid #ccc !important;
                    padding: 0px !important;
                    background: none !important;
                    float: right;
                    margin-right: 14px !important;
                }


                .editable-table .search_form input{
                    padding: 6px !important;
                    width: 250px !important;
                    background: #fff !important;
                    border-radius: none !important;
                }

                .editable-table .search_row{
                    margin-bottom: 20px !important;
                }

                .panel-body {
                    padding: 15px 0px 15px 0px;
                    background: transparent;
                }

            </style>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    
                   
                    <table class="table table-striped table-hover table-bordered" id="editable-sample1">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> <?php echo lang('title'); ?></th>
                                <th> <?php echo lang('start'); ?></th>
                                <th> <?php echo lang('end'); ?></th>
                                <th> <?php echo lang('status'); ?></th>

                                <th> <?php echo lang('options'); ?></th>
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




<!-- Add Event Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_event'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" action="event/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="start" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="end" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
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
<!-- Add Event Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_event'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" id="editEventForm" action="event/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                    if (!empty($event->title)) {
                        echo $event->title;
                    }
                    ?>' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="start" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('end'); ?></label>
                        <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                            <input type="text" class="form-control" name="end" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
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
                                        //    e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            var iid = $(this).attr('data-id');
                                            $('#editEventForm').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'event/editEventByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editEventForm').find('[name="id"]').val(response.event.id).end()
                                                $('#editEventForm').find('[name="title"]').val(response.event.title).end()
                                                $('#editEventForm').find('[name="start"]').val(response.event.start).end()
                                                $('#editEventForm').find('[name="end"]').val(response.event.end).end()
                                            });
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
                                                url: "event/getOngoingEventList",
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
                                                        columns: [0, 1, 2, 3, 4],
                                                    }
                                                },
                                            ],
                                            aLengthMenu: [
                                                [10, 25, 50, 100, -1],
                                                [10, 25, 50, 100, "All"]
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


<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
