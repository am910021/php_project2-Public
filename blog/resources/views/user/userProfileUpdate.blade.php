@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('userProfile.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group {{ $errors->has('age')?"has-error":"" }}">
            <label for="age" class="col-sm-2 control-label">年齡:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="age" name="age"
                       value="{{ old('age', isset($userProfile)?$userProfile->age:'') }}">
            </div>
            @if($errors->has('age'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('age') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('height')?"has-error":"" }}">
            <label for="height" class="col-sm-2 control-label">身高:</label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="height" name="height"
                       value="{{ old('height', isset($userProfile)?$userProfile->height:'') }}">
            </div>
            @if($errors->has('height'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('height') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('weight')?"has-error":"" }}">
            <label for="weight" class="col-sm-2 control-label">體重:</label>
            <div class="col-sm-7">
                <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                       value="{{ old('weight', isset($userProfile)?$userProfile->weight:'') }}">
            </div>
            @if($errors->has('weight'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('weight') }}</b>
                    </span>
                </div>
            @endif
        </div>

        <div class="form-group {{ $errors->has('sex')?"has-error":"" }}">
            <label for="sex" class="col-sm-2 control-label">性別:</label>
            <div class="col-sm-7">
                <select name="sex" id="sex" class="form-control">
                    <option value=""></option>
                    @foreach (config('constants.SEX_ARR') as $index => $SEX)
                        <option value="{{ $index }}" {{ old('sex', isset($userProfile)?strval($userProfile->sex):'') === strval($index)? "selected": ""}}>{{ $SEX }}</option>
                    @endforeach
                </select>
            </div>
            @if($errors->has('sex'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('sex') }}</b>
                    </span>
                </div>
            @endif
        </div>


        <div class="form-group {{ $errors->has('activity_amount')?"has-error":"" }}">
            <label for="activity_amount" class="col-sm-2 control-label">活動量:</label>
            <div class="col-sm-7">
                <select name="activity_amount" id="activity_amount" class="form-control">
                    <option value=""></option>
                    @foreach (config('constants.ACTIVITY_AMOUNT_ARR') as $index => $ACTIVITY_AMOUNT)
                        <option value="{{ $index }}" {{ old('activity_amount', isset($userProfile)?strval($userProfile->activity_amount):'') === strval($index)? "selected": ""}}>{{ $ACTIVITY_AMOUNT['text'] }}</option>
                    @endforeach
                </select>
            </div>
            @if($errors->has('activity_amount'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('activity_amount') }}</b>
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
                <a class="btn btn-default btn-xs-block" href="{{ route('userProfile.read') }}">取消</a>
            </div>
        </div>
    </form>

@endsection