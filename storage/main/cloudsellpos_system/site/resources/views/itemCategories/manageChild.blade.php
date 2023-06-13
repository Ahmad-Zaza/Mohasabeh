<ul class="list-group">

    @foreach ($childs as $child)
        <li class="list-group-item {{ $child->major_classification == 0 ? 'item-child' : '' }}">

            <p style="display:inline">{{ $child->name_ar }} ({{ count($child->childs) }}) / {{ $child->code }}</p>
            
            @if (CRUDBooster::isDelete() && $hasPermission &&
                ($table_name == 'accounts' || $table_name == 'inventories' || $table_name == 'item_categories'))
                @if ($table_name == 'accounts' && in_array($child->id, $main_accounts))
                @else
                    <a class="click-cat btn btn-warning btn-xs float_lft btn-delete" href="javascript:void(0)"
                        data-href="{{ url('modules/' . $table_name . '/delete/' . $child->id) }}" data-id="{{$child->id}}"><span
                            class="fa fa-trash"></span></a>
                @endif
            @endif

            @if (CRUDBooster::isUpdate() && $hasPermission)
                @if (CRUDBooster::isSuperAdmin() || (!CRUDBooster::isSuperAdmin() && $category->major_classification == 0))
                    <a class="click-cat btn btn-success btn-xs float_lft"
                        href="{{ url('modules/' . $table_name . '/edit/' . $child->id) }}"><span
                            class="fa fa-pencil"></span></a>
                @endif
            @endif

            @if (CRUDBooster::isRead())
                <a class="click-cat btn btn-primary btn-xs float_lft btn-detail"
                    href="{{ url('modules/' . $table_name . '/detail/' . $child->id) }}"> <span class="fa fa-eye"></span></a>
            @endif
            @include('itemCategories.manageChild', ['childs' => $child->childs->sortBy('code'),'hasPermission'=>$hasPermission])

        </li>
    @endforeach
    <!-- Modal -->


</ul>
