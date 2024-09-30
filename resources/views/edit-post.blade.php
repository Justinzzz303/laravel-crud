<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Edit Post</h1>
    <form action="/edit-post/{{$post->id}}" method="post" class="mb-5">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{$post->title}}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea id="content" name="content" class="form-control" cols="30" rows="10" required>{{$post->content}}</textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="/" class="btn btn-secondary">Back</a> <!-- Back button -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</body>
</html>
