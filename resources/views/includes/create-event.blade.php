<button class="btn btn-primary d-none" id="eventCreatorOffCanvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
        aria-controls="offcanvasScrolling">Create Event
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
     id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Create a new event for <b id="date"></b>?</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" id="closeEventCreateCanvas"></button>
    </div>
    <div class="container">
        <form action="{{ route('calendar.store') }}" method="POST" onsubmit="return false" id="createEventForm">
            @csrf
            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="title">
                    <small class="text-danger error" id="title-error"></small>
                </div>
            </div>
            <div class="row mb-3">
                <label for="startDateTime" class="col-sm-2 col-form-label">Start Time</label>
                <div class="col-sm-10">
                    <input type="time" name="startDateTime" class="form-control" id="startDateTime" />
                    <small class="text-danger error" id="startDateTime-error"></small>
                </div>
            </div>
            <div class="row mb-3">
                <label for="endDateTime" class="col-sm-2 col-form-label">End Time</label>
                <div class="col-sm-10">
                    <input type="time" name="endDateTime" class="form-control" id="endDateTime" />
                    <small class="text-danger error" id="endDateTime-error"></small>
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    <small class="text-danger error" id="description-error"></small>
                </div>
            </div>

            <button type="button" class="btn btn-primary float-end" id="saveEvent">Save</button>
        </form>
    </div>
</div>
