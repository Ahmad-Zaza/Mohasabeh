@extends('crudbooster::admin_template')
@section('content')
<div class="row">

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-image"></i>
            <h3 class="box-title">{{trans('labels.images_setting')}}</h3>
        </div>

        <div class="box-body">
            {!! trans('labels.images_setting_details') !!}
            <hr/>
                <h4>{{trans('labels.change_setting_value')}}</h4>
                <form id="imagesSettingForm" class="form">
                    <table class="table table-bordered table-striped">
                
                  
                        <tbody>
                            <tr>
                                <td width="40%"><label for="image_max_size">{{trans('labels.image_max_size')}}</label></td>
                                <td><input type="number" class="form-control" id="image_max_size" min="0.1" step="0.01" name="image_max_size" placeholder="{{trans('labels.enter_image_max_size')}}" value="{{$image_max_size}}" required></td>
                            </tr>
                            <tr>
                                <td><label for="image_types">{{trans('labels.image_types')}}</label></td>
                                <td>
                                    <div class="form-group">
                                      
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name='image_types' value='png' @if(in_array('png',$image_types)) checked @endif>PNG</label>
                                        </div>
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name='image_types' value='jpg' @if(in_array('jpg',$image_types)) checked @endif>JPG</label>
                                        </div> 
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name='image_types' value='jpeg' @if(in_array('jpeg',$image_types)) checked @endif>JPEG</label>
                                        </div>
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name='image_types' value='gif' @if(in_array('gif',$image_types)) checked @endif>GIF</label>
                                        </div>
                                        <div class="checkbox">
                                            <label> <input type="checkbox" name='image_types' value='bmp' @if(in_array('bmp',$image_types)) checked @endif>BMP</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="image_quality">{{trans('labels.image_quality')}}</label> <br/>
                                    <span class="setting-note">{{trans('labels.image_quality_breif')}}</span>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label>{{trans('labels.choose_image_quality')}}</label>
                                        <select class="form-control" name="image_quality" value="{{$image_quality}}" required>
                                            <option value="100" @if($image_quality == 100) selected @endif>100%</option>
                                            <option value="75" @if($image_quality == 75) selected @endif>75%</option>
                                            <option value="50" @if($image_quality == 50) selected @endif>50%</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>    
                            <tr>
                                <td></td>
                                <td>
                                    @php $path = url(CRUDBooster::mainPath()); @endphp
                                    <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                                        onclick="location.href = '{{$path}}'"> {{trans('labels.back')}} 
                                        <i class="fa fa-chevron-circle-right"></i>
                                    </a>
                                    <button class="btn btn-sm btn-primary" type='submit'> {{trans('crudbooster.button_save')}} <i class="fa fa-save"></i> </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form> 
        </div>

    </div>
</div>
    
</div> <!-- end row -->


@endsection
