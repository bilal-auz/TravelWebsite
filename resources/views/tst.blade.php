<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $newReview->country_code }}</h1>
    @foreach ($newReview->country_review as $review)
        <p>UserName:{{ $review->userName }}</p>
        <p>Review:{{ $review->review_body }}</p>
        <hr>
    @endforeach
</body>
</html>