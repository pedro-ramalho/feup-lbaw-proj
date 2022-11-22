<form method="POST" action="{{ route('edit', $user->id) }}" id="edit-profile">
  {{ csrf_field() }}
  <label for="biography">Biography</label>
  <input id="biography" type="text" name="biography" value="{{ $user->biography }}" required autofocus>
  <button type="submit">Edit</button>
</form>