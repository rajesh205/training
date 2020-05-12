<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                echo lang('pgateway_setting');
                ?>
            </header>


            <div class="panel-body">
                <table style="width:100%; margin: 20px 10px !important;">
                    <?php $i = 0; ?>
                    <tr>
                        <th>#</th>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('options'); ?></th>
                    </tr>
                    <?php
                    foreach ($gateways as $gateway) {
                        $i++
                        ?>
                        <tr>
                            <th><?php echo $i; ?></th>
                            <th><?php echo $gateway->gateway; ?></th>
                            <th><a class="btn btn-success btn-sm" href="<?php echo site_url('pgateway/setting?id=' . $gateway->id); ?>"><?php echo lang('manage'); ?></a></th>
                        </tr>
<?php } ?>
                </table>
            </div>
        </section>
        <section class="col-md-6">
            <header class="panel-heading">
                <?php
                echo lang('selectgateway');
                ?>
            </header>


            <div class="panel-body">
                <form role="form" action="pgateway/gatewaySetting" method="post" enctype="multipart/form-data">
                    <div class="">
                        <?php foreach ($gateways as $gateway) {
                            ?>
                            <div class="form-group">
                                <input type="radio" name="gateway" value="<?php echo $gateway->gateway; ?>" <?php if ($settings->payment_gateway == $gateway->gateway) { ?>checked<?php } ?>><label for="exampleInputEmail1">&nbsp;<?php echo $gateway->gateway; ?></label>
                            </div>
                        <?php }
                        ?>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                        </div> 
                    </div>
                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
    <!-- page end-->
</section>

</section>
<!--main content end-->
<!--footer start-->

<script src="common/js/ajaxrequest-codearistos.min.js"></script>

