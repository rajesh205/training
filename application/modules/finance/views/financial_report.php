<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <header class="panel-heading">
               <?php echo lang('financial_report'); ?> <?php
            if (!empty($from)) {
                echo lang('from');
            }
            ?> <?php echo $from; ?> <?php
            if (!empty($to)) {
                echo lang('to');
            }
            ?> <?php echo $to; ?>
            
            
        </header>
        <?php
        if ($settings->date_format == 1) {
            $date_format = 'dd-mm-yyyy';
        } else {
            $date_format = 'mm/dd/yyyy';
        }
        ?>
        <div class = "col-md-12"> 
            <section>
                <form role = "form" class = "f_report" class="attendence_top" action = "finance/financialReport" method = "post" enctype = "multipart/form-data">
                    <label class = "range">Date Range</label>
                    <div class = "form-group">

                        <div class = "col-md-6">
                            <div class = "input-group input-large"  data-date-format = "<?php echo $date_format; ?>">
                                <input type = "text" class = "form-control dpd1" name = "date_from" value = "<?php
                                if (!empty($from)) {
                                    echo $from;
                                }
                                ?>" placeholder = " <?php echo lang('date_from'); ?> ">
                                <span class = "input-group-addon"> <?php echo lang('to');
                                ?> </span>
                                <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                if (!empty($to)) {
                                    echo $to;
                                }
                                ?>" placeholder=" <?php echo lang('date_to'); ?> ">
                            </div>
                            <div class="row"></div>
                            <span class="help-block"></span> 
                        </div>
                        <div class="col-md-6 no-print">
                            <button type="submit" name="submit" class="btn btn-info range_submit"> <?php echo lang('submit'); ?> </button>
                            <a class="btn btn-info invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                        </div>
                        
                    </div>
                </form>
                
            </section>
        </div>

        <?php
        if (!empty($payments)) {
            $paid_number = 0;
            foreach ($payments as $payment) {
                $paid_number = $paid_number + 1;
            }
        }
        ?>
        <div class="row">
            <div class="col-lg-7">

                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-money"></i>  <?php echo lang('income'); ?> <?php echo lang('report'); ?>
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><?php echo lang('batch'); ?> <?php echo lang('id'); ?> </th>
                                <th><?php echo lang('course'); ?> <?php echo lang('name'); ?> </th>
                                <th></th>
                                <th class="hidden-phone"><?php echo lang('amount'); ?> </th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($batchs as $batch) {
                                $amount = array();
                                foreach ($payments as $payment) {
                                    if ($batch->id == $payment->batch) {
                                        $amount[] = $payment->amount;
                                    }
                                }
                                if (!empty($amount)) {
                                    $amount_total = array_sum($amount);
                                } else {
                                    $amount_total = 0;
                                }
                                $amount = NULL;
                                ?>

                                <tr class="">
                                    <td> <?php echo $batch->batch_id; ?></td>

                                    <td> <?php echo $this->course_model->getCourseById($batch->course)->name; ?> </td>
                                    <td></td>
                                    <td>   <?php echo $settings->currency; ?> <?php echo $amount_total; ?></td>
                                </tr>

                                <?php
                                if (!empty($amount_total)) {
                                    $amount_gross[] = $amount_total;
                                }
                            }
                            ?>
                        </tbody>

                        <tbody>
                            <tr>
                                <td> <strong> <?php echo lang('sub_total'); ?> </strong> </td>
                                <td></td>
                                <td></td>
                                <td>

                                    <strong>
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        if (!empty($amount_gross)) {
                                            echo $amount_gross = array_sum($amount_gross);
                                        } else {
                                            echo $amount_gross = 0;
                                        }
                                        ?> 
                                    </strong>
                                </td>

                            </tr>

                            <tr>
                                <td><strong> <?php echo lang('total'); ?>   <?php echo lang('discount'); ?> </strong></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        foreach ($payments as $payment) {
                                            $discount[] = $payment->discount;
                                        }
                                        if (!empty($discount)) {
                                            echo $discount = array_sum($discount);
                                        } else {
                                            $discount = 0;
                                        }
                                        ?>
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <td><strong><?php echo lang('gross'); ?> <?php echo lang('income'); ?> </strong></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        $gross = $amount_gross - $discount;
                                        echo $gross;
                                        ?>
                                    </strong>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </section>
                <section></section>
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-money"></i>   <?php echo lang('expense'); ?>   <?php echo lang('report'); ?> 
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><?php echo lang('category'); ?> </th>
                                <th> </th>
                                <th> </th>
                                <th class="hidden-phone"><?php echo lang('amount'); ?> </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expense_categories as $category) { ?>
                                <tr class="">
                                    <td><?php echo $category->category ?></td>
                                    <td> </td> 
                                    <td> </td>
                                    <td>
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        foreach ($expenses as $expense) {
                                            $category_name = $expense->category;


                                            if (($category->category == $category_name)) {
                                                $amount_per_category[] = $expense->amount;
                                            }
                                        }
                                        if (!empty($amount_per_category)) {
                                            $total_expense_by_category[] = array_sum($amount_per_category);
                                            echo array_sum($amount_per_category);
                                        } else {
                                            echo '0';
                                        }

                                        $amount_per_category = NULL;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </section>
            </div>

            <div class="col-lg-5">

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('gross'); ?> <?php echo lang('income'); ?> 
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        echo number_format($gross, 2, '.', ',');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('gross_expense'); ?> 
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        if (!empty($total_expense_by_category)) {
                                            $total_expense = array_sum($total_expense_by_category);
                                            echo number_format($total_expense, 2, '.', ',');
                                        } else {
                                            $total_expense = 0;
                                            echo number_format($total_expense, 2, '.', ',');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-money"></i>
                                    <?php echo lang('profit'); ?> 
                                </div>
                                <div class="col-xs-8">
                                    <div class="degree">
                                        <?php echo $settings->currency; ?>
                                        <?php
                                        $profit = $gross - $total_expense;
                                        echo number_format($profit, 2, '.', ',');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
