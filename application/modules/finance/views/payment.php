<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('all'); ?> <?php echo lang('payments'); ?> 
                <div class="clearfix search_row col-md-4 pull-right">
                    <a href="finance/addPaymentView">
                        <div class="btn-group pull-right">
                            <button class="btn-xs btn-info green">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_payment'); ?>
                            </button>
                        </div>
                    </a>
                </div>
            </header>

            <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>

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
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('invoice_id'); ?> </th>
                                <th> <?php echo lang('student'); ?> </th>
                                <th> <?php echo lang('student'); ?> <?php echo lang('id'); ?> </th>
                                <th> <?php echo lang('date'); ?> </th>
                                <th> <?php echo lang('sub_total'); ?> </th>
                                <th> <?php echo lang('discount'); ?> </th>
                                <th> <?php echo lang('grand_total'); ?> </th>
                                <th> TDS </th>
                                <th> Final Amount </th>
                                <th> Next Payment Date </th>
                                <th class="option_th"> <?php echo lang('options'); ?> </th>
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
                            .option_th{
                                width:18%;
                            }

                        </style>

                        <!--<?php foreach ($payments as $payment) { ?>
                            <?php $student_info = $this->db->get_where('student', array('id' => $payment->student))->row(); ?>

                            <tr class="">
                                <td><?php echo $payment->id; ?> </td>
                                <td><?php echo $student_info->name; ?></td>
                                <td><?php echo $student_info->id; ?></td>
                                <td><?php echo date($date_format, $payment->date + 11 * 60 * 60); ?></td>
                                <td><?php echo $settings->currency; ?> <?php echo number_format($payment->amount, 2, '.', ','); ?></td>              
                                <td><?php echo $settings->currency; ?> <?php
                                    if (!empty($payment->discount)) {
                                        echo number_format($payment->discount, 2, '.', ',');
                                    } else {
                                        echo '0';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $settings->currency; ?> <?php echo number_format($payment->gross_total, 2, '.', ','); ?></td>
                                <td> 

                                    <a class="btn btn-xs invoicebutton width_auto" style="color: #fff;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-text"></i>  <?php echo lang('invoice'); ?></a>
                                    <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                        <a class="btn btn-info btn-xs delete_button width_auto" href="finance/delete?id=<?php echo $payment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i>  <?php echo lang('delete'); ?></a>
                                    <?php } ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>-->
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




<script src="common/js/codearistos.min.js"></script>

<script>
                                        $(document).ready(function () {
                                            var table = $('#editable-sample').DataTable({
                                                responsive: true,
                                                "processing": true,
                                                    "serverSide": true,
                                                    "searchable": true,
                                                    "ajax":{
                                                        url: 'finance/getPayment',
                                                        type: 'post'
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
                                                    [10, 25, 50, 100, -1],
                                                    [10, 25, 50, 100, "All"]
                                                ],
                                                iDisplayLength: -1,
                                                "order": [[0, "desc"]],

                                                "language": {
                                                    "lengthMenu": "_MENU_",
                                                    search: "_INPUT_",
                                                    "url": "common/assets/DataTables/languages/english.json"

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