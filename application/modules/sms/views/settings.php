<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-8">
            <section class="panel">
                <header class="panel-heading">
                    <i class="fa fa-gear"></i>  <?php echo $settings1->name; ?> <?php echo lang('sms_settings'); ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <?php echo validation_errors(); ?>
                                        <form role="form" action="sms/addNewSettings" method="post" enctype="multipart/form-data">

                                            <?php if ($settings1->name == 'Clickatell') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $settings1->name; ?> <?php echo lang('username'); ?></label>
                                                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->username)) {
                                                        echo $settings1->username;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $settings1->name; ?> <?php echo lang('api'); ?> <?php echo lang('password'); ?></label>
                                                    <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo lang('api'); ?> <?php echo lang('id'); ?></label>
                                                    <input type="text" class="form-control" name="api_id" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->api_id)) {
                                                        echo $settings1->api_id;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!empty($settings1->username)) {
                                                               echo $settings1->username;
                                                           }
                                                           ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                            <?php } ?>


                                            <?php if ($settings1->name == 'MSG91') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('authkey'); ?></label>
                                                    <input type="text" class="form-control" name="authkey" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->authkey)) {
                                                        echo $settings1->authkey;
                                                    }
                                                    ?>' placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('sender'); ?> </label>   
                                                    <input type="text" class="form-control" name="sender" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->sender)) {
                                                        echo $settings1->sender;
                                                    }
                                                    ?>' placeholder="">
                                                </div>
                                            <?php } ?>
                                            <?php if ($settings1->name == 'Twilio') { ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $settings1->name; ?> <?php echo lang('sid'); ?></label>
                                                    <input type="text" class="form-control" name="sid" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->sid)) {
                                                        echo $settings1->sid;
                                                    }
                                                    ?>' placeholder="" <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo $settings1->name; ?> <?php echo lang('token'); ?> <?php echo lang('password'); ?></label>
                                                    <input type="text" class="form-control" name="token" id="exampleInputEmail1"value='<?php
                                                    if (!empty($settings1->token)) {
                                                        echo $settings1->token;
                                                    }
                                                    ?>'<?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>  >
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"><?php echo lang('sendernumber'); ?></label>
                                                    <input type="text" class="form-control" name="sendernumber" id="exampleInputEmail1" value='<?php
                                                    if (!empty($settings1->sendernumber)) {
                                                        echo $settings1->sendernumber;
                                                    }
                                                    ?>' <?php
                                                           if (!$this->ion_auth->in_group('admin')) {
                                                               echo 'disabled';
                                                           }
                                                           ?>>
                                                </div>
                                            <?php } ?>

                                            <input type="hidden" name="id" value='<?php
                                            if (!empty($settings1->id)) {
                                                echo $settings1->id;
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