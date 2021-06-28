<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $newReview->city_name }}</h1>
    @foreach ($newReview->city_review as $review)
        <p>UserName:{{ $review->userName }}</p>
        <p>Review:{{ $review->review_body }}</p>
        <hr>
    @endforeach
</body>
</html>