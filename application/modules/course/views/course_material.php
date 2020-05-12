<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

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
                        <h1><strong><?php echo lang('course_details'); ?> </strong></h1>
                        <div class="desk yellow">
                            <h3><?php echo lang('course_name'); ?> </h3>  <?php echo $course->name; ?>
                            <h3><?php echo lang('course_id'); ?> </h3> <?php echo $course->course_id; ?>
                            <h3><?php echo lang('topic'); ?> </h3> <?php echo $course->topic; ?>
                            <h3><?php echo lang('duration'); ?> </h3> <?php
                            echo $course->duration;
                            ;
                            ?>
                            <h3><?php echo lang('course_fee'); ?> </h3> <?php echo $settings->currency; ?> <?php
                            echo $course->course_fee;
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <div class="col-md-9">

                <header class="panel-heading">
                    <?php echo lang('course'); ?> <?php echo lang('material'); ?>
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
                <div class="adv-table editable-table">

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
                        <?php foreach ($course_materials as $course_material) { ?>
                            <div class="col-md-4 documents">
                                <div class="post-info">

                                    <img  class="image11" src="<?php echo $course_material->iconurl; ?>" width="100px">
                                </div>
                                <div class="post-info center">
                                    <h4>
                                        <?php
                                        if (!empty($course_material->title)) {
                                            echo $course_material->title;
                                        }
                                        ?>
                                    </h4>
                                </div>
                                <div class="post-info clearfix">



                                    <a href="course/deleteCourseMaterial?id=<?php echo $course_material->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                        <div class="btn-group pull-right">
                                            <button class="btn-xs green">
                                                X  
                                            </button>
                                        </div>
                                    </a>

                                    <a  href="<?php echo $course_material->url; ?>" download>
                                        <div class="btn-group pull-right">
                                            <button class="btn-xs green">
                                                <i class="fa fa-file-download"></i> 
                                            </button>
                                        </div>
                                    </a>

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
                <form role="form" action="course/addCourseMaterial" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>
                    <input type="hidden" name="course" value='<?php echo $course->id; ?>'
                           <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<!-- Add Course Modal-->





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>






<script>
                                        $(document).ready(function () {
                                            $(".search-batchs").keyup(function () {

                                                var keyword = this.value;
                                                $('.ajaxoption option').remove();

                                                $.ajax({
                                                    url: 'course/getBatchByKey?keyword=' + keyword,
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
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
