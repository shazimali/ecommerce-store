@foreach (website()->social_medias as $sm)
<a class="mr-3 text-black dark:text-primary hover:text-primary py-2" target="_blank"
href="{{ $sm->url }}"><i class="{{ $sm->class }}"></i></a> 
@endforeach