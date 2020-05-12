<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-8">
            <section class="panel">
                <header class="panel-heading">
                    <i class="fa fa-info"></i>  <?php echo $gateway->gateway; ?> <?php echo lang('pgateway_setting'); ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <?php echo validation_errors(); ?>
                                        <form role="form" action="pgateway/addNewSetting" method="post" enctype="multipart/form-data">

                                            <?php if ($gateway->gateway == 'PayPal') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('apiuser'); ?></label>
                                                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->username)) {
                                                        echo $gateway->username;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('apipass'); ?></label>
                                                    <input type="text" class="form-control" name="password" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->password)) {
                                                        echo $gateway->password;
                                                    }
                                                    ?>'>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('apisign'); ?></label>
                                                    <input type="text" class="form-control" name="signature" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->signature)) {
                                                        echo $gateway->signature;
                                                    }
                                                    ?>'>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('account') . " " . lang('status'); ?></label>
                                                    <select class="form-control" id="" name="status">
                                                        <option value="live" <?php
                                                        if (!empty($gateway->status == 'live')) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo lang('live'); ?></option>
                                                        <option value="test"<?php
                                                        if (!empty($gateway->status == 'test')) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo lang('test'); ?></option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <?php if ($gateway->gateway == 'Stripe') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('secretkey'); ?></label>
                                                    <input type="text" class="form-control" name="secret" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->secret)) {
                                                        echo $gateway->secret;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('publishkey'); ?></label>
                                                    <input type="text" class="form-control" name="publish" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->publish)) {
                                                        echo $gateway->publish;
                                                    }
                                                    ?>'>
                                                </div>
                                            <?php } ?>
                                            <?php if ($gateway->gateway == 'PayU Money') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('merchantkey'); ?></label>
                                                    <input type="text" class="form-control" name="merchant" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->merchant_key)) {
                                                        echo $gateway->merchant_key;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $gateway->gateway; ?> <?php echo lang('salt'); ?></label>
                                                    <input type="text" class="form-control" name="salt" id="exampleInputEmail1" value='<?php
                                                    if (!empty($gateway->salt)) {
                                                        echo $gateway->salt;
                                                    }
                                                    ?>'>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('account') . " " . lang('status'); ?></label>
                                                    <select class="form-control" id="" name="status">
                                                        <option value="live" <?php
                                                        if (!empty($gateway->status == 'live')) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo lang('live'); ?></option>
                                                        <option value="test"<?php
                                                        if (!empty($gateway->status == 'test')) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo lang('test'); ?></option>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <input type="hidden" name="id" value='<?php
                                            if (!empty($gateway->id)) {
                                                echo $gateway->id;
                                            }
                                            ?>'>
                                            <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<script src="common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>