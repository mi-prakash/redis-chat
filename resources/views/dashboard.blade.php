<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.2/socket.io.js"></script>
    <style>
        textarea {
            width: 100%;
        }
        #messages, input, textarea {
            border-radius: 5px;
        }
        .btn-success {
            background-color: #5046e5;
            padding: 5px 15px;
            border-radius: 5px;
            color: #ffffff;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat Module') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Chat Message Module</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8" >
                                    <div id="messages" style="border: 1px solid #121212; margin-bottom: 5px; height: 250px; padding: 2px; overflow: scroll;"></div>
                                </div>
                                <div class="col-lg-8" >
                                    <form action="sendmessage" method="POST">
                                        @csrf
                                        <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                        <textarea class="form-control message"></textarea>
                                        <br/>
                                        <input type="button" value="Send" class="btn-success" id="send-message">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var socket = io.connect('http://localhost:8890');
        socket.on('message', function (data) {
            data = jQuery.parseJSON(data);
            $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
        });
        $("#send-message").click(function(e){
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var user = $("input[name='user']").val();
            var message = $(".message").val();
            if(message != ''){
                $.ajax({
                    type: "POST",
                    url: '{!! URL::to("sendmessage") !!}',
                    dataType: "json",
                    data: {'_token':_token, 'message':message, 'user':user},
                    success:function(data) {
                        $(".message").val('');
                    }
                });
            }
        })
    </script>
</x-app-layout>
