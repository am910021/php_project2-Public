@extends('layouts.app')

@section('title')
    會員管理
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-table/bootstrap-table.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/locale/bootstrap-table-zh-TW.js') }}"></script>
<script src="{{ asset('static/custom/table.js') }}"></script>
<script src="{{ asset('static/custom/userTable.js') }}"></script>
<script type="text/javascript">
function openUrl(i){
	location.href = "{{ route('admin.userEdit',['id'=>'']) }}/"+i;
}
</script>
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
    <table id="table"
        data-toggle="table"
        data-filter-control="true"
		data-filter-show-clear="true"
		data-show-columns="true"
        data-mobile-responsive="true"
        data-check-on-init="true"
		data-pagination="true"
		>
			
            <thead >
              <tr>
                <th data-field="user_check" data-sortable="true">
                  #
                </th>
                <th data-field="user_email" data-filter-control="input" data-sortable="true">
                  電子郵件
                </th>
                <th data-field="user_username" data-filter-control="input" data-sortable="true">
                  名稱
                </th>
                <th data-field="user_nickname" data-filter-control="input" data-sortable="true">
                  暱稱
                </th>
                <th data-field="user_type" data-filter-control="select" data-sortable="true">權限</th>
                <th data-field="user_group" data-filter-control="select" data-sortable="true">群組</th>
                <th data-field="user_isActive" data-filter-control="select" data-sortable="true">狀態</th>
                <th data-field="user_edit">編輯</th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
               <tr>
				<td>{{ $user->id }}</td>
                <td>
                  {{ str_limit($user->email, 32, '...') }}
                </td>
                <td>
                  {{ $user->username }}
                </td>
                <td>
                  {{ $user->nickname }}
                </td>
                <td>{{ $typeStr[$user->type] }}</td>
                <td>{{ $user->group()->name }}</td>
                <td><label class="{{ $statusClass[$user->isActive] }}">{{ $status[$user->isActive] }}</label></td>
                <td>
                   <button type="button" onClick="openUrl('{{ $user->id }}')" class="btn btn-warning btn-xs fa fa-pencil-square-o" ></button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-offset-10 col-md-2 text-right">
    		<br>
    		<a class="btn btn-info btn-default btn-block" href="{{ route('admin') }}">回上一頁</a>
    		<br>
    	</div>
    </div>
  </div>

@endsection