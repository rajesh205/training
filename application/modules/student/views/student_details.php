<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-user"></i>  <?php echo $student_details->name; ?>
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
            <div class="col-md-3">
                <section class="panel post-wrap col-md-12">
                    <aside>
                        <div class="post-info">
                            <span class="arrow-pro right"></span>
                            <div class="panel-body">
                                <h1><strong><?php echo lang('student_details'); ?> </strong></h1>
                                <div class="desk yellow">
                                    <h3><?php echo lang('name'); ?> </h3>  <?php echo $student_details->name; ?>
                                    <h3><?php echo lang('phone'); ?> </h3> <?php echo $student_details->phone; ?>
                                    <h3><?php echo lang('email'); ?> </h3> <?php echo $student_details->email; ?>
                                    <h3><?php echo lang('registration_date'); ?> </h3> <?php echo date($date_format, $student_details->add_date); ?>
                                    <h3><?php echo lang('registration_id'); ?> </h3> <?php echo $student_details->id; ?>
                                    <h3><?php echo lang('address'); ?> </h3> <?php echo $student_details->address; ?>
                                </div>
                            </div>
                        </div>
                    </aside>
                </section>
            </div>

            <div class="panel-body col-md-9">
                <div class="adv-table editable-table ">

                    <header class="panel-heading">

                        <?php echo lang('courses'); ?>

                    </header>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('course'); ?></th>
                                <th> <?php echo lang('batch'); ?></th>
                                <th> <?php echo lang('instructor'); ?></th>
                                <th> <?php echo lang('start_date'); ?></th>
                                <th> <?php echo lang('end_date'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
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
                        foreach ($batches as $key => $value) {
                            $batch = $this->batch_model->getBatchById($value)
                            ?>
                            <tr class="">
                                <td> <?php echo $this->course_model->getCourseById($batch->course)->name; ?></td>
                                <td><?php echo $batch->batch_id; ?></td>
                                <td class="center"><?php echo $this->instructor_model->getInstructorById($batch->instructor)->name; ?></td>
                                <td><?php echo date($date_format, $batch->start_date); ?></td>
                                <td><?php echo date($date_format, $batch->end_date); ?></td>
                                <td>
                                    <?php
                                    if (time() < $batch->start_date) {
                                        echo lang('upcoming');
                                    }
                                    if ((time() > $batch->start_date) && (time() < $batch->end_date)) {
                                        echo lang('running');
                                    }
                                    if (time() > $batch->end_date) {
                                        echo lang('completed');
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>


                    <section class="panel-body"></section>





                    <?php if (!$this->ion_auth->in_group(array('Student'))) { ?>
                        <?php if (!empty($batches)) { ?>
                            <button type="button" class="btn btn-info btn-xs btn_width add_payment" href="#myModal" data-toggle="modal" data-id=""><i class="fa fa-plus-circle"></i> <?php echo lang('add_payment'); ?></button>  <br> 
                        <?php } ?>
                    <?php } ?>
                    <header class="panel-heading">
                        <div class="">  <?php echo lang('payments'); ?> </div>
                    </header>
                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th> <?php echo lang('course'); ?> -  <?php echo lang('batch'); ?></th>
                                <th> <?php echo lang('course_fee'); ?></th>
                                <th> <?php echo lang('discount'); ?></th>
                                <th> <?php echo lang('receivable'); ?></th>
                                <th> <?php echo lang('received'); ?></th>
                                <th> <?php echo lang('due'); ?></th>
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
                        <?php
                        foreach ($batches as $key1 => $value1) {

                            $batch1 = $this->batch_model->getBatchById($value1)
                            ?>
                            <tr class="">
                                <td>
                                    <?php echo $this->course_model->getCourseById($batch1->course)->name; ?> -  <?php
                                    echo $this->batch_model->getBatchById($batch1->id)->batch_id;
                                    ?>
                                </td>
                                <td><?php echo $settings->currency; ?> <?php echo $course_fee = $batch1->course_fee; ?></td>
                                <td class="center"> <?php echo $settings->currency; ?> <?php echo $discount = $this->finance_model->getDiscountByBatchIdByStudentId($batch1->id, $student_details->id) ?></td>
                                <td> <?php echo $settings->currency; ?> <?php echo $amount_receivable = $course_fee - $discount; ?></td>


                                <td class="<?php
                                $amount_received = $this->finance_model->getReceivedAmountByBatchIdByStudentId($batch1->id, $student_details->id);
                                if ($amount_received >= $amount_receivable) {
                                    echo 'sobujbatti';
                                }
                                ?>">  <?php echo $settings->currency; ?> <?php echo $amount_received; ?></td>
                                <td class="<?php
                                $due = $amount_receivable - $amount_received;
                                if ($due > 0) {
                                    echo 'lalbatti';
                                }
                                ?>">  <?php echo $settings->currency; ?>  <?php echo $due; ?> </td>
                                <td> <button type="button" class="btn btn-info btn-xs btn_width viewPayment" href="#modal1" data-toggle="modal" data-batch_id="<?php echo $batch1->id; ?>" data-student_id="<?php echo $student_details->id; ?>"><i class="fa fa-eye"></i> <?php echo lang('view_payments'); ?></button>   </td>
                            </tr>
                        <?php } ?>


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













!-- Add Payment Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_payment'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <form role="form"  id="paymentForm" action="finance/addpaymentFromStudentProfile" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('batch'); ?> - <?php echo lang('course'); ?></label>
                        <select class="form-control" name="batch_course" value=''> 
                            <?php
                            foreach ($batches as $key1 => $value1) {
                                $batch1 = $this->batch_model->getBatchById($value1)
                                ?>
                                <option value="<?php echo $batch1->id; ?>*<?php echo $this->course_model->getCourseById($batch1->course)->id; ?>"><?php echo $batch1->batch_id; ?> - <?php echo $this->course_model->getCourseById($batch1->course)->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('amount'); ?></label>
                        <input type="text" class="form-control" name="amount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('discount'); ?></label>
                        <input type="text" class="form-control" name="discount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('payment') . " " . lang('type'); ?></label>
                        <select class="form-control ptype" id="ptype" name="ptype">
                            <option value="cash"><?php echo lang('cash'); ?></option>
                            <option value="card"><?php echo lang('card'); ?></option>
                        </select>
                    </div>
                       <div class="cardDetails hidden">
                            <?php if ($settings->payment_gateway == 'PayPal') {
                                ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo lang('card') . " " . lang('type'); ?></label>
                                    <select class="form-control" name="cardType">
                                        <option value="Visa"><?php echo lang('visa'); ?></option>
                                        <option value="American Express"><?php echo lang('amex'); ?></option>
                                        <option value="MasterCard"> <?php echo lang('master'); ?></option>
                                    </select>
                                </div>
                            <?php }
                            ?>
                             <?php if ($settings->payment_gateway != 'PayU Money') { ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('cardnumber'); ?></label>
                                <input type="text" class="form-control" id="card" name="card" id="exampleInputEmail1" value='' placeholder="<?php echo lang('entercard'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('expire'); ?></label>
                                <input type="text" class="form-control" id="expire" name="expire" id="exampleInputEmail1" value='' placeholder="<?php echo lang('enterexpire'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?></label>
                                <input type="text" class="form-control" id="cvv" name="cvv" id="exampleInputEmail1" value='' placeholder="<?php echo lang('entercvv'); ?>">
                            </div>
                           <?php }
                            ?>
                        </div>
                    <input type="hidden" name="student_id" value='<?php echo $student_details->id; ?>'>
                      <div class="form-group cashsubmit col-md-12">
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit col-md-12 hidden">
                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                ?>onClick="stripePay(event);"<?php }
                            ?>> <?php echo lang('submit'); ?></button>
                    </div>
                  
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Payment Modal-->


<!--   View Payments Modal  -->

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('view_payments'); ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered" id="editable-sample">
                    <thead>
                        <tr>
                            <th> <?php echo lang('date'); ?> </th>
                            <th> <?php echo lang('amount'); ?> </th>
                            <th> <?php echo lang('discount'); ?> </th>
                            <th> <?php echo lang('gross_total'); ?> </th>
                            <?php if (!$this->ion_auth->in_group(array('Student'))) { ?>
                                <th class="option_th"> <?php echo lang('options'); ?> </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody class="viewP">



                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--   View Payments Modal  -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".viewPayment").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var batch_id = $(this).attr('data-batch_id');
            var student_id = $(this).attr('data-student_id');
            $('.viewP').html("");
            $('#modal1').modal('show');
            $.ajax({
                url: 'finance/getPaymentByBatchIdByStudentIdByJason?batch_id=' + batch_id + '&student_id=' + student_id,
                method: 'GET',
                data: '',
                dataType: 'json'
            }).success(function (response) {
                var all_payments = response.payments;
                $.each(all_payments, function (key, value) {
                    var de = value.date * 1000;
                    var d = new Date(de);
<?php if ($date_format == 1) { ?>
                        var da = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
<?php } else { ?>
                        var da = (d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear();
<?php } ?>
                    var $tr = $('<tr>').append(
                            $('<td>').text(da),
                            $('<td>').text(value.amount),
                            $('<td><strong>').text(value.discount),
                            $('<td>').text(value.gross_total)<?php if (!$this->ion_auth->in_group(array('Student'))) { ?>,
                                $('<td>').html('<a href="finance/delete?id=' + value.id + '" onclick="return confirm("Are you sure you want to remove the item?");" >delete</a>') <?php } ?>
                    );
                            $(".viewP").append($tr);

                });

            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);

        $('#ptype').on('change', function () {
            var type = $('#ptype').val();
            if (type == 'card') {
                $('.cardDetails').removeClass('hidden');
                $('.cardsubmit').removeClass('hidden');
                $('.cashsubmit').addClass('hidden');
            } else {
                $('.cardDetails').addClass('hidden');
                $('.cashsubmit').removeClass('hidden');
                $('.cardsubmit').addClass('hidden');
            }
        })
    });
</script>
<script>
    function cardValidation() {
        var valid = true;
        var cardNumber = $('#card').val();
        var expire = $('#expire').val();
        var cvc = $('#cvv').val();

        $("#error-message").html("").hide();

        if (cardNumber.trim() == "") {
            valid = false;
        }

        if (expire.trim() == "") {
            valid = false;
        }
        if (cvc.trim() == "") {
            valid = false;
        }

        if (valid == false) {
            $("#error-message").html("All Fields are required").show();
        }

        return valid;
    }
//set your publishable key
    Stripe.setPublishableKey("<?php echo $gateway->publish; ?>");

//callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //enable the submit button
            $("#submit-btn").show();
            $("#loader").css("display", "none");
            //display the errors on the form
            $("#error-message").html(response.error.message).show();
        } else {
            //get token id
            var token = response['id'];
            console.log(token);
            //insert the token into the form
            $('#token').val(token);
            $("#paymentForm").append("<input type='hidden' name='token' value='" + token + "' />");
            //submit form to the server
            $("#paymentForm").submit();
        }
    }

    function stripePay(e) {
        e.preventDefault();
        var valid = cardValidation();

        if (valid == true) {
            $("#submit-btn").attr("disabled", true);
            $("#loader").css("display", "inline-block");
            var expire = $('#expire').val()
            var arr = expire.split('/');
            Stripe.createToken({
                number: $('#card').val(),
                cvc: $('#cvv').val(),
                exp_month: arr[0],
                exp_year: arr[1]
            }, stripeResponseHandler);

            //submit from callback
            return false;
        }
    }

</script>

