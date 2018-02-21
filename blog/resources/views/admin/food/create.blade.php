@extends('layouts.app')

@section('title')
    新增-{{ $category->name }}
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('admin.foodCreate',['id'=>$category->id]) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name')?"has-error":"" }}">
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">名稱</span>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="{{ old('name', '') }}">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-question">&nbsp;&nbsp;&nbsp;</span></span>
                  </div>
                  <small id="nameHelp" class="form-text text-muted">改名稱是既往不究的，除非使用者也修改了記錄。</small>
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
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">份量</span>
                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" aria-describedby="weightHelp" min="0"
                    value="{{ old('weight', '') }}">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-question">&nbsp;&nbsp;&nbsp;</span></span>
                  </div>
                  <small id="weightHelp" class="form-text text-muted">改份量是既往不究的，除非使用者也修改了記錄。</small>
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
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">單位</span>
                    <input type="text" class="form-control" id="unit" name="unit" aria-describedby="unitHelp"
                           value="{{ old('unit', '') }}">
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-question">&nbsp;&nbsp;&nbsp;</span></span>
                  </div>
                  <small id="unitHelp" class="form-text text-muted">改單位是既往不究的，除非使用者也修改了記錄。</small>
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
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">糖量</span>
                    <input type="number" step="0.01" class="form-control" id="sugar_gram" name="sugar_gram" aria-describedby="sugar_gramHelp" min="0"
                           value="{{ old('sugar_gram', '') }}">
                    <span class="input-group-addon">公克</span>
                  </div>
                  <small id="sugar_gramHelp" class="form-text text-muted">改糖量是既往不究的，除非使用者也修改了記錄。</small>
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
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">熱量</span>
                    <input type="number" step="0.01" class="form-control" id="kcal" name="kcal" aria-describedby="kcalHelp" min="0"
                           value="{{ old('kcal', '') }}">
                    <span class="input-group-addon">&nbsp;&nbsp;卡&nbsp;&nbsp;</span>
                  </div>
                  <small id="kcalHelp" class="form-text text-muted">改熱量是既往不究的，除非使用者也修改了記錄。</small>
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
        		<div class="col-sm-offset-1 col-sm-2">
        			<button type="submit" class="btn btn-primary btn-xs-block">送出</button>
        		</div>
        		<div class="col-sm-1 visible-xs" ><br></div>
        		<div class="col-sm-2">
        			<a class="btn btn-default btn-xs-block" href="{{ route('admin.foodShow',['id'=>$category->id]) }} ">取消</a>
        		</div>
        </div>
    </form>

@endsection

