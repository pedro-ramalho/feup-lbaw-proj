<div id="link-community">
    <a href= "/community/{{ $community->id }}">c/{{ $community->name }} </a>


    @if (Auth::check())
        @if( $userFollowCommunities->contains($community) )
            <button id="follow-button-{{$community->id}}" class="follow-button" data-id="{{$community->id}}"> Followed </button>
        @else
            <button id="follow-button-{{$community->id}}" class="follow-button" data-id="{{$community->id}}"> Follow </button>
        @endif
    @else
            <button> Follow </button>
    @endif
</div>
