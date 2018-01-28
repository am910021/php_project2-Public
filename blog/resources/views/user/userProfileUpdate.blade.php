@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('userProfile.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group {{ $errors->has('age')?"has-error":"" }}">
            <label for="age" class="col-sm-1 control-label"></label>
            <div class="col-sm-7">
              <div class="input-group">
              	<span class="input-group-addon">&nbsp;年&nbsp;&nbsp;&nbsp;齡&nbsp;</span>
                <input type="text" class="form-control" id="age" name="age"
                       value="{{ old('age', isset($userProfile)?$userProfile->age:'') }}">
                <div class="input-group-addon">&nbsp;&nbsp;歲&nbsp;&nbsp;&nbsp;</div>
              </div>
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
            <label for="height" class="col-sm-1 control-label"></label>
            <div class="col-sm-7">

              <div class="input-group">
              	<span class="input-group-addon">&nbsp;身&nbsp;&nbsp;&nbsp;高&nbsp;</span>
                <input type="number" class="form-control" id="height" name="height"
                       value="{{ old('height', isset($userProfile)?$userProfile->height:'') }}">
                <span class="input-group-addon">公分</span>
              </div>
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
            <label for="weight" class="col-sm-1 control-label"></label>
            <div class="col-sm-7">

              <div class="input-group">
              	<span class="input-group-addon">&nbsp;體&nbsp;&nbsp;&nbsp;重&nbsp;</span>
                <input type="number" step="0.01" class="form-control" id="weight" name="weight"
                       value="{{ old('weight', isset($userProfile)?$userProfile->weight:'') }}">
                <span class="input-group-addon">公斤</span>
              </div>
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
            <label for="sex" class="col-sm-1 control-label"></label>
            <div class="col-sm-7">
              <div class="input-group">
              	<span class="input-group-addon">&nbsp;性&nbsp;&nbsp;&nbsp;別&nbsp;</span>
                <select name="sex" id="sex" class="form-control">
                    <option value=""></option>
                    @foreach (config('constants.SEX_ARR') as $index => $SEX)
                        <option value="{{ $index }}" {{ old('sex', isset($userProfile)?strval($userProfile->sex):'') === strval($index)? "selected": ""}}>{{ $SEX }}</option>
                    @endforeach
                </select>
                <span class="input-group-addon">&nbsp;&nbsp;<span class="fa fa-id-card-o">&nbsp;&nbsp;</span></span>
              </div>
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
            <label for="activity_amount" class="col-sm-1 control-label"></label>
            <div class="col-sm-7">

              <div class="input-group">
              <span class="input-group-addon">活動量</span>
                <select name="activity_amount" id="activity_amount" class="form-control">
                    <option value=""></option>
                    @foreach (config('constants.ACTIVITY_AMOUNT_ARR') as $index => $ACTIVITY_AMOUNT)
                        <option value="{{ $index }}" {{ old('activity_amount', isset($userProfile)?strval($userProfile->activity_amount):'') === strval($index)? "selected": ""}}>{{ $ACTIVITY_AMOUNT['text'] }}</option>
                    @endforeach
                </select>
                <span class="input-group-addon">&nbsp;&nbsp;<span class="fa fa-id-card-o">&nbsp;&nbsp;</span></span>
              </div>
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
            <div class="col-sm-offset-1 col-sm-3">
                <button type="submit" class="btn btn-primary btn-xs-block">送出</button>
                <br>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary btn-success btn-xs-block" href="{{ route('user') }}">取消</a>
            </div>
        </div>
    </form>
<div class="row">
  <div class="col-md-6 well">
    <h3>
      低
    </h3>
    <div class="row ">
      <div class="col-md-6">
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            生活動作
          </div>
          <div class="col-xs-6 col-md-6">
            時間(小時)
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            安靜
          </div>
          <div class="col-xs-6 col-md-6">
            12
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            站立
          </div>
          <div class="col-xs-6 col-md-6">
            11
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            步行
          </div>
          <div class="col-xs-6 col-md-6">
            1
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            快走
          </div>
          <div class="col-xs-6 col-md-6">
            0
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            肌肉運動
          </div>
          <div class="col-xs-6 col-md-6">
            0
          </div>
        </div>
        <br>
      </div>

      <div class="col-md-6 bg-success">
        <div class="row ">
          <div class="col-md-12">
            日常生活的內容
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            靜態活動，睡覺、靜臥或悠閒的坐著(例如:坐著看書、看電視…等等)。
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="col-md-6 well">
    <h3>
      稍低
    </h3>
    <div class="row ">
      <div class="col-md-6">
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            生活動作
          </div>
          <div class="col-xs-6 col-md-6">
            時間(小時)
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            安靜
          </div>
          <div class="col-xs-6 col-md-6">
            10
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            站立
          </div>
          <div class="col-xs-6 col-md-6">
            9
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            步行
          </div>
          <div class="col-xs-6 col-md-6">
            5
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            快走
          </div>
          <div class="col-xs-6 col-md-6">
            0
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            肌肉運動
          </div>
          <div class="col-xs-6 col-md-6">
            0
          </div>
        </div>
        <br>
      </div>


      <div class="col-md-6 bg-success">
        <div class="row ">
          <div class="col-md-12">
            日常生活的內容
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            站立活動，身體活動程度較低、熱量較少，例如:站著說話、烹飪、開車、打電腦。
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6 well">
    <h3>
      適度
    </h3>
    <div class="row ">
      <div class="col-md-6">
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            生活動作
          </div>
          <div class="col-xs-6 col-md-6">
            時間(小時)
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            安靜
          </div>
          <div class="col-xs-6 col-md-6">
            9
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            站立
          </div>
          <div class="col-xs-6 col-md-6">
            8
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            步行
          </div>
          <div class="col-xs-6 col-md-6">
            6
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            快走
          </div>
          <div class="col-xs-6 col-md-6">
            1
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            肌肉運動
          </div>
          <div class="col-xs-6 col-md-6">
            0
          </div>
        </div>
        <br>
      </div>

      <div class="col-md-6 bg-success">
        <div class="row ">
          <div class="col-md-12">
            日常生活的內容
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            身體活程度為正常速度、熱量消耗較少，例如:在公車或捷運上著、用洗衣機洗衣服、用吸塵器打掃、散步、購物...等強度。
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="col-md-6 well">
    <h3>
      高
    </h3>
    <div class="row ">
      <div class="col-md-6">
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            生活動作
          </div>
          <div class="col-xs-6 col-md-6">
            時間(小時)
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            安靜
          </div>
          <div class="col-xs-6 col-md-6">
            9
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            站立
          </div>
          <div class="col-xs-6 col-md-6">
            8
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            步行
          </div>
          <div class="col-xs-6 col-md-6">
            5
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            快走
          </div>
          <div class="col-xs-6 col-md-6">
            1
          </div>
        </div>
        <div class="row bg-info">
          <div class="col-xs-6 col-md-6">
            肌肉運動
          </div>
          <div class="col-xs-6 col-md-6">
            1
          </div>
        </div>
        <br>
      </div>
      <div class="col-md-6 bg-success">
        <div class="row ">
          <div class="col-md-12">
            日常生活的內容
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            站立活動，身體活動程度較低、熱量較少，例如:站著說話、烹飪、開車、打電腦。
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection