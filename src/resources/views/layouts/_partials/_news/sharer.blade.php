<a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/news') }}/{{ $newsArticle->slug }}&t={{ $newsArticle->title }}" target="_blank" rel="noreferrer">
    <i class="fab fa-facebook-f"></i>
</a>
<a href="http://twitter.com/share?text={{ $newsArticle->title }}&url={{ url('/news') }}/{{ $newsArticle->slug }}&hashtags={{ $newsArticle->getTags(',') }}" target="_blank" rel="noreferrer">
    <i class="fab fa-twitter"></i>
</a>