@extends('layouts.app')

@section('title')
    群組管理
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('static/bootstrap-table/bootstrap-table.css') }}">
@endsection

@section('javascript')
<script src="{{ asset('static/bootstrap-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.js') }}"></script>
<script src="{{ asset('static/bootstrap-table/locale/bootstrap-table-zh-TW.js') }}"></script>
<script src="{{ asset('static/custom/table.js') }}"></script>
<script type="text/javascript">
$('#table').bootstrapTable({
	onAll: function (number, size) {
    	updateRow();
        return false;
    },
    locale: "zh-TW",
    columns: [
            {
                field: 'group_id',
                //checkbox: true,
                align: 'center',
                valign: 'middle',
                width: '5%',
            },{
                field: 'group_manager',
                width: '20%',
            },{
                field: 'group_name',
                width: '25%',
            },{
                field: 'group_remarks',
            },{
            	field: 'group_amount',
                align: 'center',
                valign: 'middle',
                width: '3%',
            },{
            	field: 'group_status',
                align: 'center',
                valign: 'middle',
                width: '5%',
            },{
            	field: 'group_edit',
                align: 'center',
                valign: 'middle',
                width: '5%',
            }
        ],
});

function openUrl(i){
	location.href = "{{ route('admin.groupEdit',['id'=>'']) }}/"+i;
}
</script>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table" id="table"
        							data-toggle="table"
                                    data-filter-control="true"
                            		data-filter-show-clear="true"
                            		data-show-columns="true"
                                    data-mobile-responsive="true"
                                    data-check-on-init="true"
                            		data-pagination="true">
				<thead>
					<tr>
						<th data-field="group_id" data-sortable="true">
							#
						</th>
						<th data-field="group_manager" data-filter-control="input" data-sortable="true">
							管理者
						</th>
						<th data-field="group_name" data-filter-control="input" data-sortable="true">
							名稱
						</th>
						<th data-field="group_remarks" data-filter-control="input" data-sortable="true">
							備注
						</th>
						<th data-field="group_amount" data-filter-control="input" data-sortable="true">成員</th>
						<th data-field="group_status" data-filter-control="select" data-sortable="true">停止加入</th>
						<th data-field="group_edit">
							編輯
						</th>
					</tr>
				</thead>
				<tbody>
				@foreach($groups as $group)
					<tr>
						<td>
							{{ $group->id }}
						</td>
						<td>
							{{ $group->manager()->username }}
						</td>
						<td>
							{{ $group->name }}
						</td>
						<td>
							{{ str_limit($group->remarks, 80, '...') }}
						</td>
						<td>{{ $group->amount() }}</td>
						<td><label class="{{ $statusClass[$group->canApply] }}">{{ $status[$group->canApply] }}</label></td>
						<td>
							 <button type="button" onClick="openUrl('{{ $group->id }}')" class="btn btn-warning btn-xs fa fa-pencil-square-o" ></button>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
    <div class="row">
    	<div class="col-md-offset-8 col-md-2 text-right">
    		<br>
    		<a class="btn btn-success btn-default btn-block" href="{{ route('admin.groupCreate') }}">新建群組</a>
    	</div>
    	<div class="col-md-2 text-right">
    		<br>
    		<a class="btn btn-info btn-default btn-block" href="{{ route('admin') }}">回上一頁</a>
    		<br>
    	</div>
    </div>
</div>
@endsection