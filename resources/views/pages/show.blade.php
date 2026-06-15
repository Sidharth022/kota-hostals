<x-app-layout>
    <x-slot name="title">{{ $page->seo_title ?? $page->title }}</x-slot>
    <x-slot name="meta_description">{{ $page->seo_description }}</x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <article class="card border-0 shadow-soft p-4 p-md-5 rounded-3xl bg-white">
                    <!-- Header -->
                    <div class="border-bottom pb-4 mb-4">
                        <h1 class="font-outfit display-6 fw-extrabold text-dark tracking-tight mb-2">
                            {{ $page->title }}
                        </h1>
                        <span class="text-muted small">Last updated on {{ $page->updated_at->format('d M Y') }}</span>
                    </div>

                    <!-- Page content markup -->
                    <div class="text-secondary small leading-relaxed space-y-4">
                        {!! $page->content !!}
                    </div>
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
