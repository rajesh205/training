<!DOCTYPE html>
<html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>> 
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Training, Coaching, Management, Software, Php, CodeIgniter, wake Up, Accounting">
        <link rel="shortcut icon" href="uploads/favicon.png">
        <title><?php echo $this->router->fetch_class(); ?> | <?php echo $this->db->get("settings")->row()->system_vendor; ?></title>
        <!-- Bootstrap core CSS -->
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="common/assets/fontawesome5/css/all.min.css" rel="stylesheet" />
        <link href="common/assets/DataTables/datatables.min.css" rel="stylesheet" />
        <!--  <link rel="stylesheet" href="common/assets/data-tables/DT_bootstrap.css" />
       Custom styles for this template -->
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
        <script src="common/js/ajaxrequest-codearistos.min.js"></script>
        <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/jquery-multi-select/css/multi-select.css" />
        <link href="common/css/invoice-print.css" rel="stylesheet" media="print">
        <link href="common/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-timepicker/compiled/timepicker.css">
        <link href="common/assets/select2/dist/css/select2.min.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->



        <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?>
            <style>

                #main-content {
                    margin-right: 211px;
                    margin-left: 0px; 
                }

                body {
                    background: #f1f1f1;

                }

                #sidebar .fa {
                    margin-right: 0px;
                    margin-left: 5px;
                }

            </style>

        <?php } ?>



    </head>  
    <?php $settings_title = explode(' ', $settings->title); ?>
    <body>
        <section id="container" class="">


            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-dedent fa-bars"></div>
                </div>
                <!--logo start-->
                <a href="" class="logo"><strong><?php echo $settings_title[0]; ?><span><?php
                            if (!empty($settings_title[1])) {
                                echo $settings_title[1];
                            }
                            ?></strong></span></a>
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">

                        <!-- Payment notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?> 
                            <li id="header_inbox_bar" class="dropdown">
                                <a  href="finance/pending">
                                    <i class="fa fa-money-check"></i>
                                    <span class="badge bg-important">
                                        <?php echo count($nextPayments)?> 
                                    </span>
                                </a>
                            </li>
                        <?php
                            }
                        ?>
                        <?php if ($this->ion_auth->in_group(array('admin', 'Employee'))) { ?> 
                            <li id="header_inbox_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-money-check"></i>
                                    <span class="badge bg-important"> 
                                        <?php
                                        $query = $this->db->get('payment');
                                        $query = $query->result();
                                        foreach ($query as $payment) {
                                            $payment_date = date('y/m/d', $payment->date);
                                            if ($payment_date == date('y/m/d')) {
                                                $payment_number[] = '1';
                                            }
                                        }
                                        if (!empty($payment_number)) {
                                            echo $payment_number = array_sum($payment_number);
                                        } else {
                                            $payment_number = 0;
                                            echo $payment_number;
                                        }
                                        ?>        
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended inbox">
                                    <div class="notify-arrow notify-arrow-red"></div>
                                    <li>
                                        <p class="red"> <?php
                                            echo $payment_number . ' ';
                                            if ($payment_number <= 1) {
                                                echo lang('payment_today');
                                            } else {
                                                echo lang('payments_today');
                                            }
                                            ?></p>
                                    </li>
                                    <li>
                                        <a href="finance/payment"><p class="green"> <?php echo lang('see_all_payments'); ?> </p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- payment notification end -->  


                        <!-- Student notification start-->
                        <?php if ($this->ion_auth->in_group(array('admin', 'Employee', 'Instructor'))) { ?> 
                            <li id="header_notification_bar" class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="badge bg-success">                          
                                        <?php
                                        $this->db->where('add_date', date('m/d/y'));
                                        $query = $this->db->get('student');
                                        $query = $query->result();
                                        foreach ($query as $student) {
                                            $student_number[] = '1';
                                        }
                                        if (!empty($student_number)) {
                                            echo $student_number = array_sum($student_number);
                                        } else {
                                            $student_number = 0;
                                            echo $student_number;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu extended notification">
                                    <div class="notify-arrow notify-arrow-yellow"></div>
                                    <li>
                                        <p class="yellow"><?php
                                            echo $student_number . ' ';
                                            if ($student_number <= 1) {
                                                echo lang('student_registered_today');
                                            } else {
                                                echo lang('students_registered_today');
                                            }
                                            ?> </p>
                                    </li>
                                    <li>
                                        <a href="student"><p class="green"> <?php echo lang('see_all_students'); ?> </p></a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?> 
                        <!-- medicine notification end -->  

                    </ul>
                </div>
                <div class="top-nav ">

                    <?php
                    $message = $this->session->flashdata('quantity_check');
                    if (!empty($message)) {
                        ?>
                        <div class="quantity_check pull-left"> <?php echo $message; ?></div>
                    <?php }
                    ?> 
                    <?php
                    $message = $this->session->flashdata('feedback');
                    if (!empty($message)) {
                        ?>
                        <div class="flashmessage pull-left"><i class="fa fa-check"></i> <?php echo $message; ?></div>
                    <?php } ?> 
                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="uploads/favicon.png" width="21" height="23">
                                <span class="username"><?php echo $this->ion_auth->user()->row()->username; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <?php if (!$this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href=""><i class="fa fa-dashboard"></i>  <?php echo lang('dashboard'); ?> </a></li>
                                <?php } ?>
                                <li><a href="profile"><i class=" fa fa-suitcase"></i> <?php echo lang('profile'); ?> </a></li>
                                <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href="settings"><i class="fa fa-cog"></i>  <?php echo lang('settings'); ?> </a></li>
                                <?php } ?>

                                <li><a><i class="fa fa-user"></i> <?php echo $this->ion_auth->get_users_groups()->row()->name ?></a></li>
                                <li><a href="auth/logout"><i class="fa fa-key"></i>  <?php echo lang('log_out'); ?> </a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->

            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="">
                                <i class="fa fa-home"></i>
                                <span> <?php echo lang('dashboard'); ?> </span>
                            </a>
                        </li>

                        <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-book"></i>
                                    <span> <?php echo lang('course'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="course"><i class="fa fa-list"></i> <?php echo lang('all_courses'); ?> </a></li>
                                    <li><a  href="course/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_course'); ?> </a></li>
                                    <li><a  href="course/courseMaterialDetails"><i class="fa fa-file"></i> <?php echo lang('course'); ?> <?php echo lang('material'); ?> </a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-list"></i>
                                    <span> <?php echo lang('batch'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="batch"><i class="fa fa-list"></i> <?php echo lang('all_batches'); ?> </a></li>
                                    <li><a  href="batch/ongoing"><i class="fa fa-list"></i> <?php echo lang('ongoing_batches'); ?> </a></li>
                                    <li><a  href="batch/upcoming"><i class="fa fa-list"></i> <?php echo lang('upcoming'); ?> <?php echo lang('batches'); ?> </a></li>
                                    <li><a  href="batch/completed"><i class="fa fa-list"></i> <?php echo lang('completed'); ?> <?php echo lang('batches'); ?> </a></li>
                                    <li><a  href="batch/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_batch'); ?> </a></li>
                                    <li><a  href="batch/batchMaterial"><i class="fa fa-file"></i> <?php echo lang('batch'); ?> <?php echo lang('material'); ?> </a> </a></li>
                                </ul>
                            </li>
                        <?php } ?>




                        <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-user-graduate"></i>
                                    <span> <?php echo lang('students'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="student"><i class="fa fa-users"></i> <?php echo lang('all_students'); ?> </a></li>
                                    <li><a  href="student/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_student'); ?> </a></li>
                                    <li><a  href="student/addfeedback"><i class="fa fa-users"></i> Add Feedback/Status </a></li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-chalkboard-teacher"></i>
                                    <span> <?php echo lang('instructors'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="instructor"><i class="fa fa-users"></i> <?php echo lang('instructors'); ?> </a></li>
                                    <li><a  href="instructor/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_instructor'); ?> </a></li>
                                    <li><a  href="instructor/importTrainers"><i class="fa fa-plus-circle"></i> Import Trainers </a></li>
                                </ul>
                            </li>
                        <?php } ?>





                        <?php if ($this->ion_auth->in_group(array('admin', 'Instructor', 'Student'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-calendar-alt"></i>
                                    <span> <?php echo lang('routine'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="routine"><i class="fa fa-calendar-alt"></i> <?php echo lang('routine'); ?> </a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                                        <li><a  href="routine/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_routine'); ?> </a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('admin', 'Instructor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-check"></i>
                                    <span> <?php echo lang('attendence'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="attendence/viewAttendence"><i class="fa fa-eye"></i> <?php echo lang('view_attendence'); ?> </a></li>
                                    <li><a  href="attendence/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_attendence'); ?> </a></li>
                                    <li><a  href="attendence/staffAttendence"><i class="fa fa-eye"></i> <?php echo lang('staff'); ?> <?php echo lang('attendence'); ?> </a></li>
                                </ul>
                            </li>
                        <?php } ?>



                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-money-check"></i> 
                                    <span> <?php echo lang('finance'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a href="finance/payment"> <i class="fa fa-money-check"></i><span> <?php echo lang('all_payments'); ?> </span></a></li>
                                    <li><a href="finance/addPaymentView"> <i class="fa fa-plus-circle"></i><span> <?php echo lang('add_payment'); ?> </span></a></li>
                                    <li><a  href="finance/expense"><i class="fa fa-money-check"></i> <?php echo lang('expense'); ?> </a></li>
                                    <li><a  href="finance/addExpenseView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_expense'); ?> </a></li>
                                    <li><a  href="finance/expenseCategory"><i class="fa fa-edit"></i> <?php echo lang('expense'); ?>   <?php echo lang('category'); ?>  </a></li> 

                                </ul>
                            </li> 
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-chart-bar"></i>
                                    <span> <?php echo lang('reporting'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a href="finance/financialReport"> <i class="fa fa-chart-pie"></i><span> <?php echo lang('full_financial_report'); ?> </span></a></li>
                                    <li><a href="finance/courseWiseIncomeReportView"> <i class="fa fa-chart-bar"></i><span> <?php echo lang('course_wise_report'); ?> </span></a></li>
                                    <li><a href="finance/batchWiseIncomeReportView"> <i class="fa fa-chart-area"></i><span> <?php echo lang('batch_wise_report'); ?> </span></a></li>
                                    <li><a  href="finance/expenseReport"><i class="fa fa-chart-line"></i> <?php echo lang('expense_report'); ?> </a></li>
                                    <li><a  href="attendence/staffAttendence"><i class="fa fa-chart-bar"></i> <?php echo lang('staff_attendence_report'); ?> </a></li>
                                    <li><a  href="finance/reports"><i class="fa fa-chart-bar"></i> Expense Report </a></li>
                                </ul>
                            </li> 
                        <?php } ?>    




                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-user"></i>
                                    <span> <?php echo lang('employees'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="employee"><i class="fa fa-users"></i> <?php echo lang('employees'); ?> </a></li>
                                    <li><a  href="employee/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_employee'); ?> </a></li>
                                    <li><a  href="employee/incentives"><i class="fa fa-users"></i> Employee Incentives </a></li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-tasks"></i>
                                    <span> <?php echo lang('task'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="task"><i class="fa fa-tasks"></i> <?php echo lang('all'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/open"><i class="fa fa-tasks"></i> <?php echo lang('open'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/done"><i class="fa fa-check-circle"></i> <?php echo lang('done_tasks'); ?> </a></li>
                                    <li><a  href="task/addTaskView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_task'); ?> </a></li>


                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('Employee'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-tasks"></i>
                                    <span> <?php echo lang('my'); ?> <?php echo lang('youu'); ?> <?php echo lang('tasks'); ?>  </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="task/myTask"><i class="fa fa-tasks"></i> <?php echo lang('all'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/myOpen"><i class="fa fa-tasks"></i> <?php echo lang('open'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/myDone"><i class="fa fa-check-circle"></i> <?php echo lang('done_tasks'); ?> </a></li>
                                </ul>
                            </li>
                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('Employee'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-tasks"></i>
                                    <span> <?php echo lang('task'); ?> <?php echo lang('requested_by'); ?> <?php echo lang('you'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="task"><i class="fa fa-tasks"></i> <?php echo lang('all'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/open"><i class="fa fa-tasks"></i> <?php echo lang('open'); ?> <?php echo lang('tasks'); ?> </a></li>
                                    <li><a  href="task/done"><i class="fa fa-check-circle"></i> <?php echo lang('done_tasks'); ?> </a></li>
                                    <li><a  href="task/addTaskView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_task'); ?> </a></li>


                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-calendar"></i>
                                    <span> <?php echo lang('events'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="event"><i class="fa fa-list"></i> <?php echo lang('events'); ?> </a></li>
                                    <li><a  href="event/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_event'); ?> </a></li>
                                    <li><a  href="event/calendar"><i class="fa fa-calendar"></i> <?php echo lang('calendar'); ?> </a></li>

                                </ul>
                            </li>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-bell"></i>
                                    <span> <?php echo lang('notices'); ?> </span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="notice"><i class="fa fa-bell"></i> <?php echo lang('notice'); ?> </a></li>
                                    <li><a  href="notice/addNewView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_notice'); ?> </a></li>
                                </ul>
                            </li>
                        <?php } ?>



                        <?php if ($this->ion_auth->in_group(array('Student'))) { ?>
                            <?php
                            $student_user = $this->ion_auth->get_user_id();
                            $student_id = $this->db->get_where('student', array('ion_user_id' => $student_user))->row()->id;
                            ?>

                            <li><a  href="student/details?student_id=<?php echo $student_id; ?>"><i class="fa fa-tasks"></i> <?php echo lang('student'); ?> <?php echo lang('details'); ?>  </a></li>


                        <?php } ?>


                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-mail-bulk"></i>
                                    <span><?php echo lang('email'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="email/autoEmailTemplate"><i class="fa fa-robot"></i><?php echo lang('autoemailtemplate'); ?></a></li>
                                    <li><a  href="email/sendView"><i class="fa fa-location-arrow"></i><?php echo lang('new'); ?></a></li>
                                    <li><a  href="email/sent"><i class="fa fa-list-alt"></i><?php echo lang('sent'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                        <li><a  href="email/settings"><i class="fa fa-cogs"></i><?php echo lang('settings'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li> 
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-sms"></i>
                                    <span><?php echo lang('sms'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="sms/autoSmsTemplate"><i class="fa fa-robot"></i><?php echo lang('autosmstemplate'); ?></a></li>
                                    <li><a  href="sms/sendView"><i class="fa fa-location-arrow"></i><?php echo lang('send_sms'); ?></a></li>
                                    <li><a  href="sms/sent"><i class="fa fa-list-alt"></i><?php echo lang('sent_messages'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                        <li><a  href="sms"><i class="fa fa-cogs"></i><?php echo lang('sms_settings'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li> 
                        <?php } ?>



                        <?php if ($this->ion_auth->in_group('admin')) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-cogs"></i>
                                    <span><?php echo lang('settings'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a href="settings"><i class="fa fa-cog"></i><?php echo lang('system_settings'); ?></a></li>
                                    <li><a  href="pgateway"><i class="fa fa-credit-card"></i> <?php echo lang('pgateway_setting'); ?>  </a></li>   

                                    <li><a href="settings/language"><i class="fa fa-language"></i><?php echo lang('language'); ?></a></li>
                                    <li><a href="settings/backups"><i class="fa fa-database"></i><?php echo lang('backup_database'); ?></a></li>
                                </ul>
                            </li>

                            <!--      <li>
                                      <a href="settings" >
                                          <i class="fa fa-cogs"></i>
                                          <span>  <?php echo lang('settings'); ?>  </span>
                                      </a>
                                  </li>-->
                        <?php } ?>

                        <?php if ($this->ion_auth->in_group('Employee')) { ?>
                            <li>
                                <a href="finance/expense" >
                                    <i class="fa fa-money-check"></i>
                                    <span>  <?php echo lang('expense'); ?>  </span>
                                </a>
                            </li>
                            <li>
                                <a href="finance/addExpenseView" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span>  <?php echo lang('add_expense'); ?>  </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-globe"></i>
                                    <span><?php echo lang('website'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="frontend"><i class="fa fa-globe"></i><?php echo lang('visit') . " " . lang('website'); ?></a></li>
                                    <li><a  href="frontend/setting"><i class="fa fa-location-arrow"></i><?php echo lang('add') . " " . lang('website') . " " . lang('info'); ?></a></li>
                                </ul>
                            </li> 
                        <?php } ?>
                        <li>
                            <a href="profile" >
                                <i class="fa fa-user"></i>
                                <span>  <?php echo lang('profile'); ?>  </span>
                            </a>
                        </li>

                        <!--multi level menu start-->

                        <!--multi level menu end-->

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->


            <style>


                svg:not(:root).svg-inline--fa {
                    overflow: visible;
                    margin-right: 5px;
                }


            </style>







