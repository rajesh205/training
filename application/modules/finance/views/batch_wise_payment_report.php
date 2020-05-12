<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-6 row">
            <header class="panel-heading">
                <?php echo lang('batch_wise_income_report'); ?>
                <div class="clearfix search_row col-md-4 pull-right no-print">
                    <a onclick="javascript:window.print();">
                        <div class="btn-group pull-right">
                            <button class="btn-xs green">
                                <i class="fa fa-print"></i>  <?php echo lang('print'); ?>
                            </button>
                        </div>
                    </a>
                </div>
            </header>
            <?php
            if ($settings->date_format == 1) {
                $date_format = 'dd-mm-yyyy';
            } else {
                $date_format = 'mm/dd/yyyy';
            }
            ?>

            <div class="attendence_top">
                <?php $course_details = $this->course_model->getCourseById($course_id); ?>

                <div class="form-group">
                    <label for="exampleInputEmail1">  <?php echo lang('course'); ?>  <?php echo lang('name'); ?> : <?php echo $course_details->name; ?></label>

                </div>

                <?php $batch_details = $this->batch_model->getBatchById($batch_id); ?>

                <div class="form-group">
                    <label for="exampleInputEmail1">  <?php echo lang('batch'); ?>  <?php echo lang('id'); ?> : <?php echo $batch_details->batch_id; ?></label>

                </div>



                <div class="form-group">
                    <label for="exampleInputEmail1">  <?php echo lang('date'); ?>  <?php echo lang('range'); ?> : <?php echo lang('from'); ?> <?php echo $from; ?> <?php echo lang('to'); ?> <?php echo $to; ?></label>

                </div>


                <div class="form-group">


                </div>
            </div>



            <?php
            if (!empty($payments)) {
                $paid_number = 0;
                foreach ($payments as $payment) {
                    $paid_number = $paid_number + 1;
                }
            }
            ?>

            <section class="panel">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th><?php echo lang('student'); ?> <?php echo lang('name'); ?> </th>
                            <th></th>
                            <th></th>
                            <th class="hidden-phone"><?php echo lang('amount'); ?> </th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        foreach ($payments as $payment) {
                            if ($batch_id == $payment->batch) {
                                $students[] = $payment->student;
                            }
                        }
                        if (!empty($students)) {
                            $students = array_unique($students);
                        }
                        ?>



                        <?php
                        if (!empty($students)) {
                            foreach ($students as $key => $value) {
                                ?>

                                <tr class="">
                                    <td> <strong> <?php echo $this->student_model->getStudentById($value)->name; ?> </strong></td>

                                    <td></td>
                                    <td></td>
                                    <td> <?php echo $settings->currency; ?> <?php
                                        $amount = array();
                                        foreach ($payments as $payment) {
                                            if ($payment->batch == $batch_id && $payment->student == $value) {
                                                $amount[] = $payment->amount;
                                            }
                                        }
                                        if (!empty($amount)) {
                                            $amount_total = array_sum($amount);
                                        } else {
                                            $amount_total = 0;
                                        }
                                        echo $amount_total;
                                        $amount = NULL;
                                        ?> </td>
                                </tr>

                                <?php
                                if (!empty($amount_total)) {
                                    $amount_gross[] = $amount_total;
                                }
                            }
                        }
                        ?>

                    </tbody>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td> <?php echo lang('sub_total'); ?> </td> 
                            <td>
                                <?php echo $settings->currency; ?>
                                <?php
                                if (!empty($amount_gross)) {
                                    echo $amount_gross = array_sum($amount_gross);
                                } else {
                                    echo $amount_gross = 0;
                                }
                                ?> 
                            </td>

                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td><h5> <?php echo lang('total'); ?>   <?php echo lang('discount'); ?> </h5></td>
                            <td>
                                <?php echo $settings->currency; ?>
                                <?php
                                foreach ($payments as $payment) {
                                    if ($payment->batch == $batch_id) {
                                        $discount[] = $payment->discount;
                                    }
                                }
                                if (!empty($discount)) {
                                    echo $discount = array_sum($discount);
                                } else {
                                    $discount = 0;
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td><h5><?php echo lang('gross'); ?> <?php echo lang('income'); ?> </h5></td>
                            <td>
                                <?php echo $settings->currency; ?>
                                <?php
                                $gross = $amount_gross - $discount;
                                echo $gross;
                                ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </section>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
