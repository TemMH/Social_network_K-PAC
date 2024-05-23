<x-app-layout>
    <x-slot name="header">

    </x-slot>




    <div class="main_spec_dialog">
        <div class="dialog_field">
            <div class="field">
                @foreach ($messages as $message)
                    @if ($message->sender_id === auth()->id())
                        <!-- Сообщения отправителя -->
                        <div class="dialog_field_right">
                            <div class="dialog_field_right_rama">
                                <div class="dialog_field_right_content">
                                    <div>
                                        <p class="txt_2">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="txt_2">
                                        {!! $message->content !!}
                                    </div>
                                </div>
                                <div class="dialog_img_ava">
                                    <img class="avatar" src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="Avatar">
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Сообщения получателя -->
                        <div class="dialog_field_left">
                            <div class="dialog_field_left_rama">
                                <div class="dialog_img_ava">
                                    <img class="avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                                </div>
                                <div class="dialog_field_left_content">

                                    <div>
                                        <p class="txt_2">{{ $user->name }}</p> <p>{{ $message->created_at }}</p>
                                    </div>
                                    <div class="txt_2">
                                        {!! $message->content !!}


                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <form action="{{ route('dialog.send', $user->id) }}" method="POST">
            @csrf
            <div class="dialog_send">
                <div>
                    <textarea class="dialog_newtextarea" id="message" type="text" name="message" required autofocus
                        autocomplete="message"></textarea>
                </div>
                <div>
                </div>
                <div>
                    <button class="btn_dialog" type="submit" ><p class="txt_2">Отправить</p></button>
                </div>
            </div>
        </form>
    </div>





</x-app-layout>
