@extends('layouts.app')

@section('title')
	正在更改： {{ $record->datetimeByTime }}--{{ $record->name }}
@endsection

@section('content')
<br>
<form class="form-horizontal" action="{{ route('mealRecord.update',['id'=>$record->id]) }}" method="post">
  {{ csrf_field() }}
  <input type="hidden" id="in_url" name="in_url" value="{{ $url }}">
  <div class="form-group {{ $errors->has('category')?"has-error":"" }}">
    <div class="col-md-offset-2 col-md-6 col-sm-7">
      <div class="input-group">
        <span class="input-group-addon">&nbsp;類&nbsp;&nbsp;&nbsp;別&nbsp;</span>
        <select name="category" id="category" class="form-control" aria-describedby="categoryHelp">
          <option value=""></option>
          @if(isset($categorys))
            @foreach ($categorys as $category)
            @if($record->food()->category == $category->category)
            <option value="{{ $category->category }}" selected>{{ $category->category_name }}</option>
            @else
            <option value="{{ $category->category }}">{{ $category->category_name }}</option>
            @endif
            @endforeach
          @endif
        </select>
        <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-delicious"></span>&nbsp;&nbsp;&nbsp;</span>
      </div>
      <small id="categoryHelp" class="form-text text-muted">如果找不到你想要的類別，可以按旁邊的"新增食物"。</small>
    </div>
    <div class="col-md-2 col-sm-2">
      <a class="btn btn-primary btn-xs-block" href="{{ route('food.create') }}?url={{ route('mealRecord.edit', ['id'=>$record->id]) }}">新增食物</a>
    </div>
    @if($errors->has('category'))
    <div class="col-md-3 col-sm-3">
      <span class="help-block">
      <b>{{ $errors->first('category') }}</b>
      </span>
    </div>
    @endif
  </div>
  <div class="form-group {{ $errors->has('food')?"has-error":"" }}">
    <div class="col-md-offset-2 col-md-6 col-sm-7">
      <div class="input-group">
        <span class="input-group-addon">&nbsp;食&nbsp;&nbsp;&nbsp;物&nbsp;</span>
        <select name="food" id="food" class="form-control" aria-describedby="foodHelp">
          <option value=""></option>
          
          
          @foreach( $foods as $food )
          
            @if($record->food()->id == $food->id)
            <option value="{{ $food->id }}" selected>{{ $food->name }}</option>
            @else
            <option value="{{ $food->id }}">{{ $food->name }}</option>
            @endif
          @endforeach
        </select>
        <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-cutlery"></span>&nbsp;&nbsp;&nbsp;</span>
      </div>
      <small id="foodHelp" class="form-text text-muted">選擇類別後才能選食物。</small>
    </div>
    @if($errors->has('food'))
    <div class="col-md-3 col-sm-5">
      <span class="help-block">
      <b>{{ $errors->first('food') }}</b>
      </span>
    </div>
    @endif
  </div>
  <div class="form-group {{ $errors->has('weight')?"has-error":"" }}">
    <div class="col-md-offset-2 col-md-6 col-sm-7">
      <div class="input-group">
        <span class="input-group-addon">內容物</span>
          <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                aria-describedby="numberHelp" value="{{ $record->food()->weight }}">
          <span class="input-group-addon" id="unit" >{{ $record->food()->unit }}</span>
      </div>
      <small id="numberHelp" class="form-text text-muted"></small>
    </div>
    <div class="col-md-1 col-sm-1">
      <label id=""></label>
    </div>
    @if($errors->has('weight'))
    <div class="col-md-3 col-sm-3">
      <span class="help-block">
      <b>{{ $errors->first('weight') }}</b>
      </span>
    </div>
    @endif
  </div>
  <div class="form-group {{ $errors->has('weight')?"has-error":"" }}">
    <div class="col-md-offset-2 col-md-6 col-sm-7">
      <div class="input-group">
        <span class="input-group-addon">&nbsp;數&nbsp;&nbsp;&nbsp;量&nbsp;</span>
          <input type="number" step="0.01" class="form-control" id="num" name="num"
                aria-describedby="numHelp" value="{{ $record->num }}">
          <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-question"></span>&nbsp;&nbsp;&nbsp;</span>
      </div>
      <small id="numHelp" class="form-text text-muted"></small>
    </div>
    @if($errors->has('num'))
    <div class="col-md-3 col-sm-5">
      <span class="help-block">
      <b>{{ $errors->first('num') }}</b>
      </span>
    </div>
    @endif
  </div>
  <div class="form-group">
    <div class="col-md-offset-2 col-md-8">
      <button type="submit" class="btn btn-primary btn-xs-block">送出</button>
      <div class="visible-xs">
        <br>
      </div>
      <a class="btn btn-default btn-xs-block" href="{{ route('mealRecord.read') }}">取消</a>
    </div>
  </div>
</form>

@endsection

@section('javascript')
<script>
  $(document).ready(function() {
    $(document).on('change', '#category', function() {
      const category = $('#category option:selected').val();

      $.ajax({
        url: "{{ route('mealRecord.getFood') }}",
        method: 'GET',
        data: {
          'category': category
        }
      }).done(function(data) {
        console.log(data);
        const $food = $('#food');
        $food.html('');
        $('#weight').val('');
        $('#unit').html(' ');
        $('#num').val('');
        if (data.length == 0) {
          return;
        }
        $food.append('<option></option>')
        for (var i = 0; i < data.length; i++) {
          const food = data[i];
          var option = `<option value=\"${food.id}\">${food.name}</option>`;
          $food.append(option);
        }
      });
    });

    $(document).on('change', '#food', function() {
      const food = $('#food option:selected').val();
      $.ajax({
        url: "{{ route('mealRecord.getFoodDesc') }}",
        method: 'GET',
        data: {
          'food': food
        }
      }).done(function(data) {
        if (data.length == 0) {
          $('#weight').val('');
          $('#unit').html('');
          $('#num').val('');
          return;
        }
        $('#weight').val(data.weight);
        $('#unit').html(data.unit);
        $('#num').val(1);

      });
    });
    $.fn.datepicker.dates['zh-hant'] = {
      days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期"],
      daysShort: ["日", "一", "二", "三", "四", "五", "六"],
      daysMin: ["日", "一", "二", "三", "四", "五", "六"],
      months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      today: "今天",
      clear: "清除",
      format: 'yyyy-mm-dd',
      titleFormat: "MM yyyy",
      /* Leverages same syntax as 'format' */
      weekStart: 0
    };
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    $('.datepicker').datepicker({
      'autoclose': true,
      //'startDate': yesterday,
      'endDate': yesterday,
      'format': 'yyyy-mm-dd',
      language: 'zh-hant'
    })
  });
</script>

@endsection
