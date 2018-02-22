@extends('layouts.app')

@section('title')
   修改-{{ $food->name }}
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('admin.foodEdit',['id'=>$food->id]) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('category')?"has-error":"" }}">
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">類別</span>
                    <select name="category" id="category" class="form-control" aria-describedby="categoryHelp">
                      <option value=""></option>
                      @if(isset($categorys))
                        @foreach ($categorys as $category)
                            @if( $category->id==$food->category )
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                      @endif
                    </select>
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;<span class="fa fa-question">&nbsp;&nbsp;&nbsp;</span></span>
                  </div>
                  <small id="categoryHelp" class="form-text text-muted">除非你已經確認好，不然請不要更改類別。</small>
              </div>


            @if($errors->has('category'))
                <div class="col-sm-3">
                    <span class="help-block">
                        <b>{{ $errors->first('category') }}</b>
                    </span>
                </div>
            @endif
        </div>
        
        <div class="form-group {{ $errors->has('name')?"has-error":"" }}">
              <div class="col-sm-offset-1 col-sm-7">
                  <div class="input-group">
                    <span class="input-group-addon">名稱</span>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="{{ $food->name }}">
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
                    value="{{ $food->weight }}">
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
                           value="{{ $food->unit }}">
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
                           value="{{ $food->sugar_gram }}">
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
                           value="{{ $food->kcal }}">
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
        			<a class="btn btn-default btn-xs-block" href="{{ route('admin.foodShow',['id'=>$food->category]) }} ">取消</a>
        		</div>
        </div>
    </form>

@endsection

