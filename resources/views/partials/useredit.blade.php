<div id="edit" class="flex flex-col items-center mt-4 gap-y-4">
  <h1 class="text-2xl font-bold">Edit your profile</h1>
  <form method="POST" action="{{ route('edit', $user->id) }}" id="edit-profile" class="flex flex-col gap-y-4" enctype="multipart/form-data">
    {{ csrf_field() }}
      <div id="edit-pfp" class="flex flex-col gap-y-2">
        <div id="edit-pfp-icons" class="flex items-center gap-x-2 text-xl">
          <i class="fa-solid fa-pen-to-square"></i>
          <label for="pfp">Edit your profile picture</label>
        </div>
        <img src="{{ url(get_pfp_path(Auth::user()->id)) }}" class="profile-pfp rounded-full border-2 border-gray-700">
        <input type="file" id="pfp" name="pfp" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-gray-700 file:text-white
                                  hover:file:bg-gray-800">
      </div>
      <div id="ue-bio" class="flex flex-col gap-y-2">
        <div id="edit-bio-icons" class="flex items-center gap-x-2 text-xl">
          <i class="fa-solid fa-book-open"></i>
          <label for="biography">Edit your biography</label>
        </div>
        <textarea id="biography" class="p-2 bg-gray-200 border border-gray-300 rounded-md " name="biography" required autofocus> {{ $user->biography }} </textarea>
      </div>
      <button class="p-1 bg-green-500 border border-green-600 hover:bg-green-600 hover:cursor-pointer rounded-md w-full font-semibold text-white" type="submit">Save</button>
      <a href="{{ route('delete', Auth::id()) }}" class="p-1 bg-red-500 border border-red-600 hover:bg-red-600 hover:cursor-pointer rounded-md w-full font-semibold text-white text-center">Delete your account</a>
  </form>
</div>