@extends('layouts.app')

@section('title')
    @if (isset($dateBool) && $dateBool)
        輸入非當日攝食
    @else
        輸入今日攝食
    @endif
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('mealRecord.createStore') }}" method="post">
        {{ csrf_field() }}
        @if (isset($dateBool) && $dateBool)
            <div class="form-group {{ $errors->has('date')?"has-error":"" }}">
                <label for="category" class="col-sm-2 control-label">日期:</label>
                <div class="col-sm-7">
                    <input type="text" name="date" class="form-control datepicker" value="{{ old('date', '') }}">
                </div>
                @if($errors->has('date'))
                    <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('date') }}</b>
                    </span>
                    </div>
                @endif
            </div>
        @endif
        <div class="form-group {{ $errors->has('category')?"has-error":"" }}">
            <label for="category" class="col-sm-2 col-xs-12 control-label">類別:</label>
            <div class="col-sm-5">
                <select name="category" id="category" class="form-control">
                    <option value=""></option>
                    @if(isset($categorys))
                        @foreach ($categorys as $category)
                            <option value="{{ $category->category }}">{{ $category->category_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-primary" href="{{ route('food.create') }}">新增食物</a>
            </div>
            @if($errors->has('category'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('category') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('food')?"has-error":"" }}">
            <label for="food" class="col-sm-2 control-label">食物:</label>
            <div class="col-sm-7">
                <select name="food" id="food" class="form-control">
                    <option value=""></option>
                </select>
            </div>

            @if($errors->has('food'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('food') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('weight')?"has-error":"" }}">
            <label for="weight" class="col-sm-2 col-xs-12 control-label">容量:</label>
            <div class="col-sm-6 col-xs-10">
                <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                       value="{{ old('weight', '') }}">
            </div>
            <div class="col-sm-1">
                <label id="unit"></label>
            </div>

            @if($errors->has('weight'))
                <div class="col-sm-3 col-xs-2">
                    <span class="help-block">
                        <b>{{ $errors->first('weight') }}</b>
                    </span>
                </div>
            @endif
        </div>
        <div class="form-group {{ $errors->has('num')?"has-error":"" }}">
            <label for="num" class="col-sm-2 control-label">數量:</label>
            <div class="col-sm-7">
                <input type="number" step="0.01" class="form-control" id="num" name="num"
                       value="{{ old('num', '') }}">
            </div>
            @if($errors->has('num'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('num') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-primary btn-xs-block">送出</button>
                <div class="visible-xs">
                    <br>
                </div>
                <a class="btn btn-default btn-xs-block" href="{{ route('mealRecord.read') }} ">取消</a>
            </div>
        </div>
    </form>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#category', function () {
                const category = $('#category option:selected').val();
                $.ajax({
                    url: "{{ route('mealRecord.getFood') }}",
                    method: 'GET',
                    data: {'category': category}
                }).done(function (data) {
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

            $(document).on('change', '#food', function () {
                const food = $('#food option:selected').val();
                $.ajax({
                    url: "{{ route('mealRecord.getFoodDesc') }}",
                    method: 'GET',
                    data: {'food': food}
                }).done(function (data) {
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
                clear: "清楚",
                format: 'yyyy-mm-dd',
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            $('.datepicker').datepicker({
                'autoclose': true,
                'endDate': yesterday,
                'format': 'yyyy-mm-dd',
                language: 'zh-hant'
            })
        });
    </script>

@endsection
