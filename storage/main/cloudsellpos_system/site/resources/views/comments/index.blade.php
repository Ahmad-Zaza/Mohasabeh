@extends('crudbooster::admin_template') @section('title', 'Comments Blog') @section('content')


    @if (\Session::has('msg'))
    <div class="alert alert-success">
          <b>  {!! \Session::get('msg') !!}</b>
    </div>
    @endif

<table id="" class="table table-hover table-striped table-bordered">
    <thead>
        <tr class="active">
            <th width="5%">
                Name
            </th>

            <th width="3%">
                email
            </th>


            <th width="3%">
                website
            </th>
            <th>
                publish
            </th>
            <th width="100%">
                comment
            </th>
            <th></th>
          
        </tr>
    </thead>
    <tbody class="ui-sortable">
        @foreach($comments  as $comment)
        <tr>
            <td>
                {{$comment->name}}
            </td>
            <td>
                {{$comment->email}}
            </td>
            <td>
                {{$comment->website}}
            </td>
            <td>
                @if($comment->is_show)
                    <a style="color: green" ><i class="fa fa-check"></i></a>
                    @else
                    <a style="color:red" ><i class="fa fa-close"></i></a>
                @endif
            </td>
            <td>
                {{$comment->comment}}
            </td>
            <td>
                <a class="btn btn-success" href="{{ URL('admin/blogs/comment/approve/'.$comment->id) }}" title="approve"><i class="fa fa-check"></i></a>
                <a class="btn btn-danger" href="{{URL('admin/blogs/comment/reject/'.$comment->id) }}" title="reject"><i class="fa fa-close"></i></a>
            </td>
        </tr>

        @endforeach
       
    </tbody>


 
</table>

@endsection