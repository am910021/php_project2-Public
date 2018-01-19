@extends('layouts.app')

@section('content')

    <div class="well">

            <a class="btn btn-primary" href="{{ route('userProfile.edit') }}">修改個人資料</a>
        <br><br>

                <p >
                    年齡: {{ $userProfile->age }}
                </p>
                <p >
                    身高: {{ $userProfile->height }}
                </p>
                <p >
                    體重: {{ $userProfile->weight }}
                </p>
                <p >
                    性別: {{ $userProfile->sexValue }}
                </p>
                <p>
                    活動量: {{ $userProfile->activityAmountValue }}
                </p>


</div>
@endsection