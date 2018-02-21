@extends('layouts.app')

@section('title')
    食品種類管理-{{ $category->name }}
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
                field: 'food_weight',
            },{
                field: 'food_unit',
            },{
                field: 'food_sugar_gram',
            },{
                field: 'food_kcal',
            },{
                field: 'food_edit',
                align: 'center',
                valign: 'middle'
            }
        ],
});

function openUrl(i){
	location.href = "{{ route('admin.foodEdit',['id'=>'']) }}/"+i;
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
                  名稱
                </th>
                <th data-field="food_weight" data-filter-control="input" data-sortable="true">
                  容量
                </th>
                <th data-field="food_unit" data-filter-control="input" data-sortable="true">
                  單位
                </th>
                <th data-field="food_sugar_gram" data-filter-control="input" data-sortable="true">
                  糖份重量
                </th>
                <th data-field="food_kcal" data-filter-control="input" data-sortable="true">
                  卡路里
                </th>
                <th data-field="category_edit">編輯</th>
              </tr>
            </thead>
            <tbody>
            @foreach($foods as $food)
               <tr>
				<td>{{ $food->id }}</td>
				<td>{{ $food->name }}</td>
				<td>{{ $food->weight }}</td>
				<td>{{ $food->unit }}</td>
				<td>{{ $food->sugar_gram }}</td>
				<td>{{ $food->kcal }}</td>
                <td>
                   <button type="button" onClick="openUrl('{{ $food->id }}')" class="btn btn-warning btn-xs fa fa-pencil-square-o" ></button>
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
    		<a class="btn btn-info btn-default btn-block" href="{{ route('admin.foodCreate',['id'=>$category->id]) }}">新增</a>
    		<br>
    	</div>
    	<div class="col-md-2 text-right">
    		<br>
    		<a class="btn btn-info btn-default btn-block" href="{{ route('admin.showCategory') }}">回上一頁</a>
    		<br>
    	</div>
    </div>
  </div>

@endsection