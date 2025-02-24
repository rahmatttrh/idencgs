@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '500')
@section('message', $exception->getMessage() . ' line: ' . __LINE__ )
