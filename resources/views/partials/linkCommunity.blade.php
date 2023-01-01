<div id="link-community" class="flex items-center py-2">
    <a class="text-base font-semibold" href= "/community/{{ $community->id }}">c/{{ $community->name }} </a>

    @if (Auth::check())
        @if( $userFollowCommunities->contains($community) )
            <button id="follow-button-{{$community->id}}" class="follow-button p-2 mr-0 ml-auto rounded-lg text-sm bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 font-medium" data-id="{{$community->id}}"> Followed </button>
        @else
            <button id="follow-button-{{$community->id}}" class="follow-button p-2 mr-0 ml-auto rounded-lg text-sm bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 font-medium" data-id="{{$community->id}}"> Follow </button>
        @endif
    @else
            <button class="border-2 self-end"> Follow </button>
    @endif
</div>
