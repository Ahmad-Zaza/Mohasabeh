<ul class="list-group">

    @foreach($childs as $child)

        <li class="list-group-item {{$child->major_classification==0 ? 'item-child':''}}">

            <p style="display:inline">{{ $child->name_ar }} ({{count($child->childs)}}) / {{$child->code}}</p>
        
            @if(CRUDBooster::isDelete() && ($table_name == 'accounts' || $table_name == 'inventories' || $table_name == 'item_categories'))

                    @if($table_name == 'accounts' && in_array($child->id,$main_accounts))

                    @else
                        <a  class="click-cat btn btn-warning btn-sm float_lft btn-delete" href="javascript:void(0)"  data-href="{{url('modules/'.$table_name.'/delete/'.$child->id)}}">{{trans('crudbooster.Delete')}}</a>
                    @endif     
            @endif
            
            @if(CRUDBooster::isUpdate())
                @if(CRUDBooster::isSuperAdmin() || (!CRUDBooster::isSuperAdmin() && $category->major_classification ==0))
                    <a  class="click-cat btn btn-primary btn-sm float_lft" href="{{url('modules/'.$table_name.'/edit/'.$child->id)}}">{{trans('crudbooster.Edit')}}</a> 
                @endif
            @endif

            @include('itemCategories.manageChild',['childs' => $child->childs->sortBy('code')])

        </li>

    @endforeach
<!-- Modal -->


</ul>