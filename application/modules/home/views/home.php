<!--sidebar end-->
<!--main content start-->
<script type="text/javascript" src="common/js/google-loader.js"></script>
<section id="main-content"> 
    <section class="wrapper site-min-height">
        <!--state overview start-->
        <?php
        $date_format = $settings->date_format;
        if ($date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        ?>

        <div class="col-md-12">
            <div class=" state-overview col-md-12" style="padding: 39px 22px;">
                <div class="clearfix">
                    <?php if (!$this->ion_auth->in_group('Student')) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                                <a href="course">
                                <?php } ?>
                                <section class="panel panel-moree">
                                    <div class="value top_box">
                                        <p> <?php echo lang('courses'); ?> </p>
                                        <h1 class="">
                                            <?php echo $this->db->count_all('course'); ?>
                                        </h1>
                                    </div>
                                </section>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                </a>
                            <?php } ?>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                                <a href="batch">
                                <?php } ?>
                                <section class="panel panel-moree">
                                    <div class="value top_box">
                                        <p> <?php echo lang('batches'); ?> </p>
                                        <h1 class="">
                                            <?php echo $this->db->count_all('batch'); ?>
                                        </h1>
                                    </div>
                                </section>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                </a>
                            <?php } ?>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                                <a href="student">
                                <?php } ?>
                                <section class="panel panel-moree">
                                    <div class="value top_box">
                                        <p> <?php echo lang('students'); ?> </p>
                                        <h1 class="">
                                            <?php echo $this->db->count_all('student'); ?>
                                        </h1>
                                    </div>
                                </section>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                </a>
                            <?php } ?>
                        </div>


                        <div class="col-lg-3 col-sm-6">
                            <?php if ($this->ion_auth->in_group('admin')) { ?>
                                <a href="instructor">
                                <?php } ?>
                                <section class="panel panel-moree">
                                    <div class="value top_box">
                                        <p> <?php echo lang('instructors'); ?> </p>
                                        <h1 class="">
                                            <?php echo $this->db->count_all('instructor'); ?>
                                        </h1>
                                    </div>
                                </section>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                <?php } ?>



                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                    <div class="col-md-6">
                        <!--work progress start-->
                        <section class="panel">
                            <div class="panel-body progress-panel">
                                <div class="task-progress">
                                    <h1><?php echo lang('statistics') ?></h1>
                                    <p><?php echo lang('this_month') ?></p>
                                </div>
                            </div>
                            <table class="table table-hover personal-task">
                                <tbody>  

                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <?php echo lang('number_of_payments'); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?php
                                                $query_n_o_p = $this->db->get('payment')->result();
                                                $i = 0;
                                                foreach ($query_n_o_p as $q_n_o_p) {
                                                    if (date('m', time()) == date('m', $q_n_o_p->date)) {
                                                        $i = $i + 1;
                                                    }
                                                }
                                                echo $i;
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div id="work-progress2"><canvas width="47" height="22" style="display: inline-block; width: 47px; height: 22px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <?php echo lang('total'); ?>  <?php echo lang('payments'); ?> 
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?php echo $settings->currency; ?>
                                                <?php
                                                $query = $this->db->get('payment')->result();
                                                $payments_total = array();
                                                foreach ($query as $q) {
                                                    if (date('m', time()) == date('m', $q->date)) {
                                                        $payments_total[] = $q->gross_total;
                                                    }
                                                }
                                                if (!empty($payments_total)) {
                                                    $payments_total = array_sum($payments_total);
                                                } else {
                                                    $payments_total = 0;
                                                }
                                                echo number_format($payments_total, 2, '.', ',');
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div id="work-progress1"><canvas width="47" height="20" style="display: inline-block; width: 47px; height: 20px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <?php echo lang('number_of_expenses'); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-important">
                                                <?php
                                                $query_n_o_e = $this->db->get('expense')->result();
                                                $i = 0;
                                                foreach ($query_n_o_e as $q_n_o_e) {
                                                    if (date('m', time()) == date('m', $q_n_o_e->date)) {
                                                        $i = $i + 1;
                                                    }
                                                }
                                                echo $i;
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div id="work-progress2"><canvas width="47" height="22" style="display: inline-block; width: 47px; height: 22px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <?php echo lang('total_expense'); ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-important">
                                                <?php echo $settings->currency; ?>
                                                <?php
                                                $query_expense = $this->db->get('expense')->result();
                                                $expense_total = array();
                                                foreach ($query_expense as $q_expense) {
                                                    if (date('m', time()) == date('m', $q_expense->date)) {
                                                        $expense_total[] = $q_expense->amount;
                                                    }
                                                }
                                                if (!empty($expense_total)) {
                                                    $expense_total = array_sum($expense_total);
                                                } else {
                                                    $expense_total = 0;
                                                }
                                                echo number_format($expense_total, 2, '.', ',');
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div id="work-progress2"><canvas width="47" height="22" style="display: inline-block; width: 47px; height: 22px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            <?php echo lang('this_month_net_cash'); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $net_cash = $payments_total - $expense_total;
                                            if (empty($net_cash)) {
                                                $net_cash = 0;
                                            }
                                            ?>
                                            <span class="badge <?php
                                            if ($net_cash >= 0) {
                                                echo 'bg-success';
                                            } else {
                                                echo 'lalbatti';
                                            }
                                            ?> ">
                                                      <?php echo $settings->currency; ?>
                                                      <?php
                                                      echo number_format($net_cash, 2, '.', ',');
                                                      ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div id="work-progress2"><canvas width="47" height="22" style="display: inline-block; width: 47px; height: 22px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>






                        <div class="">
                            <div id="chart_div" class="panel" style=""></div>
                        </div>





                        <div class="">         
                            <div class="panel-heading"> <?php echo lang('notice'); ?>  <?php echo lang('board'); ?></div>
                            <table class="table table-striped table-hover table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th> <?php echo lang('date'); ?> </th>
                                        <th> <?php echo lang('title'); ?> </th>

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
                                $i = 0;
                                foreach ($notices as $notice) {
                                    $i = $i + 1;
                                    ?>
                                    <tr class="">
                                        <td> <?php echo date('d-m-y', (int) $notice->add_date); ?></td>
                                        <td><?php echo $notice->title; ?></td>


                                    </tr>
                                    <?php
                                    if ($i == 5)
                                        break;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>  


                        <div class="">  
                            <aside class="">
                                <div class="panel-heading"> <?php echo lang('event'); ?> <?php echo lang('calendar'); ?></div>
                                <section class="">
                                    <div class="panel-body">
                                        <div id="calendar" class="has-toolbar"></div>
                                    </div>
                                </section>
                            </aside>
                        </div>


                        <!--work progress end-->
                    </div>
                <?php } ?>



                <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                    <div class="col-md-6 home_sec">         
                        <div class="panel-heading"> <?php echo lang('ongoing_batches'); ?></div>
                        <table class="table table-striped table-hover table-bordered" id="">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('batch_id'); ?> </th>
                                    <th> <?php echo lang('course'); ?> </th>
                                    <th> <?php echo lang('option'); ?> </th>
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
                            $i = 0;
                            foreach ($ongoing_batches as $ongoing_batch) {
                                $i = $i + 1;
                                ?>
                                <tr class="">
                                    <td><?php echo $ongoing_batch->batch_id; ?></td>
                                    <td> 
                                        <?php
                                        $course_id = $this->batch_model->getCourseByBatchId($ongoing_batch->id)->course;
                                        echo $this->course_model->getCourseById($course_id)->name;
                                        ?>
                                    </td>
                                    <td><a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=<?php echo $ongoing_batch->id ?>"><i class="fa fa-eye"> </i>  </a> </td>             
                                </tr>
                                <?php
                                if ($i == 4)
                                    break;
                            }
                            ?>
                            </tbody>
                        </table>





                        <div class="">         
                            <div class="panel-heading"> <?php echo lang('latest_payments'); ?> </div>
                            <table class="table table-striped table-hover table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th> <?php echo lang('student'); ?> </th>
                                        <th> <?php echo lang('date'); ?> </th>
                                        <th> <?php echo lang('amount'); ?> </th>
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
                                $i = 0;
                                foreach ($payments as $payment) {
                                    $i = $i + 1;
                                    ?>
                                    <tr class="">
                                        <td><?php echo $this->student_model->getStudentById($payment->student)->name; ?></td>
                                        <td> <?php echo date($date_format, $payment->date); ?></td>
                                        <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>             
                                    </tr>
                                    <?php
                                    if ($i == 5)
                                        break;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>





                        <div class="">         
                            <div class="panel-heading"> <?php echo lang('latest_expense'); ?></div>
                            <table class="table table-striped table-hover table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th> <?php echo lang('category'); ?> </th>
                                        <th> <?php echo lang('date'); ?> </th>
                                        <th> <?php echo lang('amount'); ?> </th>
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
                                $i = 0;
                                foreach ($expenses as $expense) {
                                    $i = $i + 1;
                                    ?>
                                    <tr class="">
                                        <td><?php echo $expense->category; ?></td>
                                        <td> <?php echo date($date_format, $expense->date); ?></td>
                                        <td><?php echo $settings->currency; ?> <?php echo $expense->amount; ?></td>             
                                    </tr>
                                    <?php
                                    if ($i == 5)
                                        break;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>








                    </div>



                <?php } ?>






                <?php if ($this->ion_auth->in_group(array('Student'))) { ?>

                    <div class="col-md-6">         
                        <div class="panel-heading"> <?php echo lang('notice'); ?>  <?php echo lang('board'); ?></div>
                        <table class="table table-striped table-hover table-bordered" id="">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('date'); ?> </th>
                                    <th> <?php echo lang('title'); ?> </th>

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
                            $i = 0;
                            foreach ($notices as $notice) {
                                $i = $i + 1;
                                ?>
                                <tr class="">
                                    <td> <?php echo date('d-m-y', (int) $notice->add_date); ?></td>
                                    <td><?php echo $notice->title; ?></td>


                                </tr>
                                <?php
                                if ($i == 5)
                                    break;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>




                    <div class="col-md-6">  
                        <aside class="">
                            <div class="panel-heading"> <?php echo lang('event'); ?> <?php echo lang('calendar'); ?></div>
                            <section class="">
                                <div class="panel-body">
                                    <div id="calendar" class="has-toolbar"></div>
                                </div>
                            </section>
                        </aside>
                    </div>


                <?php } ?>






                <?php if ($this->ion_auth->in_group(array('Instructor', 'Employee'))) { ?>






                    <div class="col-md-6">  
                        <aside class="">
                            <div class="panel-heading"> <?php echo lang('event'); ?> <?php echo lang('calendar'); ?></div>
                            <section class="">
                                <div class="panel-body">
                                    <div id="calendar" class="has-toolbar"></div>
                                </div>
                            </section>
                        </aside>






                    </div>


                    <div class="col-md-6">   


                        <div class="">  
                            <aside class="">
                                <div class="panel-heading"> <?php echo lang('employee'); ?> <?php echo lang('attendence'); ?></div>
                                <section class="">
                                    <div class="panel-body">
                                        <div id="clockdate">
                                            <h3><?php echo lang('current_time'); ?></h3>
                                            <div class="form-group"> 
                                                <div class="clockdate-wrapper">
                                                    <div id="clock"></div>
                                                    <div id="date"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <?php
                                            $sign_in_time = $this->attendence_model->checkSingedIn();
                                            if ($sign_in_time == 0) {
                                                ?>
                                                <a href="attendence/addOfficeLog" class="btn bg-important"> Sign In </a>
                                            <?php } else { ?>
                                                <h3> Sign In Time </h3> <?php echo date('d-m-y H:i:s', $sign_in_time) ?>
                                                <?php
                                                $sign_out_time = $this->attendence_model->checkSignedOut();
                                                if ($sign_out_time == 0) {
                                                    ?>
                                                    <h3> <a href="attendence/addOfficeLogOut" class="btn bg-important"> Sign Out </a> </h3>
                                                    <?php
                                                } else {
                                                    ?>

                                                    <h3> Sign Out Time </h3> <?php echo date('d-m-y H:i:s', $sign_out_time) ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </section>
                            </aside>
                        </div>





                        <div class="panel-heading"> <?php echo lang('notice'); ?>  <?php echo lang('board'); ?></div>
                        <table class="table table-striped table-hover table-bordered" id="">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('date'); ?> </th>
                                    <th> <?php echo lang('title'); ?> </th>

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
                            $i = 0;
                            foreach ($notices as $notice) {
                                $i = $i + 1;
                                ?>
                                <tr class="">
                                    <td> <?php echo date('d-m-y', (int) $notice->add_date); ?></td>
                                    <td><?php echo $notice->title; ?></td>


                                </tr>
                                <?php
                                if ($i == 5)
                                    break;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>


                <?php } ?>














            </div>
            <!--state overview end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!--footer end-->
</section>


<script>

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
        hr = (hr == 0) ? 12 : hr;
        hr = (hr > 12) ? hr - 12 : hr;         //Add a zero in front of numbers<10
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var curWeekDay = days[today.getDay()];
        var curDay = today.getDate();
        var curMonth = months[today.getMonth()];
        var curYear = today.getFullYear();
        var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
        document.getElementById("date").innerHTML = date;

        var time = setTimeout(function () {
            startTime()
        }, 500);
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }


</script>

<style>
    .wrapper{
        padding: 0px 14px !important;
    }

    .panel-body {
        padding: 15px 15px !important; 
    }

    .home_sec{
        margin-top: -20px;
        height: 343px!important;
    }

    .table{
        background: #fff;
        padding: 10px;
    }

</style>






<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();


        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Income', <?php
                if (!empty($this_month['payment'])) {
                    echo $this_month['payment'];
                } else {
                    echo '0';
                }
                ?>],
            ['Expense', <?php
                if (!empty($this_month['expense'])) {
                    echo $this_month['expense'];
                } else {
                    echo '0';
                }
                ?>],
        ]);

        var options = {
            title: selectedMonthName,
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>




<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Treated', <?php
                if (!empty($this_month['appointment_treated'])) {
                    echo $this_month['appointment_treated'];
                } else {
                    echo '0';
                }
                ?>],
            ['cancelled', <?php
                if (!empty($this_month['appointment_cancelled'])) {
                    echo $this_month['appointment_cancelled'];
                } else {
                    echo '0';
                }
                ?>],
        ]);

        var options = {
            title: selectedMonthName + ' Appointment',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>



<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Income', 'Expense'],
            ['Jan', <?php echo $this_year['payment_per_month']['january']; ?>, <?php echo $this_year['expense_per_month']['january']; ?>],
            ['Feb', <?php echo $this_year['payment_per_month']['february']; ?>, <?php echo $this_year['expense_per_month']['february']; ?>],
            ['Mar', <?php echo $this_year['payment_per_month']['march']; ?>, <?php echo $this_year['expense_per_month']['march']; ?>],
            ['Apr', <?php echo $this_year['payment_per_month']['april']; ?>, <?php echo $this_year['expense_per_month']['april']; ?>],
            ['May', <?php echo $this_year['payment_per_month']['may']; ?>, <?php echo $this_year['expense_per_month']['may']; ?>],
            ['June', <?php echo $this_year['payment_per_month']['june']; ?>, <?php echo $this_year['expense_per_month']['june']; ?>],
            ['July', <?php echo $this_year['payment_per_month']['july']; ?>, <?php echo $this_year['expense_per_month']['july']; ?>],
            ['Aug', <?php echo $this_year['payment_per_month']['august']; ?>, <?php echo $this_year['expense_per_month']['august']; ?>],
            ['Sep', <?php echo $this_year['payment_per_month']['september']; ?>, <?php echo $this_year['expense_per_month']['september']; ?>],
            ['Oct', <?php echo $this_year['payment_per_month']['october']; ?>, <?php echo $this_year['expense_per_month']['october']; ?>],
            ['Nov', <?php echo $this_year['payment_per_month']['november']; ?>, <?php echo $this_year['expense_per_month']['november']; ?>],
            ['Dec', <?php echo $this_year['payment_per_month']['december']; ?>, <?php echo $this_year['expense_per_month']['december']; ?>],
        ]);

        var options = {
            title: new Date().getFullYear() + ' <?php echo lang('per_month_income_expense'); ?>',
            vAxis: {title: '<?php echo $settings->currency; ?>'},
            hAxis: {title: '<?php echo lang('months'); ?>'},
            seriesType: 'bars',
            series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>






<!-- js placed at the end of the document so the pages load faster -->


