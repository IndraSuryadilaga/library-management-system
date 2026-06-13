@props(['book'])

<div class="bg-cream-100 rounded-card shadow-card p-4 flex flex-col">
    <a href="{{ route('show.book', $book) }}" class="flex-grow">
        <img src="{{ $book->cover }}" alt="Cover of {{ $book->title }}" class="rounded-md mb-4 aspect-[2/3] object-cover w-full">
        <h3 class="font-semibold text-bark-600 truncate" title="{{ $book->title }}">{{ $book->title }}</h3>
    </a>
    <p class="text-sm text-dusty">{{ $book->author->name }}</p>
</div>
