{{-- <a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
href="https://www.facebook.com/everydayoffcl"><i class="fa-brands fa-facebook"></i></a>
<a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
href="https://www.instagram.com/everydayoffcl/"><i class="fa-brands fa-instagram"></i></a>
<a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
href="https://twitter.com/EverydayOffcl"><i class="fa-brands fa-x-twitter"></i></a>
<a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
href="https://youtube.com/@everydayoffcl"><i class="fa-brands fa-youtube"></i></a> --}}
@foreach (website()->social_medias as $sm)
<a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
href="{{ $sm->url }}"><i class="{{ $sm->class }}"></i></a> 
@endforeach