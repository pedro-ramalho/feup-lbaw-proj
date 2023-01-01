<nav id="pop-c" class="flex flex-col text-white ml-8">
    <h2 class="text-base p-2 font-semibold bg-gray-800 rounded-t-md">POPULAR COMMUNITIES</h2>
    <div id="pop-bottom" class="p-2 bg-gray-700 rounded-b-md">
        @foreach ($communities as $community)
            @include('partials.linkCommunity', ['community' => $community, 'userFollowCommunities' => $userFollowCommunities])
        @endforeach
    </div>
</nav>