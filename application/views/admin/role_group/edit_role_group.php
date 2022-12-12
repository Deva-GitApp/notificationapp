<?php
$hashids = new Hashids\Hashids('the srh-ola error');
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/role_group/view'); ?>">View</a></li>
        </ol>
    </section>
    <section class="content">
        <!-- section start -->                
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <?php
                        if (validation_errors() != '' || $this->session->flashdata('db_error') != '') {
                            ?> 
                            <div class="form-group has-error">
                                <label for="inputError" class="control-label">
                                    <i class="fa fa-times-circle-o"></i> 
                                    <?php echo $this->session->flashdata('db_error'); ?>
                                    <?php echo validation_errors(); ?>
                                </label>                            
                            </div>
                            <?php
                        }
                        if ($this->session->flashdata('db_sucess') != '') {
                            ?>
                            <div class="form-group has-success">
                                <label for="inputSuccess" class="control-label">
                                    <i class="fa fa-check"></i> 
                                    <?php echo $this->session->flashdata('db_sucess'); ?>
                                </label>                                
                            </div>
                            <?php
                        }
                        ?>                        
                    </div>
                    <?php
                    $role_group_id = $hashids->encode($role_group_data['role_group_id'], dateintval('d'), dateintval('m'), dateintval('y'));
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open('admin/role_group/edit/' . $role_group_id, $attributes);
                    ?>
                    <div class="row">                        
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="role_group_name" class="col-lg-2 control-label">Role Group Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="role_group_name" placeholder="Role Group Name" name="role_group_name" value="<?php echo $role_group_data['role_group_name']; ?>">
                                    </div>
                                </div>                                                           
                                <div class="form-group">                                    
                                    <div class="col-lg-offset-2 col-lg-4">
                                        <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary hvr-bounce-out" value="Update" onclick="return editCategory(document.frm_registration)">
                                        <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-default hvr-bounce-out" value="Reset">
                                    </div>
                                </div>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end-->                                
</div>
<!-- content end -->
<!--script type="text/javascript">
    var arg = new Array();
    function showsquare() {
        $('#cropimg').addClass('btn btn-primary');
        if ($('.lb-image').is(':visible')) {
            $('.lb-image').imgAreaSelect({
                x1: 10, y1: 10, x2: 125, y2: 111,
                //maxWidth: 130, maxHeight: 134, 
                aspectRatio: "1:1",
                handles: true,
                parent: '#lightbox',
                persistent: true,
                onSelectEnd: function (img, selection) {
                    $('#x').val(selection.x1);
                    $('#y').val(selection.y1);
                    $('#w').val(selection.width);
                    $('#h').val(selection.height);
                    arg = [];
                    arg = [selection.x1, selection.y1, selection.width, selection.height];
                }
            });
            $('#lightbox').unbind('click');
        }
        else {
            setTimeout(showsquare, 50);
        }
    }
    function imageCreate() {
        var imgname = $('#txt_square_img').val();
        var xorgin = arg[0];
        var yorigin = arg[1];
        var imgwidth = arg[2];
        var imgheight = arg[3];
        var type = 'cat_img';
        $.ajax({
            url: '<?= base_url("base"); ?>/crop_square_image/'+type+'/',
            type: 'post',
            data: 'imgname=' + imgname + '&xorgin=' + xorgin + '&yorigin=' + yorigin + '&imgwidth=' + imgwidth + '&imgheight=' + imgheight,
            success: function (data) {
                if (data == '0') {
                    alert('unknown problem!');
                } else if (data == '1') {
                    alert('file not set');
                } else if (data == '2') {
                    alert('bad request!');
                } else {
                    //alert('Im coming square img part');
                    $('.square_img').remove();
                    $('.squareimg').prepend("<img src='<?= base_url("assets") ?>/images/role_group/" + data + "' class='square_img img-responsive' />");
                    $('#txt_square_img').val(data);
                    $('.lb-close').trigger('click');
                    $('.video_square_img a.croplinksquare').hide();
                    /*$('.video_square_img #uploadsquare').attr('style', 'width:164px;');*/
                    $('.video_square_img #uploadsquare').show();
                }
            }
        });
    }    
    $(document).ready(function () {
        $('a[rel=lightbox].croplinksquare').click(showsquare);        
    });
</script-->