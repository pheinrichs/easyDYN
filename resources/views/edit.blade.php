@extends('layouts.app')

@section('content')

<div class="container ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            Edit
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
                    <form method="POST" action="{{ url('/edit/'.$item->id) }}">
                        {{csrf_field() }}
                        <input class="form-control" value="{{$item->name}}" disabled />
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="submit">Update!</button>
                            </span>
                            <input type="text" name="ip" class="form-control" placeholder="Add a domain..." value="{{$item->ip}}">
                        </div><!-- /input-group -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
