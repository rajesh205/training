<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($attendence->attendence)) {
                    echo lang('edit_payment');
                } else {
                    echo lang('add_payment');
                }
                ?>
            </header>


            <div class="panel-body">
                <form id="paymentForm" role="form" action="finance/addPayment" method="post">
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> Invoce ID</label>
                            <input type="text" class="form-control" name="invoice_id" id="exampleInputEmail1" value='' placeholder="Invoce ID">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('course'); ?></label>
                            <select class="form-control select2" name="course" id="acourse"> 
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?php echo $course->id; ?>" data-id="<?php echo $course->id; ?>" <?php
                                    if (!empty($attendence->attendence)) {
                                        if ($course->id == $attendence->course) {
                                            echo 'selected';
                                        }
                                    }
                                    ?> ><?php echo $course->name; ?> 
                                    </option>
                                <?php } ?>
                            </select> 
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('batch'); ?></label>
                            <select class="form-control select2" name="batch_id" id="abatch"> 
                                <option value="none">select ---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('select'); ?> <?php echo lang('student'); ?></label>
                            <select class="form-control select2" name="student" id="astudent"> 
                                <option value="none">select ---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('Due'); ?> <?php echo lang('amount'); ?></label>
                            <input type="text" class="form-control" name="amount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo lang('discount'); ?></label>
                            <input type="text" class="form-control" name="discount" id="exampleInputEmail1" value='' placeholder="<?php echo $settings->currency; ?>">
                        </div>
                        <div class="form-group">
                                <label for="exampleInputEmail1"> Next Payment Date </label>
                                <input type="text" class="form-control default-date-picker" name="next_payment_date" id="exampleInputEmail1" placeholder="">
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> TDS Apply </label>
                            <select class="form-control ptype" id="tds" name="tds">
                                <option value="0">0</option>
                                <option value="10">10</option>
                            </select>
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
                    </div>
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
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="common/js/ajaxrequest-codearistos.min.js"></script>
<script type="text/javascript">
                                    $(document).ready(function () {
                                        $('.select2').select2({
                                        });
                                        $('#acourse').on('change', function () {
                                            // Get the record's ID via attribute                 
                                            var iid = $(this).find(':selected').data('id');
                                            $('#abatch').find('option').remove();
                                            $('#abatch').append($('<option>').text('Select --- '));
                                            $.ajax({
                                                url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                var batchs = response.batches;
                                                $.each(batchs, function (key, value) {
                                                    $('#abatch').append($('<option>').attr('data-id', value.id).text(value.batch_id).val(value.id)).end();
                                                });
                                            });
                                        });
                                    });

                                    $(document).ready(function () {
                                        // Get the record's ID via attribute                 
                                        var iid = $(this).find(':selected').data('id');
                                        $('#abatch').find('option').remove();
                                        $('#abatch').append($('<option>').text('Select --- '));
                                        $.ajax({
                                            url: 'batch/getBatchByCourseIdByJason?id=' + iid,
                                            method: 'GET',
                                            data: '',
                                            dataType: 'json',
                                        }).success(function (response) {
                                            var batchs = response.batches;
                                            $.each(batchs, function (key, value) {
                                                $('#abatch').append($('<option>').attr('data-id', value.id).text(value.batch_id).val(value.id)).end();
                                            });
                                        });
                                    });

                                    $(document).ready(function () {
                                        $('#abatch').on('change', function () {
                                            // Get the record's ID via attribute                 
                                            var iid = $(this).find(':selected').data('id');
                                            $('#astudent').find('option').remove();
                                            $('#astudent').append($('<option>').text('Select --- '));
                                            $.ajax({
                                                url: 'batch/getStudentsByBatchIdByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                var student = response.students;
                                                $.each(student, function (key, value) {
                                                    $('#astudent').append($('<option>').text(value.name).val(value.id)).end();
                                                });
                                            });
                                        });
                                    });


                                    $(document).ready(function () {
                                        // Get the record's ID via attribute                 
                                        var iid = $(this).find(':selected').data('id');
                                        $('#astudent').find('option').remove();
                                        $('#astudent').append($('<option>').text('Select --- '));
                                        $.ajax({
                                            url: 'batch/getStudentsByBatchIdByJason?id=' + iid,
                                            method: 'GET',
                                            data: '',
                                            dataType: 'json',
                                        }).success(function (response) {
                                            var student = response.students;
                                            $.each(student, function (key, value) {
                                                $('#astudent').append($('<option>').text(value.name).val(value.id)).end();
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
