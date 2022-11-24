@extends('layouts.app')

<?php use App\Models\ReportInformation;
  use Illuminate\Support\Facades\DB;
  $all_reports = ReportInformation::where(DB::raw(1), '=', 1);
  $post_reports = $all_reports->join('content', 'report_information.id_content', '=', 'content.id');
  $post__reports = $post_reports->where('content.is_post', true)->get();
  $comment__reports = $post_reports->where('content.is_post', false)->get();
?>

@section('content')

<section id="admin-content">
  <section id="reports">
    <section id="report-posts">
      <h2>Post Reports</h2>
      <table>
          <tr>
            <th>Content ID</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Reason</th>
            <th>Date</th>
          </tr>
        <tbody>
          @each('partials.reportposts', $post__reports, 'report')
        </tbody>
      </table>
    </section>
    <section id="report-comments">
      <h2>Comment Reports</h2>
      <table>
        <tr>
          <th>Content ID</th>
          <th>User ID</th>
          <th>Username</th>
          <th>Reason</th>
          <th>Date</th>
        </tr>
        <tbody>
          @each('partials.reportposts', $comment__reports, 'report')
        </tbody>
      </table>
    </section>
  </section>
  <section id="manage-users">
    <h2>Delete a User</h2>
    <form method="POST" action="{{ route('admin') }}">
      {{ csrf_field() }}
      <label for="username">Username</label>
        <input id="username" type="text" name="username" required autofocus>
      <button type="submit">Delete</button>
    </form>
    <h2>Create a User</h2>
    <form method="POST" action="{{ route('handleAdminCreateUser') }}" class="auth-form">
      {{ csrf_field() }}

      <label for="usrname">Username</label>
      <input id="usrname" type="text" name="username" value="{{ old('username') }}" required autofocus>
      @if ($errors->has('username'))
        <span class="error">
            {{ $errors->first('username') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required>

      <div id="signin-signup-container">
        <button type="submit">
          Create
        </button>
      </div>
    </form>
  </section>

  </section>
</section>
@endsection('content')
