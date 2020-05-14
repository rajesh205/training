<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($instructor->id))
                    echo lang('edit_instructor');
                else
                    echo lang('add_instructor');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <?php echo validation_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>                              
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="instructor/addNew" method="post" enctype="multipart/form-data">
                            <div class="form-group">


                                <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->name)) {
                                    echo $instructor->name;
                                }
                                if (!empty($setval)) {
                                    echo set_value('name');
                                }
                                ?>' placeholder="">

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                                <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->email)) {
                                    echo $instructor->email;
                                }
                                if (!empty($setval)) {
                                    echo set_value('email');
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('password'); ?></label>
                                <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                                <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->address)) {
                                    echo $instructor->address;
                                }if (!empty($setval)) {
                                    echo set_value('address');
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                                <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->phone)) {
                                    echo $instructor->phone;
                                }if (!empty($setval)) {
                                    echo set_value('phone');
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('image'); ?></label>
                                <input type="file" name="img_url">
                            </div>

                            <input type="hidden" name="id" value='<?php
                            if (!empty($instructor->id)) {
                                echo $instructor->id;
                            }
                            ?>'>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> Technology </label>
                                <input type="text" class="form-control" name="technology" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->technology)) {
                                    echo $instructor->technology;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Experiance </label>
                                <input type="number" class="form-control" name="experiance" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->experiance)) {
                                    echo $instructor->experiance;
                                }
                                ?>' placeholder="Ex: 5 Years">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Expected Fee </label>
                                <input type="text" class="form-control" name="expected_amount" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->expected_amount)) {
                                    echo $instructor->expected_amount;
                                }
                                ?>' placeholder="Ex: 10000">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Status </label>
                                <select  class="form-control" name="status" id="exampleInputEmail1"  >
                                    <option value="0">Select Status</option>
                                    <option value="1" <?php (!empty($instructor->status) && $instructor->status== 1 ? "selected":"")?>>Active</option>
                                    <option value="-1" <?php (!empty($instructor->status) && $instructor->status== -1 ? "selected":"")?>>In Active</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Skills </label>
                                <input type="text" class="form-control" name="expected_amount" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->skill)) {
                                    echo $instructor->skill;
                                }
                                ?>' placeholder="Ex: 10000">
                            </div>
                            <div class="alert-warning">
                                <p> Bank Details of Instructor</p>
                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank <?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="bank_name" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->bank_name)) {
                                    echo $instructor->bank_name;
                                }
                                if (!empty($setval)) {
                                    echo set_value('bank_name');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->ifsc_code)) {
                                    echo $instructor->ifsc_code;
                                }
                                if (!empty($setval)) {
                                    echo set_value('ifsc_code');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Bank Account Number</label>
                                <input type="text" class="form-control" name="bank_account" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->bank_account)) {
                                    echo $instructor->bank_account;
                                }
                                if (!empty($setval)) {
                                    echo set_value('bank_account');
                                }
                                ?>' placeholder="">

                            </div>
                            <div class="form-group">


                                <label for="exampleInputEmail1"> Account Holder Name</label>
                                <input type="text" class="form-control" name="holder_name" id="exampleInputEmail1" value='<?php
                                if (!empty($instructor->holder_name)) {
                                    echo $instructor->holder_name;
                                }
                                if (!empty($setval)) {
                                    echo set_value('holder_name');
                                }
                                ?>' placeholder="">

                            </div>
                             <div class="form-group">


                                <label for="exampleInputEmail1"> Type of Instructor</label>
                                <input type="text" class="form-control" name="type" placeholder="Support/Trainer or Trainer,Support">

                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
