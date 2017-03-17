@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            {{ __('generic.new') }}
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ url('/new') }}">
                        {{csrf_field() }}
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="submit">Go!</button>
                            </span>
                            <input type="text" name="name" class="form-control" placeholder="Add a domain...">
                        </div><!-- /input-group -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
