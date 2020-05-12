<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-tasks"></i>    <?php echo lang('open'); ?>  <?php echo lang('tasks'); ?>
                <div class="col-md-6 pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group">
                            <button id="" class="btn-xs green">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_task'); ?>
                            </button>
                        </div>
                    </a>
                    <a href="task">
                        <div class="btn-group">
                            <button id="" class="btn-xs green">
                                <i class="fa fa-tasks"></i> <?php echo lang('all'); ?> <?php echo lang('tasks'); ?>
                            </button>
                        </div>
                    </a>
                    <a>
                        <div class="btn-group">
                            <button id="" class="btn-xs">
                                <i class="fa fa-tasks"></i> <?php echo lang('open'); ?> <?php echo lang('tasks'); ?>
                            </button>
                        </div>
                    </a>
                    <a href="task/done">
                        <div class="btn-group">
                            <button id="" class="btn-xs green">
                                <i class="fa fa-tasks"></i> <?php echo lang('done'); ?> <?php echo lang('tasks'); ?>
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
                                <th> <?php echo lang('status'); ?></th>
                                <th> <?php echo lang('date'); ?></th>
                                <th> <?php echo lang('requested_by'); ?></th>
                                <th> <?php echo lang('requested_for'); ?></th>
                                <th> <?php echo lang('task'); ?></th>
                                <th> <?php echo lang('timeline'); ?></th>
                                <th> <?php echo lang('report'); ?></th>  
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

                            .load{
                                float: right !important;
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






<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_task'); ?></h4> 
            </div>
            <div class="modal-body clearfix">
                <form role="form" action="task/addNewTask" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('requested_by'); ?></label>
                        <select class="form-control" name="requested_by" value=''> 
                            <?php
                            if (!$this->ion_auth->in_group(array('admin'))) {
                                foreach ($employees as $employee) {
                                    if ($current_user == $employee->ion_user_id) {
                                        ?>
                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                        if (!empty($task->requested_by)) {
                                            if ($task->requested_by == $employee->ion_user_id) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> >
                                            <?php echo $employee->name; ?> </option>
                                        <?php
                                    }
                                }
                            } else {
                                foreach ($employees as $employee) {
                                    ?>
                                    <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                    if (!empty($task->requested_by)) {
                                        if ($task->requested_by == $employee->ion_user_id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> >
                                        <?php echo $employee->name; ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('requested_for'); ?></label>
                        <select class="form-control" name="requested_for" value=''> 
                            <?php
                            if (!$this->ion_auth->in_group(array('admin'))) {
                                foreach ($employees as $employee) {
                                    if ($current_user != $employee->ion_user_id) {
                                        ?>
                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                        if (!empty($task->requested_for)) {
                                            if ($task->requested_for == $employee->ion_user_id) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> >
                                            <?php echo $employee->name; ?> </option>
                                        <?php
                                    }
                                }
                            } else {
                                foreach ($employees as $employee) {
                                    ?>
                                    <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                    if (!empty($task->requested_for)) {
                                        if ($task->requested_for == $employee->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> >
                                        <?php echo $employee->name; ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label class="control-label"><?php echo lang('task'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="to_do" value="" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('timeline'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="timeline" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?> </label>
                        <select class="form-control" name="status"> 

                            <option value="1"  <?php
                            if (!empty($task->status)) {
                                if ($task->status == 1) {
                                    echo 'selected';
                                }
                            }
                            ?> ><?php echo lang('open'); ?> 
                            </option>
                            <option value="2"  <?php
                            if (!empty($task->status)) {
                                if ($task->status == 2) {
                                    echo 'selected';
                                }
                            }
                            ?> ><?php echo lang('completed'); ?> 
                            </option>

                        </select> 
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
<!-- Add Accountant Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_task'); ?></h4>
            </div>
            <div class="modal-body clearfix"> 
                <form role="form" action="task/addNewTask" id="editTaskForm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('requested_by'); ?></label>
                        <select class="form-control" name="requested_by" value=''> 
                            <?php
                            if (!$this->ion_auth->in_group(array('admin'))) {
                                foreach ($employees as $employee) {
                                    if ($current_user == $employee->ion_user_id) {
                                        ?>
                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                        if (!empty($task->requested_by)) {
                                            if ($task->requested_by == $employee->ion_user_id) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> >
                                            <?php echo $employee->name; ?> </option>
                                        <?php
                                    }
                                }
                            } else {
                                foreach ($employees as $employee) {
                                    ?>
                                    <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                    if (!empty($task->requested_by)) {
                                        if ($task->requested_by == $employee->ion_user_id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> >
                                        <?php echo $employee->name; ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('requested_for'); ?></label>
                        <select class="form-control" name="requested_for" value=''> 
                            <?php
                            if (!$this->ion_auth->in_group(array('admin'))) {
                                foreach ($employees as $employee) {
                                    if ($current_user != $employee->ion_user_id) {
                                        ?>
                                        <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                        if (!empty($task->requested_for)) {
                                            if ($task->requested_for == $employee->ion_user_id) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> >
                                            <?php echo $employee->name; ?> </option>
                                        <?php
                                    }
                                }
                            } else {
                                foreach ($employees as $employee) {
                                    ?>
                                    <option value="<?php echo $employee->ion_user_id; ?>" <?php
                                    if (!empty($task->requested_for)) {
                                        if ($task->requested_for == $employee->id) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> >
                                        <?php echo $employee->name; ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label class="control-label"><?php echo lang('task'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" id="editor" name="to_do" value="" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('timeline'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="timeline" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('status'); ?> </label>
                        <select class="form-control" name="status"> 

                            <option value="1"  <?php
                            if (!empty($task->status)) {
                                if ($task->status == 1) {
                                    echo 'selected';
                                }
                            }
                            ?> ><?php echo lang('open'); ?> 
                            </option>
                            <option value="2"  <?php
                            if (!empty($task->status)) {
                                if ($task->status == 2) {
                                    echo 'selected';
                                }
                            }
                            ?> ><?php echo lang('completed'); ?> 
                            </option>

                        </select> 
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





<!-- Add Task Report-->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_report'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" action="task/addReport" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label"> <?php echo lang('report'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="to_do_report" value="<?php
                            if (!empty($task->to_do_report)) {
                                echo $task->to_do_report;
                            }
                            ?>" rows="10">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->






<!-- See The Task -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-tasks"></i>  <?php echo lang('task'); ?></h4>
            </div>
            <div class="modal-body task">


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Task -->






<!-- See The Task Report -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-file-text"></i>   <?php echo lang('task'); ?>  <?php echo lang('report'); ?> </h4>
            </div>
            <div class="modal-body task_report">


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Task -->






<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {
            //   e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editTaskForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'task/editTaskByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editTaskForm').find('[name="id"]').val(response.task.id).end()
                $('#editTaskForm').find('[name="date"]').val(response.task.date).end()
                $('#editTaskForm').find('[name="requested_by"]').val(response.task.requested_by).end()
                $('#editTaskForm').find('[name="requested_for"]').val(response.task.requested_for).end()
                $('#editTaskForm').find('[name="to_do"]').val(response.task.to_do).end()
                $('#editTaskForm').find('[name="timeline"]').val(response.task.timeline).end()
                $('#editTaskForm').find('[name="to_do_report"]').val(response.task.to_do_report).end()
                $('#editTaskForm').find('[name="status"]').val(response.task.status).end()
                CKEDITOR.instances['editor'].setData(response.task.to_do)
                CKEDITOR.instances['editor1'].setData(response.task.to_do_report)
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
                url: "task/getOpenTaskList",
                type: 'POST',
                data: {'open': '1'}
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
                        columns: [0, 1, 2, 3, 5],
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



<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".see_to_do", function () {

            //   e.preventDefault(e);
            $(".task").html("");
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal3').modal('show');
            $.ajax({
                url: 'task/editTaskByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var task = response.task.to_do;
                $(".task").append(task);
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".see_to_do_report", function () {

            // e.preventDefault(e);
            $(".task_report").html("");
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal4').modal('show');
            $.ajax({
                url: 'task/editTaskByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json'
            }).success(function (response) {
                var task_report = response.task.to_do_report;
                $(".task_report").append(task_report);
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".addreport", function () {
            // e.preventDefault(e);
            $('#addReportForm').trigger("reset");
            ;
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal5').modal('show');

            $('#addReportForm').find('[name="task_id"]').val(iid).end()

        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

