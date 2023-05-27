@extends('crudbooster::admin_template')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('content')
    <div class="box">
        <div class="box-header">
            <div class="pull-left">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="active">
                            <td colspan="2">
                                <strong>
                                    <i class="fa fa-bars"></i>
                                    Customer Info
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <strong>
                                    Customer Name
                                </strong>
                            </td>
                            <td>
                                {{ $customer_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
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
            <form id="form-table" method="post" action="{{ CRUDBooster::mainpath('action-selected') }}">
                <input type="hidden" name="button_name" value="" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                    <thead class="table-head">
                        <tr class="active">
                            @if ($button_bulk_action)
                                <th width="3%"><input type="checkbox" class="" id="checkall" /></th>
                            @endif
                            @if ($show_numbering)
                                <th width="1%">{{ cbLang('no') }}</th>
                            @endif
                            @foreach ($cols as $col)
                                @if ($col['visible'] === false)
                                    @continue
                                @endif
                                @php
                                    $sort_column = Request::get('filter_column');
                                    $colname = $col['label'];
                                    $name = $col['name'];
                                    $field = $col['field_with'];
                                    $width = isset($col['width']) ? $col['width'] : '7%';
                                    $style = isset($col['style']) ? $col['style'] : '';
                                    $mainpath = trim(CRUDBooster::mainpath(), '/') . $build_query;
                                @endphp
                                <th width="{{ $width }}" style="{{ $style }}">
                                    {{ cbLang($colname) }}
                                </th>
                            @endforeach
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
        </div>
    </div>
    <script>
        var currentModulePath = @json(CRUDBooster::getCurrentModule()->path);
        var adminPath = @json(CRUDBooster::adminPath());
        $('.content-header h1').html('Users Informations');
        $('#content_section').prepend(`
            <p>
                <a href='${adminPath}/${currentModulePath}'>
                    <i class='fa fa-chevron-circle-left'></i>
                    &nbsp; Back To List Data Options
                </a>
            </p>
`);
    </script>
@endsection
