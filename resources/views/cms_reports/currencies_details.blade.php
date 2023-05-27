@extends('crudbooster::admin_template')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('content')
    <div class="box">
        <div div class="box-header">
            <div class="pull-left">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="active">
                            <td colspan="2">
                                <strong>
                                    <i class="fa fa-bars">
                                        Customer Info
                                    </i>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td width=25%>
                                <strong>
                                    Customer Name
                                </strong>
                            </td>
                            <td>
                                {{ $customer_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width=25%>
                                <strong>
                                    Customer Email
                                </strong>
                            </td>
                            <td>
                                {{ $customer_email }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
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
                        @foreach ($currencies as $currency)
                            <tr>
                                @foreach ($currency as $key => $curr)
                                    @if ($key == 'is_major' || $key == 'active')
                                        <td>{{ $currency[$key] == 1 ? 'Yes' : 'No' }}</td>
                                    @else
                                        <td>{{ $currency[$key] }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script>
        var currentModulePath = @json(CRUDBooster::getCurrentModule()->path);
        var adminPath = @json(CRUDBooster::adminPath());
        $('.content-header h1').html('Currencies Details');
        $('#content_section').prepend(`
        <p>
        <a href='${adminPath}/${currentModulePath}'>
        <i class='fa fa-chevron-circle-left'></i>
        &nbsp; Back To List Data Options
        </a>
            </p>
`)
    </script>
@endsection
