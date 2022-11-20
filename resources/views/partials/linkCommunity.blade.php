<div id="linkCommunity">
    <a href= "/community/{{ $community->id }}">c/{{ $community->name }} </a>
    @if( $userFollowCommunities->contains($community) )
    <form>
        <button> Followed </button>
    </form>
    @else
    <form>
        <button> Follow </button>
    </form>
    @endif
</div>
