@extends('front.layout')

@section('content')
<loading ref="loading"></loading>

<transition name="fade" mode="out-in">
    <router-view :key="$route.name"></router-view>
</transition>
@endsection
