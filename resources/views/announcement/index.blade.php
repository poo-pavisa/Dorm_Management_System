<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcement</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    body {
      background-color: #f8f9fa; 
    }
    .post-card {
      background-color: #ffffff; 
      border-radius: 10px; 
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
      margin-top:30px;
      margin-bottom: 50px; 
    }
    .post-card .card-body {
      padding: 20px; 
    }
    .post-card img.profile-img {
      border-radius: 50%; 
      max-width: 50px; 
      height: auto;
      display: block; 
      position: absolute; 
      top: 15px;
      left: 10px;
    }
    .post-card .post-meta {
      font-size: 0.9rem; 
      color: #6c757d; 
      text-align: left; 
      margin-left: 50px; 
      margin-top: auto; 
    }
    .post-card .post-meta p {
      margin-bottom: 0; 
    }
    .post-card img {
        border-radius: 10px; 
        max-width: 60%; 
        margin: 0 auto; 
        object-fit: cover;
    }

    .comment-toggle-btn {
      margin-top: 10px;
    }
    .comment-section {
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 10px;
        margin-top: 20px;
    }

    .comment {
        margin-bottom: 15px; 
        border-bottom: 1px solid #ccc;
        padding-bottom: 15px; 
    }

    .comment-form {
        margin-top: 20px;
    }

    .comment-form label {
        margin-bottom: 5px; 
    }

    .comment-form textarea {
        resize: none;
    }

    .comment-form button {
        margin-top: 10px; 
    }
    img.comment-img {
        border-radius: 50%; 
        max-width: 50px; 
        height: auto;
        top: 15px;
        left: 10px;
        margin-right: 10px;
    }

  </style>
    @include('home.css')

</head>
<!-- body -->
<body class="main-layout">
  <main class="container mt-4">
    <div class="loader_bg">
       <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>
    <!-- end loader -->
    <!-- header -->
<header>
    @include('home.header')
</header>
    <!-- Main content -->
    <div class="row justify-content-center mt-4 ">
      <div>
        @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{session()->get('success')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
      <!-- Post -->
      @if($posts->isEmpty())
        <div class="alert alert-info text-center py-5 mb-5"  role="alert">
          <h1 class="mb-0">No Announcement Yet.</h1>
        </div>
      @else
        @foreach($posts as $post)
        <div class="col-md-8">
          <!-- Post Card -->
          <div class="post-card position-relative">
          <img src="{{ $post->admin->profile_photo_path ? asset('storage/' . $post->admin->profile_photo_path) : asset('images/avatar.png') }}" class="profile-img mt-1">
            <div class="card-body">
              <div class="post-meta">
                <p style="font-weight:bold; font-size:18px;">{{$post->admin->name}}</p>
                <p>{{\Carbon\Carbon::parse($post->created_at)->toDayDateTimeString() }}</p>
              </div>
              <p style="font-weight:bold; font-size:22px; margin-top:40px;" class="card-title mb-4">{{$post->title}}</p>
              @if($post->image)
                  <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image">
              @endif
              <p class="card-text mt-5" style="font-size:18px;">{{$post->content}}</p>
              <!-- Comment Toggle Button -->
            @if($post->status_comment == 1)
              <button class="btn btn-info btn-block comment-toggle-btn mt-4" data-toggle="collapse" data-target="#commentSection{{$post->id}}" 
                  aria-expanded="false" aria-controls="commentSection{{$post->id}}" style="width:20%;" data-postid="{{$post->id}}">
                  <i class="fa-regular fa-comment-dots"></i>
                  Comments
              </button>
            @endif
            </div>
            <!-- Comment Section -->
            <div class="collapse comment-section" id="commentSection{{$post->id}}">
              <div class="card card-body">
                  <!-- Comments go here -->
                  @foreach($comments as $comment)
                  @if($comment->post_id == $post->id)
                      <div class="comment">
                          <!-- Profile Image and Name -->
                          <div class="d-flex align-items-center mb-2">
                              @if($comment->admin)
                                  <img src="{{ $comment->admin->profile_photo_path ? asset('storage/' . $comment->admin->profile_photo_path) : asset('images/avatar.png') }}" 
                                      alt="Profile Picture" class="comment-img me-2 mt-3 ml-2">
                                  <p class="mb-0">{{ $comment->admin->name }}</p>
                              @elseif($comment->user)
                                  <img src="{{ $comment->user->profile_photo_path ? asset('storage/' . $comment->user->profile_photo_path) : asset('images/avatar.png') }}" 
                                      alt="Profile Picture" class="comment-img me-2 mt-3 ml-2">
                                  <p class="mb-0">{{ $comment->user->name }}</p>
                              @endif
                              @if($comment->user_id == Auth::id())
                                  <a class="btn btn-danger btn-sm ml-1 mb-2 delete-btn" href="{{route('delete_comment',$comment->id)}}">
                                      <i class="fa-solid fa-xmark"></i>
                                  </a>
                              @endif
                          </div>
                          <!-- Created At -->
                          <p class="text-muted mb-2" style="margin-left:65px; margin-top:-30px;">{{ $comment->created_at->toDayDateTimeString() }}</p>
                          <!-- Comment Content -->
                          <p class="text-muted mt-4 ml-2" style="font-weight:bold; font-size:20px;">{{ $comment->content }}</p>
                      </div>
                  @endif
                  @endforeach
                  <!-- Form for new comment -->
                  <form class="comment-form" action="{{route('add_comment', $post->id)}}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="comment">Leave a comment:</label>
                          <textarea class="form-control" id="comment{{$post->id}}" name="content" rows="3"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      @endif
    </div>
    <div class="pagination-container">
      {{$posts->links("pagination::bootstrap-5")}}
    </div>
  </main>
    <!--  footer -->
    @include('home.footer')
    <!-- end footer -->
    <!-- Javascript files-->
    @include('home.jvs')
  <!-- Bootstrap 5 JS and dependencies -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var url = this.getAttribute('href');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to delete this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                        Swal.fire({
                        title: "Deleted!",
                        text: "Your comment has been deleted.",
                        icon: "success"
                      });
                    }
                });
            });
        });
    });
    $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to comment?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes, I'm sure",
                    denyButtonText:  "No, not sure",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).unbind('submit').submit()
                        Swal.fire({
                        title: "Success!",
                        text: "Your comment has been created.",
                        icon: "success"
                      });
                    } else if (result.isDenied) {
                        Swal.fire("Comment are not success ", "", "info");
                    }
                });
            });
        });
        
  </script>
</body>
</html>
