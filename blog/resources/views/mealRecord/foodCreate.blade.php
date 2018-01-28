@extends('layouts.app')

@section('title')
    新增食物
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('food.createStore') }}?url={{ $url }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name')?"has-error":"" }}">
            <label for="name" class="col-sm-2 control-label">名稱:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', '') }}">
            </div>

            @if($errors->has('name'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('name') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('weight')?"has-error":"" }}">
            <label for="weight" class="col-sm-2 control-label">份量:</label>
            <div class="col-sm-7">
                <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                       value="{{ old('weight', '') }}">
            </div>

            @if($errors->has('weight'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('weight') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('unit')?"has-error":"" }}">
            <label for="unit" class="col-sm-2 control-label">單位:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="unit" name="unit"
                       value="{{ old('unit', '') }}">
            </div>

            @if($errors->has('unit'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('unit') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('sugar_gram')?"has-error":"" }}">
            <label for="sugar_gram" class="col-sm-2 control-label">糖量(g):</label>
            <div class="col-sm-7">
                <input type="number" step="0.01" class="form-control" id="sugar_gram" name="sugar_gram"
                       value="{{ old('sugar_gram', '') }}">
            </div>

            @if($errors->has('sugar_gram'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('sugar_gram') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('kcal')?"has-error":"" }}">
            <label for="kcal" class="col-sm-2 control-label">熱量(kca):</label>
            <div class="col-sm-7">
                <input type="number" step="0.01" class="form-control" id="kcal" name="kcal"
                       value="{{ old('kcal', '') }}">
            </div>

            @if($errors->has('kcal'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('kcal') }}</b>
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
                <a class="btn btn-default btn-xs-block" href="{{ route('mealRecord.create') }} ">取消</a>
            </div>
        </div>
    </form>

@endsection

