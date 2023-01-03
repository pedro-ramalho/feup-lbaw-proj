<nav id="sort" class="sort">
	<form class="flex bg-gray-500 rounded-md text-xl text-white p-4 gap-x-12 border border-gray-600 font-semibold"> 
		<a href="{{ route('hot') }}" class="flex gap-x-3 items-center p-2 hover:bg-gray-700 rounded-md"> 
			<i class="fa fa-fire"></i>
			<p>Hot</p>
		</a>
		<a href="{{ route('new') }}" class="flex gap-x-3 items-center p-2 hover:bg-gray-700 rounded-md"> 
			<i class="fa-solid fa-certificate"></i>
			<p>New</p>
		</a>
		<a href="{{ route('top') }}" class="flex gap-x-3 items-center p-2 hover:bg-gray-700 rounded-md"> 
			<i class="fa-solid fa-chart-line"></i>
			<p>Top</p>
		</a>
	</form>
</nav>