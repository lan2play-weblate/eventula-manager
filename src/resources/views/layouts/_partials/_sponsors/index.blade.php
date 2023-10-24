@if (!$event->sponsors->isEmpty())
    <div class="pb-2 mt-4 mb-4 border-bottom">
        <a name="sponsors"></a>
        <h3><i class="fas fa-running mr-3"></i>@lang('events.eventsponsoredby', ['event' => $event->display_name]) By Partial</h3>
    </div>
    <div class="card-deck">
        @foreach ($event->sponsors as $sponsor)
            <div class="card mb-4">
                <a href="{{ $sponsor->website }}" class="text-decoration-none">
                    <picture class="card-img-top">
                        <source srcset="{{ $sponsor->image_path }}.webp" type="image/webp">
                        <source srcset="{{ $sponsor->image_path }}" type="image/jpeg">
                        <img src="{{ $sponsor->image_path }}" alt="{{ $sponsor->name }}" class="img-fluid"/>
                    </picture>
                    <div class="card-footer">
                        <h1><span class="badge">Gold</span><h1>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif
