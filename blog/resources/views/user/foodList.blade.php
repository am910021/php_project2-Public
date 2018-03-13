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
                field: 'food_weight',
            },{
                field: 'food_unit',
            },{
                field: 'food_sugar_gram',
            },{
                field: 'food_kcal',
            }
        ],
});
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
                <th data-field="food_weight" data-filter-control="input" data-sortable="true">
                 份量
                </th>
                <th data-field="food_weight" data-filter-control="input" data-sortable="true">
                 單位
                </th>
                <th data-field="food_sugar_gram" data-filter-control="input" data-sortable="true">
                 糖
                </th>
                <th data-field="food_kcal" data-filter-control="input" data-sortable="true">
                 總熱量
                </th>
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
                  {{ $item->weight }}
                </td>
				<td>
                  {{ $item->unit }}
                </td>
				<td>
                  {{ $item->sugar_gram }}
                </td>
				<td>
                  {{ $item->kcal }}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-offset-8 col-md-2">
    		<a class="btn btn-info btn-default btn-block" href="{{ route('user') }}">回上一頁</a>
    		<br>
    	</div>
    	<div class="col-md-2">
    		<a class="btn btn-info btn-default btn-block"  href="{{ route('food.create') }}?url={{ request()->path() }}">新增食物</a>
    		<br>
    	</div>
    </div>
  </div>

@endsection