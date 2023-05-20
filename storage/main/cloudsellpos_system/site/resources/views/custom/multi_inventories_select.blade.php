@inject('inventory', 'App\Inventory')
@php
    

    //dd($details);
    $selected = [];
    function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

    if($method == 'getEdit'){
        $curr_url =$_SERVER['REQUEST_URI'];
        $user_id = get_string_between($curr_url, 'edit/', '?');

        $details = DB::table('inventories')->where('delegate_id', $user_id)->orWhere('delegate_id', NULL)->where('major_classification',0)->get();
       
        //dd($user_id);
        session()->put("user_id",$user_id);
        $selected = DB::table('inventories')->where('delegate_id',$user_id)->pluck("id")->toArray();
        //dd($selected);
    }else{
        $details = DB::table('inventories')->where('major_classification',0)->where('delegate_id',NULL)->get();
    }
        
   
    // dd($selected);
@endphp
<style type="text/css">
                    
        .select2-container--default .select2-selection--single {
            border-radius: 0px !important
        }

        .select2-container .select2-selection--single {
            height: 35px
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc !important;
            border-color: #367fa9 !important;
            color: #fff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
        }
    
            </style>
<div class="row">
<div class="col-sm-12">
    <select class="js-example-basic-single form-control" name="inventories[]" multiple >
        @foreach ($details as $item)
        @if(in_array($item->id,$selected))
        <option value="{{$item->id}}" selected>{{$item->name_ar}}</option>
        @else
        <option value="{{$item->id}}">{{$item->name_ar}}</option>
        @endif
        @endforeach
        
        
    </select>
</div>
</div>



<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script>
    $(function() {
        $('.js-example-basic-single').select2();
    });
</script>



