<div class="card shadow">
    <div class="card-body">
        <!-- Start and End Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div>
                        <p><i class="fas fa-calendar-alt mr-2"></i> @lang('events.start')</p>
                        <h3>{{ date('d.M Y', strtotime($event->start)) }} @lang('events.time_delimiter')
                            {{ date('H:i', strtotime($event->start)) }} @lang('events.time_suffix')</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div>

                        <p><i class="fas fa-calendar-times mr-2"></i> @lang('events.end')</p>
                        <h3>{{ date('d.M Y', strtotime($event->end)) }} @lang('events.time_delimiter')
                            {{ date('H:i', strtotime($event->end)) }} @lang('events.time_suffix')</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div>

                        <p><i class="fas fa-chair mr-2"></i> @lang('events.seatingcapacity')</p>
                        <h3>{{ $event->capacity }} @lang('events.seating')</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Description -->
        <div class="row">
            <div class="col-12">
                <p>{{ $event->desc_long }}</p>
            </div>
        </div>

        <!-- ICS Date Saver -->
        <div class="row">
            <div class="col-12">
                <a href="{{ route('generate-event-ics', ['event' => $event]) }}" download><i
                        class="fas fa-calendar-alt mr-2"></i> Save to Calendar</a>
            </div>
        </div>
    </div>
</div>