@extends('app')
@section('title')
<?php echo '@' ?>{{ $user->name }}
@endsection
@section('content')
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <img src="{{$url.$user_profile->avatar_url}}" style="width:45%;" class="w3-round"><br><br>
    <h4><b>About</b></h4>
    <p class="w3-text-grey">{{$user_profile->bio}}</p>
  </div>
</nav>
<div class="font-white">
  <ul class="list-group">
    <li class="list-group-item">
      Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }} <br>
      Growing Since {{$user_profile->growing_since }} <br>
      {{$user_profile->age}} Years old <br>
    </li>
    <li class="list-group-item panel-body">
      <table class="table-padding">
        <style>
          .table-padding td{
            padding: 3px 8px;
          }
        </style>
        <tr>
          <td>Review Rep</td>
          <td> {{$prom_rev_rep}}</td>
       </tr>
       <tr>
         <td>Comment Rep</td>
         <td> {{$prom_comments_rep}}</td>
       </tr>
       <tr>
          <td>Published Reviews</td>
          <td> {{$reviews_count}} </td>
       </tr>
       <tr>
          <td>Published Comments</td>
          <td> {{$comments_count}}</td>
       </tr>
      </table>
      @if($profile_options)

      <hr />
      <tr>
        <a href="{{url('/user/'.Auth::id().'/edit')}}"> <button class="btn btn-primary" >Edit Profile </button></a>

      </tr>
      <a href="{{url('/user/delete/'.Auth::id().'')}}"><button class="btn btn-primary" > Delete profile </button></a>
      @endif
    </li>
  </ul>
</div>

<div>
  <ul class="list-group">
    <li class="list-group-item">
      <?php echo "@"; ?>{{$user->name}}'s Reviews
    </li>
    <li class="list-group-item panel-body">
      @if($reviews_count == 0)
      This user has no reviews yet :(
      @else

      @endif
    </li>
  </ul>
</div>

@endsection
