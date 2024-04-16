<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="mb-0">
       @forelse ($datas as $item)
           <a href="{{ route('chatgpt.edit', $item->id)}}">{{  $item->title  }}</a>
           <br>
       @empty
            <div class="">No Data</div>
       @endforelse
    </div>
</body>
</html>
