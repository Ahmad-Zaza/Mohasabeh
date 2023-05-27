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
            <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px;">
                <form id="subscriptionForm" action="{{ CRUDBooster::mainPath('generate-bills-info/' . $id) }}"
                    method="GET">
                    @csrf
                    <div class="form-group">
                        <select name="year" id="year" class="form-control">
                            <option value="0">Subscription Year</option>
                            <?php for ($year = $startYear; $year <= $endYear; $year++): ?>
                            <option value="<?php echo $year; ?>" <?php echo $subscription_year == $year ? 'selected' : ''; ?>><?php echo $year; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </form>
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
                        @foreach ($totalBills as $key => $bill)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td> {{ $totalBills[$key] }} </td>
                                <td> {{ $totalVouchers[$key] }} </td>
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
        $('.content-header h1').html('Bills & Vouchers Details');
        $('#content_section').prepend(`
            <p>
                <a href='${adminPath}/${currentModulePath}'>
                    <i class='fa fa-chevron-circle-left'></i>
                    &nbsp; Back To List Data Options
                </a>
            </p>
`);
        document.getElementById('year').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue !== '0')
                document.getElementById('subscriptionForm').submit();
        });
    </script>
@endsection
