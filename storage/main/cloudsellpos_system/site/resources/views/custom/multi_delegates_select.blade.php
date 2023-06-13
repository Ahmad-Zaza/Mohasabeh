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
    $curr_url = $curr_url . '?';
    $inventory_id = get_string_between($curr_url, 'edit/', '?');

    $details = DB::table('cms_users')
        ->whereIn('id_cms_privileges', [4,6])
        ->get();

    session()->put('inventory_id', $inventory_id);
    $selected = DB::table('inventories_delegates')
        ->where('inventory_id', $inventory_id)
        ->pluck('delegate_id')
        ->toArray();
    //dd($selected);
} else {
    $details = DB::table('cms_users')
        ->whereIn('id_cms_privileges', [4,6])
        ->get();
}

// dd($selected);

@endphp

@include('custom.CSS.multi_select_style')

<div class="row">
    <div class="col-sm-12">
        <select class="js-example-basic-single form-control" name="delegates[]" multiple>
            @foreach ($details as $item)
                @if (in_array($item->id, $selected))
                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                @else
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
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