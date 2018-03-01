@extends('layouts.app')

@section('title')
    自訂義食品列表
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
                field: 'food_id',
                width: '5%',
                align: 'center',
                valign: 'middle'
            },{
                field: 'food_name',
            },{
                field: 'food_owner',
            },{
                field: 'food_add',
                align: 'center',
                valign: 'middle'
            },{
                field: 'food_merge',
                align: 'center',
                valign: 'middle'
            }
        ],
});

function openUrl(i){
	location.href = "{{ route('admin.editCatrgory',['id'=>'']) }}/"+i;
}
function openUrl2(i){
	location.href = "{{ route('admin.foodShow',['id'=>'']) }}/"+i;
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
                <th data-field="food_id" data-sortable="true">
                  #
                </th>
                <th data-field="food_name" data-filter-control="input" data-sortable="true">
                  食品名稱
                </th>
                <th data-field="food_owner" data-filter-control="input" data-sortable="true">
                  擁有者
                </th>
				<th data-field="food_add">新增</th>
                <th data-field="food_merge">合並</th>
              </tr>
            </thead>
            <tbody>
            @foreach($list as $item)
               <tr>
				<td>{{ $item->id }}</td>
                <td>
                  {{ str_limit($item->name, 32, '...') }}
                </td>
                <td>
                  {{ str_limit($item->user()->username, 32, '...') }}
                </td>
                <td>
                   <button type="button" onClick="openUrl2('{{ $item->id }}')" class="btn btn-warning btn-xs fa fa-plus" ></button>
                </td>
                <td>
                   <button type="button" onClick="openUrl('{{ $item->id }}')" class="btn btn-warning btn-xs fa fa-clone" ></button>
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