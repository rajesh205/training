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
                            <?php echo validation_errors(); ?>
                            <?php if($this->session->flashdata('status')){
                            ?>
                        <div class="col-lg-12 alert alert-danger"><?php echo $this->session->flashdata('status'); ?></div>
                            <?php
                            }    
                            ?>         
                            
                        </div>
                        <form role="form" action="instructor/importTrainers" method="post" enctype="multipart/form-data">
                            <div class="form-group">


                                <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                                <input type="file" name="import" class="form-control">

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
