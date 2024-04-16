<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Stacked form</h2>
        <form action="{{ route('chatgpt.create') }}" method="POST">
            @csrf
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

</body>

</html>
