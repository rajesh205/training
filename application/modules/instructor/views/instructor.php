<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('instructor'); ?>
                <div class="clearfix search_row col-md-4 pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button class="btn-xs green">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_instructor'); ?>
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
                                <th></th>
                                <th> <?php echo lang('image'); ?></th>
                                <th> <?php echo lang('name'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                
                                <th> Technology </th>
                                <th> Experiance </th>
                                <th> Expected Amount</th>
                                <th> <?php echo lang('status'); ?></th>
                                <th> Feedback </th>
                                <th> Skill </th>
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




<!-- Add Instructor Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_instructor'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" action="instructor/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value=''>
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
                        <label for="exampleInputEmail1"> Technology</label>
                        <input type="text" class="form-control" name="technology" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Experiance</label>
                        <input type="text" class="form-control" name="experiance" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Expected Amount</label>
                        <input type="text" class="form-control" name="expected_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Skill</label>
                        <input type="text" class="form-control" name="skill" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Status</label>
                        <select  class="form-control" name="status" id="exampleInputEmail1"  >
                                    <option value="0">Select Status</option>
                                    <option value="1" <?php (!empty($instructor->status) && $instructor->status== 1 ? "selected":"")?>>Active</option>
                                    <option value="-1" <?php (!empty($instructor->status) && $instructor->status== -1 ? "selected":"")?>>In Active</option>
                                </select>
                    </div>
                    <div class="alert-warning">
                                <p> Bank Details of Instructor</p>
                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="bank_name" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->bank_name)) {
                                    echo $instructor->bank_name;
                                }
                                if (!empty($setval)) {
                                    echo set_value('bank_name');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->ifsc_code)) {
                                    echo $instructor->ifsc_code;
                                }
                                if (!empty($setval)) {
                                    echo set_value('ifsc_code');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank Account Number</label>
                                <input type="text" class="form-control" name="bank_account" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->bank_account)) {
                                    echo $instructor->bank_account;
                                }
                                if (!empty($setval)) {
                                    echo set_value('bank_account');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Account Holder Name</label>
                                <input type="text" class="form-control" name="holder_name" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->holder_name)) {
                                    echo $instructor->holder_name;
                                }
                                if (!empty($setval)) {
                                    echo set_value('holder_name');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Type of Instructor</label>
                                <input type="text" class="form-control" name="type" placeholder="Support/Trainer or Trainer,Support">

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
<!-- Add Instructor Modal-->



<div class="modal fade" id="bankDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  Bank Details</h4>
            </div>
            <div class="modal-body clearfix">
                <table class="table table-bordered">
                    <tr>
                        <th>
                            Bank Name
                        </th>
                        <th>
                            Bank Account
                        </th>
                        <th>
                            Bank IFSC CODE
                        </th>
                        <th>
                            Account Holder Name
                        </th>
                    </tr>
                    <tbody class="details"></tbody>
                </table> 
            </div>
        </div>
    </div>
</div>



<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_instructor'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form" id="editInstructorForm" action="instructor/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
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
                        <label for="exampleInputEmail1"> Technology</label>
                        <input type="text" class="form-control" name="technology" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Experiance</label>
                        <input type="text" class="form-control" name="experiance" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Expected Amount</label>
                        <input type="text" class="form-control" name="expected_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Skill</label>
                        <input type="text" class="form-control" name="skill" id="exampleInputEmail1" value='' placeholder="">
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
                    <div class="alert-warning">
                                <p> Bank Details of Instructor</p>
                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="bank_name" id="exampleInputEmail1" value='' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" id="exampleInputEmail1" value='' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank Account Number</label>
                                <input type="text" class="form-control" name="bank_account" id="exampleInputEmail1" value='' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Account Holder Name</label>
                                <input type="text" class="form-control" name="holder_name" id="exampleInputEmail1" value='' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Type of Instructor</label>
                                <input type="text" class="form-control" name="type" placeholder="Support/Trainer or Trainer,Support">

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
            //     e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editInstructorForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'instructor/editInstructorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editInstructorForm').find('[name="id"]').val(response.instructor.id).end()
                $('#editInstructorForm').find('[name="name"]').val(response.instructor.name).end()
                $('#editInstructorForm').find('[name="password"]').val(response.instructor.password).end()
                $('#editInstructorForm').find('[name="email"]').val(response.instructor.email).end()
                $('#editInstructorForm').find('[name="address"]').val(response.instructor.address).end()
                $('#editInstructorForm').find('[name="phone"]').val(response.instructor.phone).end()
                $('#editInstructorForm').find('[name="technology"]').val(response.instructor.technology).end()
                $('#editInstructorForm').find('[name="experiance"]').val(response.instructor.experiance).end()
                $('#editInstructorForm').find('[name="expected_amount"]').val(response.instructor.expected_amount).end()
                $('#editInstructorForm').find('[name="status"]').val(response.instructor.status).end()
                $('#editInstructorForm').find('[name="feedback"]').val(response.instructor.feedback).end()
                $('#editInstructorForm').find('[name="bank_name"]').val(response.instructor.bank_name).end()
                $('#editInstructorForm').find('[name="bank_account"]').val(response.instructor.bank_account).end()
                $('#editInstructorForm').find('[name="ifsc_code"]').val(response.instructor.ifsc_code).end()
                $('#editInstructorForm').find('[name="holder_name"]').val(response.instructor.holder_name).end()
                $('#editInstructorForm').find('[name="skill"]').val(response.instructor.skill).end()
                $('#editInstructorForm').find('[name="type"]').val(response.instructor.type).end()
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
                url: "instructor/getInstructorList",
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
                        columns: [1, 2, 3, 4],
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
        $(".editbutton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editInstructorForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'instructor/editInstructorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editInstructorForm').find('[name="id"]').val(response.instructor.id).end()
                $('#editInstructorForm').find('[name="name"]').val(response.instructor.name).end()
                $('#editInstructorForm').find('[name="password"]').val(response.instructor.password).end()
                $('#editInstructorForm').find('[name="email"]').val(response.instructor.email).end()
                $('#editInstructorForm').find('[name="address"]').val(response.instructor.address).end()
                $('#editInstructorForm').find('[name="phone"]').val(response.instructor.phone).end()
            });
        });
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
        $(".flashmessage").delay(3000).fadeOut(100);
        $(".table").on("click",".bankdetails", function() {
            $.ajax({
                url:'instructor/getBankDetails',
                type:'post',
                data:'instructor='+$(this).attr('data-id'),
                dataType:'json',
            }).success(function (response) {
                console.log(response);
                $("#bankDetails").modal("show");
               td = '<tr><td>'+(response.bank_name == null ? '--' : response.bank_name)+'</td><td>'+(response.bank_account == null ? '--' : response.bank_account)+'</td><td>'+(response.ifsc_code == null ? '--' : response.ifsc_code)+'</td><td>'+(response.holder_name == null ? '--' : response.holder_name)+'</td></tr>'; 
               $(".details").html(td);
            });
        })
    });
</script>
