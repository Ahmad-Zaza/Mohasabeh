
@php
    use App\Models\SystemConfigration\SystemSetting;
    use App\Models\FinancialCycles\FinancialCycle;
    $edited_cycle_id = SystemSetting::where('setting_key', 'old_cycle_edited_id')->first()->setting_value;
    $cycle_name = FinancialCycle::where('id', $edited_cycle_id)->first()->cycle_name;
@endphp
<div class="row">
    <div class="col-md-8 col-xs-12 col-md-push-2 ">
        <div class="box box-solid box-primary re-calculate-box">
            <div class="box-header">
                <i class="fa fa-recycle"></i>
                <h3 class="box-title"> {{trans('labels.re_calculate_data')}}</h3>
            </div>

            <div class="box-body">
                <p> {{trans('labels.some_edits_happend_in_old_cycle')}}</p>
                <p> <strong>  {{trans('labels.do_you_re_calculate_result_of_rotate_data')}}</strong></p>
                <p> {{trans('labels.update_options_after_re_calculate_data')}} </p>
               
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.initial_balances')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.beginning_items')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.entries_list_brief')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.helpful_accounts_brief')}}
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.items_cost')}}
                            </label>
                        </div>
                        <div class="checkbox" >
                            <label>
                                <i class="fa fa-check"></i>
                                {{trans('labels.currencies_ex_rates')}}
                            </label>
                        </div>
                    </div>
                    <p class="text-center">
                        <a class="btn btn-primary btn-xs" href="/modules/financial_cycles/reCalculateData" > {{trans('labels.re_calculate_data')}} <i class="fa fa-edit "></i></a>
                        <a class="btn btn-warning btn-xs" href="javascript::void(0);" id="go_home_without_re_calculate_data"> {{trans('labels.go_home_without_re_calculate_data')}} <i class="fa fa-ban "></i></a>
                    </p>
                
                
            </div>

        </div>
    </div>
</div>
@push('bottom')
    <script>
        var _PLEASE_CHOOSE_SOME_OPTIONS = "{{trans('messages.please_choose_some_options')}}";
        var _RECALCULATE_DATA_MESSAGE = "{{trans('messages.re_calculate_data_message')}}";
        var _ARE_YOU_CONFIRM = "{{trans('labels.are_you_confirm')}}";
        var _YES = "{{trans('crudbooster.Yes')}}";
        var _NO = "{{trans('crudbooster.No')}}";
        var _GO_HOME_WITHOUT_RECALCULATE_DATA_MESSAGE = "{{trans('messages.go_home_without_re_calculate_data_message',['cycle_name'=>$cycle_name])}}";

    </script>
    <script src="{{ asset ('js/modules_js/financial_cycles/re_calculate_data_script.js') }}"></script>
@endpush