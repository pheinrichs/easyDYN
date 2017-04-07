@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            {{ __('generic.domains') }}
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-info form-control" href="{{ url('/new') }}">
                                {{ __('generic.add') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <td>
                                {{ __('generic.name') }}
                            </td>
                            <td>
                                IP
                            </td>
                            <td class="hidden-xs hidden-sm">

                                {{ __('generic.token') }}
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md">

                                {{ __('generic.created') }}
                            </td>
                            <td class="hidden-xs  hidden-md">

                                {{ __('generic.updated') }}
                            </td>
                            <td>

                                {{ __('generic.options') }}
                            </td>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr  class="accordion-toggle @if($domain->active == 0) danger @endif">
                                <td>
                                    {{$domain->name}}
                                </td>
                                <td>
                                    {{$domain->ip}}
                                </td>
                                <td class="hidden-xs hidden-sm">
                                    {{$domain->token}}
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md">
                                    {{$domain->created_at}}
                                </td>
                                <td class="hidden-xs  hidden-md">
                                    {{$domain->updated_at}}
                                </td>
                                <td>
                                    <div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown">{{ __('generic.actions') }}
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                          <li>
                                              <a href='{{ url("/toggle/$domain->id")}}'>@if($domain->active == 1) Disable @else Enable @endif</a>
                                          </li>
                                           <li>
                                               <a href="{{url('/edit/'.$domain->id)}}">Edit</a>
                                           </li>
                                          <li>
                                              <a class="open-modal" data-toggle="modal" data-target="#myModal" data-url-link='{{ url("/api/domain/$domain->name/$domain->token")}}'>{{ __('generic.gen') }}</a>
                                          </li>
                                        <li><a href='{{url("/delete/$domain->id")}}' onclick="return confirm('Are you sure you want to delete this item?');">{{ __('generic.delete') }}</a></li>
                                      </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $domains->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">URL</h4>
      </div>
      <div class="modal-body">
          <input id="url" class="form-control"  value="" onClick="this.setSelectionRange(0, this.value.length)"  readonly="readonly"/>
      
          <label>Mikrotik Console Command</label>
          <textarea readonly="readonly" id="command" onClick="this.setSelectionRange(0, this.value.length)" class="form-control">

          </textarea>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--

-->
@endsection

@section('script')
    <script type="text/javascript">
    $('#myModal').on('show.bs.modal', function(e) {
        console.log('test');
        var urlID = $(e.relatedTarget).data('url-link');
        $('#url').val(urlID);
        $('#command').val("system script add source=\"/tool fetch url='"+urlID+"' mode=https keep-result=no\" name=ddns \n system scheduler add start-time=startup interval=1800 on-event=ddns name=DNSScheduler \n");
    });
    </script>
@endsection


