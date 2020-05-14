<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->


        <?php
        $date_format = $settings->date_format;
        if ($date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        ?>


        <section>
            <div class="panel panel-primary">
                <select class="form-control company">
                    <option value="Magistersign">Magistersign</option>
                    <option value="M Gowri">M Gowri</option>
                    <option value="N Mangatayaru">N Mangatayaru</option>

                </select>
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body col-md-6 panel-moree" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <div class="text-center corporate-id">
                            <h3>
                                <span class="vendor"><?php echo $settings->system_vendor ?></span>
                            </h3>
                            <h4>
                                <?php echo $settings->address ?>
                            </h4>
                            <h4>
                                <?php echo $settings->phone ?>
                            </h4>
                            <h4>
                                <?php echo $settings->email; ?>
                            </h4>
                        </div>

                        <div class="col-lg-4 col-sm-4 list_item">
                            <h4> <?php echo lang('payment_to'); ?> :</h4>
                            <p>
                                <span class="vendor"><?php echo $settings->system_vendor; ?></span> <br>
                                <?php echo $settings->address; ?><br>
                                Tel:  <?php echo $settings->phone; ?> <br>
                                <?php echo $settings->email; ?>
                            </p>
                        </div>

                        <div class="col-lg-4 col-sm-4 list_item">
                            <h4> <?php echo lang('bill_to'); ?> </h4>
                            <ul class="unstyled">
                                <li> <?php echo lang('student'); ?> <?php echo lang('name'); ?> :
                                    <?php
                                    if (!empty($payment)) {
                                        echo $student = $this->student_model->getStudentById($payment->student)->name;
                                    }
                                    ?>  
                                </li>
                                <li> <?php echo lang('student'); ?> <?php echo lang('id'); ?> :
                                    <?php
                                    if (!empty($payment)) {
                                        echo $student = $this->student_model->getStudentById($payment->student)->id;
                                    }
                                    ?>  
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-sm-4 list_item">
                            <h4> <?php echo lang('invoice_info'); ?> </h4>
                            <ul class="unstyled">  
                                <li> <?php echo lang('invoice_number'); ?> 		: <strong>00<?php echo $payment->invoice_id; ?></strong></li>
                                <li> <?php echo lang('date'); ?> :<?php echo date($date_format, $payment->date); ?></li>    
                            </ul>
                        </div>
                    </div>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> <?php echo lang('course'); ?> </th>
                                <th> <?php echo lang('batch'); ?> </th>
                                <th> <?php echo lang('amount'); ?> </th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($payment)) { ?>                

                                <tr>
                                    <td class=""> <?php echo $this->course_model->getCourseById($payment->course)->name; ?> </td>
                                    <td class=""><?php echo $this->batch_model->getBatchById($payment->batch)->batch_id; ?> </td>
                                    <td class="">  <?php echo $settings->currency; ?> <?php echo $payment->amount; ?> </td>
                                </tr> 
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li><strong> <?php echo lang('sub_total'); ?>   <?php echo lang('amount'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->amount; ?></li>
                                <?php if (!empty($payment->discount)) { ?>
                                    <li><strong>Discount</strong> <?php
                                        if ($discount_type == 'percentage') {
                                            echo '(%) : ';
                                        } else {
                                            echo ': ' . $settings->currency;
                                        }
                                        ?> <?php
                                        $discount = explode('*', $payment->discount);
                                        if (!empty($discount[1])) {
                                            echo $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                        } else {
                                            echo $discount[0];
                                        }
                                        ?></li>
                                <?php } ?>
                                <li><strong> TDS   <?php echo lang('amount'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->tds; ?></li>
                                <?php if (!empty($payment->vat)) { ?>
                                    <li><strong> <?php echo lang('vat'); ?>  :</strong>   <?php
                                        if (!empty($payment->vat)) {
                                            echo $payment->vat;
                                        } else {
                                            echo '0';
                                        }
                                        ?> % = <?php echo $settings->currency . ' ' . $payment->flat_vat; ?></li>
                                <?php } 
                                $tdsAmount = ($payment->gross_total*$payment->tds)/100;
                                ?>
                                <li><strong> <?php echo lang('grand_total'); ?>  : </strong><?php echo $settings->currency; ?> <?php echo $payment->gross_total-$tdsAmount; ?></li>
                            </ul>
                        </div>
                    </div>


                    <div class="text-center invoice-btn">
                        <a class="btn btn-info btn-lg invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>


                </div>


            </div>
        </section>
        <!-- invoice end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
                            $(document).ready(function () {
                                $(".flashmessage").delay(3000).fadeOut(100);
                                $(".company").change(function(){
                                    $(".vendor").html($(this).val());
                                })
                            });
</script>

