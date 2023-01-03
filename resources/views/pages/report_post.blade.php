@extends('layouts.app')


@section('content')
    <form action="{{ route('submit_report', $post->id)}}" method="post" id="report-post">
    {{ csrf_field() }}
        <p id="header">Report post:</p>
        <p id="question">In what terms do you consider this post to violate the guidelines?</p>
        <div id="checkboxes">
            <ul>
                <li><input type="radio" class="largecheckbox" name="reason" value="Breaks Community Rules"> Breaks Community Rules</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Breaks Rabbit TOS"> Breaks Rabbit TOS</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Explicit Content"> Explicit Content</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Hate Speech"> Hate Speech</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Sharing Personal Information"> Sharing Personal Information</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Spam"> Spam</li>
                <li><input type="radio" class="largecheckbox" name="reason" value="Misinformation"> Misinformation</li>
            </ul>
        </div>
        <button type="submit">Save</button>
        
    </form>
@endsection
