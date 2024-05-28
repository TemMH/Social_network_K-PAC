<style>
    .dialog_field_right, .dialog_field_left {
        padding: 10px;
        margin: 10px 0;
    }
    .dialog_field_right {
        text-align: right;
        background-color: #f1f1f1;
    }
    .dialog_field_left {
        text-align: left;
        background-color: #e1e1e1;
    }
</style>

<h1>{{ $user->name }} - {{ $recipient->name }}</h1>
@foreach ($messages as $message)
    @if ($message->sender_id === $user->id)
        <div class="dialog_field_right">
            <div class="dialog_field_right_rama">

                <div class="dialog_field_right_content">
                    <div>
                        <p>{{ $user->name }}</p> <p>{{ $message->created_at }}</p>
                    </div>
                    <div>
                        {!! $message->message !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="dialog_field_left">
            <div class="dialog_field_left_rama">

                <div class="dialog_field_left_content">
                    <div>
                        <p>{{ $recipient->name }}</p> <p>{{ $message->created_at }}</p>
                    </div>
                    <div>
                        {!! $message->message !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach