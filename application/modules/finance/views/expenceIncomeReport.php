<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Income and Expenses of Month - <?php echo $date?>
                
            </header>
            <div class="panel-body">
            	<div class="col-md-12">
            		<div class="row">
            			<form class="" method="post" action="finance/reports">
	                    	<div class="col-md-3 form-group">
	                    		<input type="text" class="form-control default-date-picker col-md-5" required name="start_date" id="exampleInputEmail1" placeholder="">
	                    	</div>
	                    	<div class="col-md-3 form-group">
	                    		<input type="text" class="form-control default-date-picker col-md-5" required name="end_date" id="exampleInputEmail1" placeholder="">
	                    	</div>
	                    	<div class="col-md-4 form-group">
	                    		<input type="submit" class="btn btn-info" value="Search">
	                    	</div>
	                    </form>
                      <?php 
                        if(count($expenseReport) > 0 || count($incomeReport) > 0) {
                          $start_date = $this->input->post('start_date');
                          $end_date = $this->input->post('end_date');
                          $params = '';
                          if($start_date) {
                            $params = "?start_date=".$start_date."&end_date=".$end_date;
                          }
                      ?>
                        <a href="finance/exportReport<?php echo $params?>" class="btn btn-info" value="Export Report">Export Report</a>
                      <?php
                        }
                      ?>
                   	</div>
                </div>
            	<table class="table table-bordered table-stripped col-md-5">
                    <tr>
                        <th>
                            Expense
                        </th>
                        <th>
                            Amount
                        </th>
                        
                        
                    </tr>
                    <tbody>
                       	<?php
                       	$totalExpense = 0;
                       		foreach($expenseReport as $expenseIncome) {
                       			$totalExpense += $expenseIncome['expenses_amount']; 
                       	?>
                       		<tr>
	                            <td>
	                                <?php echo $expenseIncome['category']?>
	                            </td>
	                            <td>
	                                Rs.<?php echo $expenseIncome['expenses_amount']?>
	                            </td>
	                            
	                        </tr>
                       	<?php
                       		}
                       	?>
                        <tr style="border:2px">
                        	<td><strong>Total Expenses</strong></td><td><strong>Rs.<?php echo $totalExpense?>/-</strong></td>
                        </tr>
                        
                    </tbody>
                </table>
                <table class="table table-bordered table-stripped col-md-5">
                    <tr>
                        <th>
                            Student Name
                        </th>
                        <th>
                            Amount
                        </th>
                        
                        
                    </tr>
                    <tbody>
                       	<?php
                       	$totalIncome = $incomeRecieved =0;
                       		foreach($incomeReport as $income) {
                       			$tdsAmount = ($income['income']*$income['tds']/100);
                       			$incomeRecieved = $income['income']-$tdsAmount;
                       			$totalIncome += $incomeRecieved; 
                       	?>
                       		<tr>
	                            <td>
	                                <?php echo $income['name']?>
	                            </td>
	                            <td>
	                                Rs.<?php echo $incomeRecieved?>
	                            </td>
	                            
	                        </tr>
                       	<?php
                       		}
                       	?>
                        <tr>
                        	<td><strong>Total Income</strong></td><td>Rs.<strong><?php echo $totalIncome?></strong></td>
                        </tr>
                        <tr>
                        	<td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning">
                    <div class="col-md-5">
                      <strong>Profit Income</strong>
                    </div>
                    <div class="col-md-5">
                      Rs.<strong><?php echo $totalIncome-$totalExpense?></strong>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>