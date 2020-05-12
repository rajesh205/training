<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('employee'); ?>
                <div class="clearfix search_row col-md-4 pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button class="btn-xs green">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_employee'); ?>
                            </button>
                            
                        </div>
                    </a> 
                    
                        <div class="btn-group pull-right">
                            
                            <button class="btn-xs green" onclick="copyText('emails')">
                                 Copy to Clipboard  
                            </button>
                            <span id="emails" style="display: none"></span>
                        </div>
                           
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
                                <th> </th>
                                <th> <?php echo lang('image'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('designation'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> Salary </th>
                                <th> Incentive </th>
                                <th> Status </th>
                                <th> Feedback </th>
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

<div class="modal fade" id="studentDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Leads of Employee</h4>
            </div>
            <div class="modal-body" id="">
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Technology</th>
                    </tr>
                    <tbody id="studentData">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Add Employee Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_employee'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" action="employee/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value=''>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Salary</label>
                        <input type="text" class="form-control" name="salary" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Incentive</label>
                        <input type="text" class="form-control" name="incentive" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Status</label>
                        <select  class="form-control" name="status" id="exampleInputEmail1"  >
                                    <option value="0">Select Status</option>
                                    <option value="1" <?php (!empty($instructor->status) && $instructor->status== 1 ? "selected":"")?>>Active</option>
                                    <option value="-1" <?php (!empty($instructor->status) && $instructor->status== -1 ? "selected":"")?>>In Active</option>
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
<!-- Add Employee Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_employee'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" id="editEmployeeForm" action="employee/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('designation'); ?></label>
                        <input type="text" class="form-control" name="designation" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Salary</label>
                        <input type="text" class="form-control" name="salary" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Incentive</label>
                        <input type="text" class="form-control" name="incentive" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Status</label>
                        <select  class="form-control" name="status" id="exampleInputEmail1"  >
                                    <option value="0">Select Status</option>
                                    <option value="1" <?php (!empty($instructor->status) && $instructor->status== 1 ? "selected":"")?>>Active</option>
                                    <option value="-1" <?php (!empty($instructor->status) && $instructor->status== -1 ? "selected":"")?>>In Active</option>
                                </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Feedback</label>
                        <textarea class="form-control" name="feedback" id="exampleInputEmail1" value='' placeholder="">
                        </textarea>
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
            //   e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editEmployeeForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'employee/editEmployeeByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editEmployeeForm').find('[name="id"]').val(response.employee.id).end()
                $('#editEmployeeForm').find('[name="name"]').val(response.employee.name).end()
                $('#editEmployeeForm').find('[name="password"]').val(response.employee.password).end()
                $('#editEmployeeForm').find('[name="email"]').val(response.employee.email).end()
                $('#editEmployeeForm').find('[name="address"]').val(response.employee.address).end()
                $('#editEmployeeForm').find('[name="phone"]').val(response.employee.phone).end()
                $('#editEmployeeForm').find('[name="designation"]').val(response.employee.designation).end()
                $('#editEmployeeForm').find('[name="salary"]').val(response.employee.salary).end()
                $('#editEmployeeForm').find('[name="incentive"]').val(response.employee.incentive).end()
                $('#editEmployeeForm').find('[name="status"]').val(response.employee.status).end()
                $('#editEmployeeForm').find('[name="feedback"]').val(response.employee.feedback).end()
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
                url: "employee/getEmployeeList",
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
                       columns: [1, 2, 3, 4, 5],
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
   
    function copyText(elementId){        
        var aux = document.createElement("input");

      // Get the text from the element passed into the input
      aux.setAttribute("value", document.getElementById(elementId).innerHTML);

      // Append the aux input to the body
      document.body.appendChild(aux);

      // Highlight the content
      aux.select();

      // Execute the copy command
      document.execCommand("copy");

      // Remove the input from the body
      document.body.removeChild(aux);
      alert("Copied the data "+document.getElementById(elementId).innerHTML);
    }
    $(document).ready(function () {
        $(".table").on("click",".employee_check",function(){
            var email = $(this).val();
            $('#emails').append($(this).val()+",");
        });

        $(".table").on("click",".employee",function(e) {
            e.preventDefault();
            $.ajax({
                url:'employee/getLeads',
                type:'post',
                data:'employee='+$(this).attr("id"),
                dataType:'json'
            }).success(function (response) {
                 var data = response;
                var td = '';
                $.each(data, function(i, item) {
                    td += "<tr><td>"+data[i].name+"</td><td>"+data[i].technology+"</td></tr>";
                });
                if(response.length == 0) {
                   td += "<tr><td colspan=2 class='alert alert-warning'>No Data Found</td></tr>"; 
                }
                $('#studentDetails').modal('show');
                $("#studentData").html(td);
            })
        })

        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
