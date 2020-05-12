<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Next Payments
                
            </header>
            <div class="panel-body">
                <table class="table table-bordered table-stripped">
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Payment Date
                        </th>
                    </tr>
                    <tbody>
                        <?php 
                            foreach($nextPayments as $payment) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $payment['name']?>
                                </td>
                                <td>
                                    <?php echo $payment['email']?>
                                </td>
                                <td>
                                    <?php echo $payment['next_payment_date']?>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</section>