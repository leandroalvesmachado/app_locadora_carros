@extends('layouts.app')

@section('content')
    <login token-csrf="{{ @csrf_token() }}"></login>
@endsection
