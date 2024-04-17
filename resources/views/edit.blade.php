<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container mt-3">
        <h2>Stacked form</h2>
        <form action="{{ route('chatgpt.create.continue') }}" method="POST">
            @csrf
            <input type="text" name="thread_id" value="{{ $thread_id }}"hidden >
            <input type="text" name="id" value="{{ $id }}"hidden >
            <input type="text" name="assistant_id" value="{{ $assistant_id }}"hidden >
            <div class="mb-3 mt-3">
                <label for="email">Chat:</label>
                <input type="text" class="form-control" id="content" placeholder="Enter chat" name="promt">
            </div>
            <div class="mb-3 mt-3">
                <label for="email">Instructions:</label>
                <input type="text" class="form-control" id="content" placeholder="Enter instructions" name="instructions">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    @forelse ($data as $key => $item)
        <div class="question">
            <p>user: {{ $item->content }}</p>
        </div>
        <div class="answer">
            <p>chatGpt: {{ $item->answers->content }}</p>
        </div>
    @empty

    @endforelse

    {{-- @foreach ($data as $thread => $item)
        <div class="thread">
            <h1>title: {{ $item->title }}</h1>
            @foreach ($item->questions as $question)
                <div class="question">
                    <p>user: {{ $question->content }}</p>
                    <p>chatGpt: {{ $question->answers->content }}</p>
                </div>
            @endforeach
        </div>
    @endforeach --}}

</body>

</html>
