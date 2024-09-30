<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container mt-5">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"> <!-- Aligns "Welcome" to the left -->
                    @auth
                        <li class="nav-item">
                            <h5><span class="nav-link text-primary">Hello,{{ auth()->user()->name }}</span></h5>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto"> <!-- Aligns "Log Out" to the right -->
                    @auth
                        <li class="nav-item">
                            <form action="/logout" method="post" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit">Log Out</button> <!-- Styled as a small danger button -->
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @auth  
        <h2>Create New Post</h2>
        <form action="/create-post" method="post" class="mb-5">
            @csrf
            <div class="mb-3">
                <input type="text" name="title" placeholder="Title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <textarea name="content" cols="30" rows="10" placeholder="Content..." class="form-control" required>{{ old('content') }}</textarea>
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

        <h2>List of Posts</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>
                            <a href="/edit-post/{{ $post->id }}" class="btn btn-warning" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="/delete-post/{{ $post->id }}" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" title="Delete"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h2>Registration</h2>
        <form action="/register" method="post" class="mb-5">
            @csrf
            <div class="mb-3">
                <input name="name" type="text" placeholder="Name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <input name="email" type="text" placeholder="Email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <input name="password" type="password" placeholder="Password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Register</button>
        </form>

        <h2>Login</h2>
        <form action="/login" method="post" class="mb-5">
            @csrf
            <div class="mb-3">
                <input name="loginname" type="text" placeholder="Name" class="form-control" value="{{ old('loginname') }}" required>
            </div>

            <div class="mb-3">
                <input name="loginpassword" type="password" placeholder="Password" class="form-control" required>
            </div>

            <!-- Display login error -->
            @if(session('loginerror'))
                <div class="alert alert-danger">{{ session('loginerror') }}</div>
            @endif

            <button class="btn btn-primary">Log in</button>
        </form>
    @endauth
</body>
</html>
