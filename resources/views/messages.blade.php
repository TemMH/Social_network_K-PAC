<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class="messages_main">
        <div class="message_left">

            <div class="messages_chats">
                <div class="messages_find">
                    <input type="text">
                </div>
                <div class="messages_all_chats">



                    <div class="messages_chat">

                        <div class="message_img_profile">
                            <img src="" alt="">
                        </div>
                        <div class="message_main_profile">
                            <div class="message_name"></div>
                            <div class="message_text"></div>
                        </div>
                        <div class="message_other_profile">
                            <div class="message_star"></div>
                            <div class="message_time"></div>
                        </div>

                    </div>



                </div>
            </div>
        </div>

        <div class="message_right">

            <div class="message_chat">

                <div class="message_top">

                    <div class="message_profile">


                        <div class="message_img">

                        </div>
                        
                        <div class="message_name">

                        </div>
                        <div class="message_friend">
                            {{-- либо с какого времени дружите
                        либо добавить в друзья --}}
                        </div>


                    </div>

                    <div class="message_other"></div>

                </div>




                <div class="message_main">


                    <div class="message_main_img">
                        <div class="message_img"></div>
                    </div>
                    <div class="message_main_center">

                        <div class="message_main_center_profile">
                            <div class="message_name"></div>
                            <div class="message_time"></div>
                        </div>

                        <div class="message_main_text"></div>

                    </div>





                </div>



                <div class="message_write"></div>
            </div>
        </div>

    </div>
</x-app-layout>


<!-- https://dribbble.com/shots/21805888-MessageApp-UI -->