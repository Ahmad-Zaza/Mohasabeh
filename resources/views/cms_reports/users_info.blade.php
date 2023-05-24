@extends('crudbooster::admin_template')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('content')
    <form id='form-table' method='post' action='{{ CRUDBooster::mainpath('action-selected') }}'>
        <input type='hidden' name='button_name' value='' />
        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
        <table id='table_dashboard' class="table table-hover table-striped table-bordered">
            <thead class="table-head">
                <tr class="active">
                    <?php if($button_bulk_action):?>
                    <th width='3%'><input type='checkbox' class="" id='checkall' /></th>
                    <?php endif;?>
                    <?php if($show_numbering):?>
                    <th width="1%">{{ cbLang('no') }}</th>
                    <?php endif;?>
                    <?php
                    foreach ($cols as $col) {
                        if ($col['visible'] === false) {
                            continue;
                        }
                        $sort_column = Request::get('filter_column');
                        $colname = $col['label'];
                        $name = $col['name'];
                        $field = $col['field_with'];
                        $width = isset($col['width']) ? $col['width'] : '7%';
                        $style = isset($col['style']) ? $col['style'] : '';
                        $mainpath = trim(CRUDBooster::mainpath(), '/') . $build_query;
                        echo "<th width='$width' $style>";
                        echo cbLang($colname);
                        echo '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $customer)
                    <tr>
                        @foreach ($customer as $key => $cust)
                            <td>{{ $customer[$key] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <script>
        $('.content-header h1').html('Users Informations');
    </script>
@endsection
