@extends('layout.app')

@section('content')
@if(Session::get('msg') == 'imported')
<div class="alert alert-success alert-block">
    Your Have Imported Users Successfully.
</div>                                
@endif
<h1>Users</h1>
<a class="btn btn-primary btn-sm mb-3" href={{route('importNewAzureUser')}}>Import New User</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Department</th>
      <th scope="col">jobTitle</th>
    </tr>
  </thead>
  <tbody>
    @isset($users)
      @foreach($users as $user)
        <tr>
          <td>{{ $user->displayName }}</td>
          <td>{{ $user->userPrincipleName }}</td>
          <td>{{ $user->department }}</td>
          <td>{{ $user->jobTitle }}</td>
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
@endsection