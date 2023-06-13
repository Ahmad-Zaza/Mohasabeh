@inject('inventory', 'App\Models\Inventories\Inventory')
@php

$selected = [];
function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return '';
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

if ($method == 'getEdit') {
    $curr_url = $_SERVER['REQUEST_URI'];
    $user_id = get_string_between($curr_url, 'edit/', '?');

    $details = DB::table('inventories')
        ->where('major_classification', 0)
        ->get();

    session()->put('user_id', $user_id);
    $selected = DB::table('inventories_delegates')
        ->where('delegate_id', $user_id)
        ->pluck('inventory_id')
        ->toArray();
} else {
    $details = DB::table('inventories')
        ->where('major_classification', 0)
        ->get();
}

@endphp

@include('custom.CSS.multi_select_style')

<div class="row">
    <div class="col-sm-12">
        <select class="js-example-basic-single form-control" name="inventories[]" multiple>
            @foreach ($details as $item)
                @if (in_array($item->id, $selected))
                    <option value="{{ $item->id }}" selected>{{ $item->name_ar }}</option>
                @else
                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
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
