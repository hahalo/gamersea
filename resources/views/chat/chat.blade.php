@extends('layouts.app')
<head>
    <style>
        html, body {
            height: 100%;
        }
        #chat-room {
            border: 1px solid #ccc;
            height: 20rem;
            padding: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        #send-message {
            margin-top: -1px;
        }
        .input-group-addon {
            border-top-left-radius: 0;
        }
        .input-group-btn > .btn {
            border-top-right-radius: 0;
        }
    </style>
</head>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <h1>Chat Room</h1>
                    <!-- 訊息列表框 -->
                    <div id="chat-room">
                    </div>
                    <!-- 輸入訊息的表單 -->
                    <form id="send-message" method="post" action="/send-message">
                        {!! csrf_field() !!}
                        <input type="hidden" name="username" value="{{ Auth::user()->nick_name?Auth::user()->nick_name:Auth::user()->name }}" />
                        <div class="input-group">
                            <label class="input-group-addon">{{ Auth::user()->nick_name?Auth::user()->nick_name:Auth::user()->name  }}</label>
                            <input id="message" name="message" type="text" value="" class="form-control" />
                            <span class="input-group-btn">
                        <button class="btn btn-success" id="send">Send</button>
                    </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <script src="https://cdn.bootcss.com/socket.io/1.7.3/socket.io.js"></script>
    <script>
        'use strict';
        var $chatRoom = $('#chat-room');
        var $sendMessage = $('#send-message');
        var $messageInput = $sendMessage.find('input[name=message]');
        var io = window.io;
        var socket = io('http://192.168.200.98:6001');
        // 當送出表單時，改用 Ajax 傳送，並清空輸入框。
        $sendMessage.on('submit', function () {
            console.log($sendMessage.serialize());
            $.post(this.action, $sendMessage.serialize());
            $messageInput.val('');
            return false;
        });
        // 當接收到訊息建立的事件時，將接收到的 payload
        socket.on('chat-channel:App\\Events\\SomeEvent', function (payload) {
            var html = '<div class="message alert-info" style="display: none;">';
            html += payload.username + ': ';
            html += payload.message;
            html += '</div>';
            var $message = $(html);
            $chatRoom.append($message);
            $message.fadeIn('fast');
            $chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);
        });
    </script>
@endsection









