@extends('crudbooster::admin_template')
@section('content')

    <div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='fa fa-cog fas-cog'></i> Add Pricing Package Options</strong>
            </div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action=''>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type='hidden' name='return_url' value=''/>
                    <input type='hidden' name='ref_mainpath' value=''/>
                    <input type='hidden' name='ref_parameter' value=''/>
                    <div class="box-body" id="parent-form-area">
                        <div class="form-group header-group-0 " id="form-group-title_ar" style="">
                            <label class="control-label col-sm-2">
                                Title Ar
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Title Ar" required="" maxlength="255" class="form-control"
                                       name="title_ar" id="title_ar" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-title_en" style="">
                            <label class="control-label col-sm-2">
                                Title En
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Title En" required="" maxlength="255" class="form-control"
                                       name="title_en" id="title_en" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-description_ar" style="">
                            <label class="control-label col-sm-2">
                                Description Ar
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Description Ar" required="" maxlength="255"
                                       class="form-control" name="description_ar" id="description_ar" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-description_en" style="">
                            <label class="control-label col-sm-2">
                                Description En
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Description En" required="" maxlength="255"
                                       class="form-control" name="description_en" id="description_en" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-content_ar" style="">
                            <label class="control-label col-sm-2">Content Ar
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea name="content_ar" id="content_ar" required="" maxlength="5000"
                                          class="form-control" rows="5"></textarea>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-content_en" style="">
                            <label class="control-label col-sm-2">Content En
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <textarea name="content_en" id="content_en" required="" maxlength="5000"
                                          class="form-control" rows="5"></textarea>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-price" style="">
                            <label class="control-label col-sm-2">
                                Price
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Price" required="" maxlength="255" class="form-control"
                                       name="price" id="price" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <script src="http://mohasabeh.voitest.com/vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
                        <script src="http://mohasabeh.voitest.com/vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
                        <div class="form-group header-group-0 " id="form-group-image" style="">
                            <label class="control-label col-sm-2">Image</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input id="image" class="form-control hide" type="text" value="" name="image">
                                    <a data-lightbox="roadtrip" class="hide" id="link-image" href="">
                                        <img style="width:150px;height:auto;" id="img-image" title="Add image for image"
                                             src="">
                                    </a>
                                    <span class="input-group-btn">
                                        <a id="" onclick="OpenInsertImagesingle('image')" class="btn btn-primary">
                                                                      <i class="fa fa-picture-o"></i> Choose an image
                        			        </a>
                                    </span>
                                </div>
                                <div class="help-block"></div>
                                <div class="text-danger"></div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalInsertPhotosingleimage">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                        </button>
                                        <h4 class="modal-title">Insert Image</h4>
                                    </div>
                                    <div class="modal-body" style="padding:0px; margin:0px; width: 100%;">
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <script>
                            function OpenInsertImagesingle(name) {
                                var link = `<iframe width="100%" height="400" src="/js/includes/filemanager/dialog.php?type=2&multiple=0&field_id=` + name + `" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>`;
                                $("#modalInsertPhotosingleimage .modal-body").html(link);
                                $("#modalInsertPhotosingleimage").modal();
                            }
                            var id = '#modalInsertPhotosingleimage';
                            $(function () {

                                $(id).on('hidden.bs.modal', function () {

                                    var check = $('#image').val();
                                    if (check != "") {
                                        $("#img-image").attr("src", check);
                                        $("#link-image").attr("href", check);
                                        $("#link-image").removeClass("hide");
                                    }


                                });
                            });

                        </script>
                    </div>

                    <div class="box-footer" style="background: #F5F5F5">
                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                                <input type="submit" name="submit" value='{{trans("crudbooster.button_save_more")}}'
                                       class='btn btn-success'>
                                @if(g('return_url'))
                                    <a href='{{g("return_url")}}' class='btn btn-default'><i
                                                class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}
                                    </a>
                                @else
                                    <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}'
                                       class='btn btn-default'><i
                                                class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}
                                    </a>
                                @endif
                            </div>
                        </div>


                    </div><!-- /.box-footer-->

                </form>
            </div>
        </div>
    </div><!--END AUTO MARGIN-->
    <div class="modal fade" id="modalInsertPhoto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Insert Image</h4>
                </div>
                <div class="modal-body" style="padding:0px; margin:0px; width: 100%;">

                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script language="javascript" type="text/javascript">
        $("#form").submit(function (e) {
            var data = $("#form").serialize();
            $("#form").submit();
            // debugger;

        });

    </script>

@endsection