<button class="btn btn-primary d-none" id="eventUpdaterOffCanvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrollingUpdate"
        aria-controls="offcanvasScrollingUpdate">Update Event
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
     id="offcanvasScrollingUpdate" aria-labelledby="offcanvasScrollingUpdateLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingUpdateLabel">Update a new event for <b id="updateDate"></b>?</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" id="closeEventUpdateCanvas"></button>
    </div>
    <div class="container">
        <form action="" method="POST" onsubmit="return false" id="updateEventForm">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="update_title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="update_title" class="form-control" id="update_title">
                    <small class="text-danger error" id="update_title-error"></small>
                </div>
            </div>
            <div class="row mb-3">
                <label for="updateStartDateTime" class="col-sm-2 col-form-label">Start Time</label>
                <div class="col-sm-10">
                    <input type="time" name="updateStartDateTime" class="form-control" id="updateStartDateTime" />
                    <small class="text-danger error" id="updateStartDateTime-error"></small>
                </div>
            </div>
            <div class="row mb-3">
                <label for="updateEndDateTime" class="col-sm-2 col-form-label">End Time</label>
                <div class="col-sm-10">
                    <input type="time" name="updateEndDateTime" class="form-control" id="updateEndDateTime" />
                    <small class="text-danger error" id="updateEndDateTime-error"></small>
                </div>
            </div>

            <div class="row mb-3">
                <label for="updateDescription" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="updateDescription" rows="3" name="updateDescription"></textarea>
                    <small class="text-danger error" id="updateDescription-error"></small>
                </div>
            </div>

            <button type="button" class="btn btn-danger float-start" id="deleteEvent">Delete</button>
            <button type="button" class="btn btn-primary float-end" id="updateEvent">Save</button>
        </form>
    </div>
</div>
