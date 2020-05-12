<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($event->id))
                    echo lang('edit_event');
                else
                    echo lang('add_event');
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
                        <form role="form" action="event/addNew" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='<?php
                                if (!empty($event->title)) {
                                    echo $event->title;
                                }
                                ?>' placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('start'); ?></label>
                                <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                                    <input type="text" class="form-control" name="start" readonly="" value="" size="16">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('end'); ?></label>
                                <div data-date="2017-01-21T15:25:00Z" class="input-group date form_datetime-meridian">
                                    <input type="text" class="form-control" name="end" readonly="" size="16">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-info date-set"><i class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>



                            <input type="hidden" name="id" value='<?php
                            if (!empty($event->id)) {
                                echo $event->id;
                            }
                            ?>'>


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
