@extends('layouts.app')

@section('title')
    食品種類管理
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
                field: 'category_id',
                width: '5%',
                align: 'center',
                valign: 'middle'
            },{
                field: 'category_name',
            },{
                field: 'category_food_num',
            },{
                field: 'category_lookup',
                align: 'center',
                valign: 'middle'
            },{
                field: 'category_edit',
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
                <th data-field="category_id" data-sortable="true">
                  #
                </th>
                <th data-field="category_name" data-filter-control="input" data-sortable="true">
                  類別名稱
                </th>
                <th data-field="category_food_num" data-filter-control="input" data-sortable="true">
                  擁有食物數量
                </th>
				<th data-field="category_lookup">查看</th>
                <th data-field="category_edit">編輯</th>
              </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
               <tr>
				<td>{{ $category->id }}</td>
                <td>
                  {{ str_limit($category->name, 32, '...') }}
                </td>
                <td>
                  {{ $category->theAmountOfFood }}
                </td>
                <td>
                   <button type="button" onClick="openUrl2('{{ $category->id }}')" class="btn btn-warning btn-xs fa fa-align-justify" ></button>
                </td>
                <td>
                   <button type="button" onClick="openUrl('{{ $category->id }}')" class="btn btn-warning btn-xs fa fa-pencil-square-o" ></button>
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