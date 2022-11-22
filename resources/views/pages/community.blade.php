@extends('layouts.app')
<?php
use App\Models\Community;
?>

@section('content')

  <div id="community-container">
    @include('partials.communityinfo', ['community' => $community])
    
    <nav id="community-options">
      
        @include('partials.aboutcommunity', ['community' => $community])
    
        @include('partials.communityrules', ['community' => $community])    
  
    </nav>
    <div id="community-data">
      @include('partials.communitydata', ['community' => $community])
    </div>
  </div>

@endsection