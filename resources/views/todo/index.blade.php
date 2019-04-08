<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css')}}/styles.css">

</head>

<body>

    <div id="myDIV" class="header">
        <h2 style="margin:5px">My To Do List</h2>
        <input type="text" id="myInput" placeholder="Title...">
        <span onclick="newElement()" class="addBtn">Add</span>
    </div>

    <ul id="myUL">
        @foreach($data as $todo)
        <li id="{{$todo->id}}" class="{{$todo->status == 1 ? 'checked' : ''}}">{{$todo->description}}</li>
        @endforeach
    </ul>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Create a "close" button and append it to each list item
    var myNodelist = document.getElementsByTagName("LI");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        myNodelist[i].appendChild(span);
    }

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function (element) {
            var div = this.parentElement;
            var id = $(this).parent().attr('id');
            var url ="{{ route('todo.destroy', ['']) }}"+ '/' + id
            $.ajax({
                url: url,
                type: 'delete',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function (result) {
                    div.style.display = "none";            
                }
            });
        }
    }

    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function (ev) {
        if (ev.target.tagName === 'LI') {
            var id = $(ev.target).attr('id');
            var status = 1;
            if($(ev.target).hasClass('checked'))
            {
                status = 0;
            }
            var url ="{{ route('todo.update', ['']) }}"+ '/' + id
            $.ajax({
                url: url,
                type: 'put',
                dataType: 'json',
                data: {
                    id: id,
                    status:status
                },
                success: function (result) {
                    ev.target.classList.toggle('checked');
                }
            });
        }
    }, false);

    // Create a new list item when clicking on the "Add" button
    function newElement() {
        var inputValue = document.getElementById("myInput").value;
        if(inputValue)
        {
            $.ajax({
                url: "{{ route('todo.store') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    description: inputValue,
                },
                success: function (result) {
                    var li = document.createElement("li");
                    var t = document.createTextNode(result.data.description);
                    li.appendChild(t);
                    document.getElementById("myUL").appendChild(li);
                    var span = document.createElement("SPAN");
                    var txt = document.createTextNode("\u00D7");
                    span.className = "close";
                    span.appendChild(txt);
                    li.appendChild(span);

                    for (i = 0; i < close.length; i++) {
                        close[i].onclick = function () {
                            var div = this.parentElement;
                            div.style.display = "none";
                        }
                    }
                }
            });
        }
    }

</script>

</html>
