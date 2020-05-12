<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="row">
            <?php
            $date_format = $settings->date_format;
            if ($date_format == 1) {
                $date_format = 'd-m-Y';
            } else {
                $date_format = 'm/d/Y';
            }
            ?>


            <style>

                .editable-table .search_form{
                    border: 0px solid #ccc !important;
                    padding: 0px !important;
                    background: none !important;
                    float: right;
                    margin-right: 14px !important;
                }


                .editable-table .search_form input{
                    padding: 6px !important;
                    width: 250px !important;
                    background: #fff !important;
                    border-radius: none !important;
                }

                .editable-table .search_row{
                    margin-bottom: 20px !important;
                }



            </style>
            <section class="col-md-3">
                <div class="post-info course_details">
                    <div class="panel-body">
                        <h1><strong><?php echo lang('batch_details'); ?> </strong></h1>
                        <div class="desk yellow">
                            <h3><?php echo lang('course_name'); ?> </h3>  <?php
                            $course_id = $this->batch_model->getbatchById($batch_id)->course;
                            $couse_details = $this->course_model->getcourseById($course_id);
                            echo $couse_details->name;
                            ?>
                            <h3><?php echo lang('batch_id'); ?> </h3> <?php echo $this->batch_model->getbatchById($batch_id)->batch_id; ?>
                            <h3><?php echo lang('instructor'); ?> </h3> <?php echo $this->instructor_model->getInstructorById($batches->instructor)->name; ?>
                            <h3>
                                <?php echo lang('start_date'); ?> </h3> <?php echo date($date_format, $batches->start_date); ?>
                            <h3><?php echo lang('end_date'); ?> </h3>
                            <?php echo date($date_format, $batches->end_date); ?>

                        </div>
                    </div>
                </div>
            </section>

            <div class="col-md-9">
                <div class="adv-table editable-table ">

                    <header class="panel-heading">
                        <?php echo lang('batch'); ?> <?php echo lang('details'); ?>         
                        <div class="clearfix search_row col-md-4 pull-right">
                            <a data-toggle="modal" href="#myModal">
                                <div class="btn-group pull-right">
                                    <button class="btn-xs green">
                                        <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?> <?php echo lang('material'); ?>
                                    </button>
                                </div>
                            </a>
                        </div>
                    </header>
                    <style>

                        .image11{
                            width:  100px;
                            height: 100px;
                        }
                        .post-info {
                            position: relative !important;
                            background: #fff !important;
                            padding: 12px !important;
                        }
                        .post-wrap{
                            margin-top: 0px !important;
                            padding: 30px !important;
                        }

                        .btn1{
                            width: 100% !important;
                        }
                        .panel{
                            background: #f1f2f7 !important;
                        }

                        .course_details{
                            margin-top: 19px;
                        }

                        .post-info .green{
                            border: 1px solid !important;
                        }

                    </style>
                    <div class="">
                        <?php foreach ($batchmaterial as $batchmaterials) { ?>
                            <div class="col-md-4 documents">
                                <div class="post-info">
                                    <img  class="image11" src="<?php echo $batchmaterials->iconurl; ?>" width="100%">
                                </div>
                                <div class="post-info center">
                                    <?php
                                    if (!empty($batchmaterials->title)) {
                                        echo $batchmaterials->title;
                                    }
                                    ?>
                                </div>
                                <div class="post-info">    
                                    <div class="post-info clearfix">
                                        <a href="course/deleteBatchMaterialDetails?id=<?php echo $batchmaterials->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                            <div class="btn-group pull-right">
                                                <button class="btn-xs green">
                                                    X  
                                                </button>
                                            </div>
                                        </a>
                                        <a  href="<?php echo $batchmaterials->url; ?>" download>
                                            <div class="btn-group pull-right">
                                                <button class="btn-xs green">
                                                    <i class="fa fa-file-download"></i> 
                                                </button>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->







<!-- Add Course Material Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('files'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="batch/addBatchMaterial" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="course" value='<?php echo $course_id; ?>'>
                    <input type="hidden" name="batch" value='<?php echo $batch_id; ?>'>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Course Modal-->





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
                                        $(document).ready(function () {
                                            $(".search-students").keyup(function () {

                                                var keyword = this.value;
                                                $('.ajaxoption option').remove();

                                                $.ajax({
                                                    url: 'batch/getStudentByKey?keyword=' + keyword,
                                                    method: 'POST',
                                                    data: '',
                                                    dataType: 'json',
                                                }).success(function (response) {

                                                    $.each(response.opp, function (key, value) {
                                                        $(".ajaxoption").append(value);
                                                    });
                                                });


                                            });
                                        });

</script>
<script>
    $(document).ready(function () {

        $("#selUser1").select2({
            placeholder: '<?php echo lang('select_student'); ?>',
            allowClear: true,
            ajax: {
                url: 'batch/getStudentinfo',
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
