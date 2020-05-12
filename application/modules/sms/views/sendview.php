<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <?php echo lang('send_sms'); ?>
                    <div id="templatebar" class="pull-right col-md-6 btn-toolbar">
                        <button class='btn green pull-right' onclick="location.href = 'sms/sent'" type="button">
                            <?php echo lang('sent_messages'); ?></button>
                        <button class='btn green pull-right' onclick="location.href = 'sms/smsTemplate'" type="button">
                            <?php echo lang('template'); ?></button>
                        <button class='btn green pull-right' data-toggle="modal" data-target="#myModal1" type="button">
                            <?php echo lang('add_new'); ?></button>
                    </div>
                </header>
                <div class="panel-body"> 

                    <form role="form" id="myform" name="myform" class="clearfix" action="sms/send" method="post">
                        <label class="control-label">         
                            <?php echo lang('send_sms_to'); ?>
                        </label>    

                        <div class="radio">
                            <label>
                                <input type="radio" name="radio" id="optionsRadios2" value="allstudent">
                                <?php echo lang('all_student'); ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="radio" id="optionsRadios2" value="allinstructor">
                                <?php echo lang('all_instructor'); ?>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="radio" id="optionsRadios2" value="single_student">
                                <?php echo lang('single_student'); ?>
                            </label>
                        </div>

                        <div class="radio single_student">
                            <label>
                                <?php echo lang('select_student'); ?>
                                <br>
                                <select class="form-control m-bot15" id='selUser' name="student" style='width: 70%;'>
                                 <!--   <option value='0'><?php echo lang('select_student'); ?></option>-->
                                </select>
                            </label>

                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="radio" id="optionsRadios2" value="batch">
                                <?php echo lang('batch'); ?> 
                            </label>
                        </div>


                        <div class="radio pos_client">
                            <label>
                                <?php echo lang('select_batch_wise'); ?>
                                <br>
                                <select class="form-control m-bot15" id='selUser1' name="batchwise" style='width: 70%;'>
                                   <!-- <option value='0'><?php echo lang('select_batch_wise'); ?></option>-->
                                </select>
                            </label>

                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="radio" id="optionsRadios2" value="single_instructor">
                                <?php echo lang('single_instructor'); ?>
                            </label>
                        </div>

                        <div class="radio single_instructor">
                            <label>
                                <?php echo lang('select_instructor'); ?>
                                <select class="form-control m-bot15" id='selUser2' name="instructor" style='width: 70%;'>
                                 <!--   <option value='0'><?php echo lang('select_instructor'); ?></option>-->
                                </select>
                            </label>

                        </div>
                        <div class="">
                            <label>
                                <?php echo lang('select_template'); ?>
                                <select class="form-control m-bot15" id='selUser5' name="templatess" style='width: 100%;'>
                                   <!-- <option value='0'><?php echo lang('select_template'); ?></option>-->
                                </select>
                            </label>

                        </div>




                        <div class="form-group">
                            <label class="control-label"><?php echo lang('message'); ?></label> <br>
                            <?php
                            $count = 0;
                            foreach ($shortcode as $shortcodes) {
                                ?>
                                <input type="button" name="myBtn" value="<?php echo $shortcodes->name; ?>" onClick="addtext(this);">
                                <?php
                                $count+=1;
                                if ($count === 7) {
                                    ?>
                                    <br>
                                    <?php
                                }
                            }
                            ?> <br><br>

                            <textarea class="" name="message" value="" cols="70" rows="10"placeholder="Write Your Message!!!"></textarea>
                        </div>
                        <input type="hidden" name="id" value=''>

                        <div class="form-group col-md-12">
                            <button type="submit" name="submit" class="btn btn-info col-md-3 pull-right"><i class="fa fa-location-arrow"></i> <?php echo lang('send_sms'); ?></button>
                        </div>

                    </form>
                </div>
            </section>
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->








<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('add_new'); ?> <?php echo lang('template'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo validation_errors(); ?>
                <form role="form" name="myform1" action="sms/addNewTemplate" method="post" enctype="multipart/form-data">                                                                                    

                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('templatename'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                        if (!empty($templatename->name)) {
                            echo $templatename->name;
                        }
                        if (!empty($setval)) {
                            echo set_value('name');
                        }
                        ?>' placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('message'); ?> <?php echo lang('template'); ?></label><br>
                        <?php
                        $count1 = 0;
                        foreach ($shortcode as $shortcodes) {
                            ?>
                            <input type="button" name="myBtn" value="<?php echo $shortcodes->name; ?>" onClick="addtext1(this);">
                            <?php
                            $count1+=1;
                            if ($count1 === 7) {
                                ?>
                                <br>
                                <?php
                            }
                        }
                        ?> <br><br>

                        <textarea class="" name="message" value='<?php
                        if (!empty($templatename->message)) {
                            echo $templatename->message;
                        }
                        if (!empty($setval)) {
                            echo set_value('message');
                        }
                        ?>' cols="70" rows="10"placeholder="" required> <?php
                                      if (!empty($templatename->message)) {
                                          echo $templatename->message;
                                      }
                                      if (!empty($setval)) {
                                          echo set_value('message');
                                      }
                                      ?></textarea>
                    </div>
                    <input type="hidden" name="id" value='<?php
                    if (!empty($templatename->id)) {
                        echo $templatename->id;
                    }
                    ?>'>
                    <input type="hidden" name="type" value='sms'>
                    <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Send SMS To Voters</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="sms/sendVoterAreaWise" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Message</label>
                        <textarea cols="50" rows="10" class="form-control" name="message" id="exampleInputEmail1" value=''> </textarea>
                    </div>
                    <input type="hidden" id="area_id" value="" name="area_id">
                    <button type="submit" name="submit" class="btn btn-info submit_button">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Send SMS To All Volunteer</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="sms/sendVolunteer" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Message</label>
                        <textarea cols="50" rows="10" class="form-control" name="message" id="exampleInputEmail1" value=''> </textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-info submit_button">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>







<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Send SMS To Volunteers</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="sms/sendVolunteerAreaWise" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Message</label>
                        <textarea cols="50" rows="10" class="form-control" name="message" id="exampleInputEmail1" value=''> </textarea>
                    </div>
                    <input type="hidden" id="area_idd" value="" name="area_id">
                    <button type="submit" name="submit" class="btn btn-info submit_button">Submit</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">


                            $(document).ready(function () {
                                $(".voterAW").click(function () {
                                    $("#area_id").val($(this).attr('data-id'));
                                    $('#myModal2').modal('show');
                                });
                                $(".volunteerAW").click(function () {
                                    $("#area_idd").val($(this).attr('data-id'));
                                    $('#myModal4').modal('show');
                                });
                            });

</script>
<!-- Script -->
<script>
    function addtext(ele) {
        var fired_button = ele.value;
        document.myform.message.value += fired_button;
    }
</script>
<script>
    function addtext1(ele) {
        var fired_button = ele.value;
        document.myform1.message.value += fired_button;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#selUser").select2({
            placeholder: '<?php echo lang('select_student'); ?>',
            allowClear: true,
            ajax: {
                url: 'sms/getStudentinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_batch_wise'); ?>',
            allowClear: true,
            ajax: {
                url: 'sms/getBatchinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser2").select2({
            placeholder: '<?php echo lang('select_instructor'); ?>',
            allowClear: true,
            ajax: {
                url: 'sms/getInstructorinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#selUser5").select2({
            placeholder: '<?php echo lang('select_template'); ?>',
            allowClear: true,
            ajax: {
                url: 'sms/getTemplateinfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term                   
                    };

                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#selUser5').on('change', function () {
            var iid = $(this).val();
            var type = 'sms';

            $.ajax({
                url: 'sms/getTemplateText?id=' + iid + '&type=' + type,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {

                $('#myform').find('[name="message"]').val(response.user.message).end();
            })
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.pos_client').hide();
        $('input[type=radio][name=radio]').change(function () {
            if (this.value == 'batch') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });

    });


</script> 

<script>
    $(document).ready(function () {
        $('.single_instructor').hide();
        $('input[type=radio][name=radio]').change(function () {
            if (this.value == 'single_instructor') {
                $('.single_instructor').show();
            } else {
                $('.single_instructor').hide();
            }
        });

    });


</script> 
<script>
    $(document).ready(function () {
        $('.single_student').hide();
        $('input[type=radio][name=radio]').change(function () {
            if (this.value == 'single_student') {
                $('.single_student').show();
            } else {
                $('.single_student').hide();
            }
        });

    });


</script> 
<script>
    $(document).ready(function () {
        $('.single_doctor').hide();
        $('input[type=radio][name=radio]').change(function () {
            if (this.value == 'single_doctor') {
                $('.single_doctor').show();
            } else {
                $('.single_doctor').hide();
            }
        });

    });


</script> 

<script>
    $(document).ready(function () {
        $('.staff').hide();
        $('input[type=radio][name=radio]').change(function () {
            if (this.value == 'staff') {
                $('.staff').show();
            } else {
                $('.staff').hide();
            }
        });

    });


</script> 


<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>