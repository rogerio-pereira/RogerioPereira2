@extends('errors.layout')

@section('title', 'Something went wrong')
@section('status', 'Server error')
@section('code', '500')
@section('heading', 'Something went wrong')
@section('message', 'This is an error on my side. Try again in a moment.')
@section('action', 'Back to home')
