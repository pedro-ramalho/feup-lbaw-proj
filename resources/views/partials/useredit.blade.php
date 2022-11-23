<form method="POST" action="{{ route('edit', $user->id) }}" id="edit-profile">
  {{ csrf_field() }}
    <div id="ue-bio">
      <label for="biography">Biography</label>
      <textarea id="biography" name="biography" required autofocus> {{ $user->biography }} </textarea>
    </div>
    <button type="submit">Save</button>
</form>