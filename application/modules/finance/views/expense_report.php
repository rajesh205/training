<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <header class="panel-heading">
            <i class="fa fa-money"></i> <?php echo lang('date'); ?> <?php echo lang('to'); ?> <?php echo lang('date'); ?>  <?php echo lang('expense'); ?> <?php echo lang('report'); ?> 
        </header>
        <?php
        if ($settings->date_format == 1) {
            $date_format = 'dd-mm-yyyy';
        } else {
            $date_format = 'mm/dd/yyyy';
        }
        ?>
        <div class = "col-md-12">
            <div class = "col-md-7">
                <section>
                    <form role = "form" class = "f_report" action = "finance/expenseReport" method = "post" enctype = "multipart/form-data">
                        <label class = "range">Date Range</label>
                        <div class = "form-group">

                            <div class = "col-md-6">
                                <div class = "input-group input-large" data-date = "13/07/2013" data-date-format = "<?php echo $date_format; ?>">
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
                            <div class="col-md-6">
                                <button type="submit" name="submit" class="btn btn-info range_submit"> <?php echo lang('submit'); ?> </button>
                            </div>
                        </div>
                    </form>
                </section>
                <section class="">
                    <div class="col-md-3 panel-body">
                        <label class="">Date From</label> 
                        <div class="paanel"><?php
                            if (!empty($from)) {
                                echo $from;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3 panel-body">
                        <label class="">Date To</label> 
                        <div class="paanel"> <?php
                            if (!empty($to)) {
                                echo $to;
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-5">
            </div>
        </div>

       
        <div class="row">
            <div class="col-lg-7">

              
                <section></section>
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-money"></i>   <?php echo lang('expense'); ?>   <?php echo lang('report'); ?> 
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th><?php echo lang('category'); ?> </th>
                                <th class="hidden-phone"><?php echo lang('amount'); ?> </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expense_categories as $category) { ?>
                                <tr class="">
                                    <td><?php echo $category->category ?></td>
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


               

            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
