@extends('Admin.layout.partials.master')
@section('title', 'Admin - Add event')
@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Add Event</h4>
                        <a href="{{ route('admin.manageEvent') }}" class="btn btn-success rounded text-white">Back</a>
                    </div>
                    <div class="card-body">
                        <form class="g-3 needs-validation demoform" id="demoform" method="POST"
                            action="{{ route('admin.storeEvent') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Name" class="form-label"><b>Name</b></label>
                                    <input type="text" class="form-control" name="name" id="Name"
                                        placeholder="Enter Event Name" value="{{ old('name') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Date" class="form-label"><b>Date</b></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        name="date" id="Date" value="{{ old('date', date('Y-m-d')) }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-3 mt-3">
                                    <label for="start_time" class="form-label"><b>Start Time</b></label>
                                    <input type="text" class="form-control" name="start_time" id="start_time"
                                        value="{{ old('start_time') }}" placeholder="Select Start Time">
                                    <small id="start_time_display" class="text-muted"></small>
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label for="end_time" class="form-label"><b>End Time</b></label>
                                    <input type="text" class="form-control" name="end_time" id="end_time"
                                        value="{{ old('end_time') }}" placeholder="Select End Time">
                                    <small id="end_time_display" class="text-muted"></small>
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Location" class="form-label"><b>Location</b></label>
                                    <input type="text" class="form-control" name="location" id="Location"
                                        placeholder="Enter Event Location" value="{{ old('location') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <div class="row mx-2">
                                <div class="col-md-6 mt-3">
                                    <label for="Price" class="form-label"><b>Price</b></label>
                                    <input type="number" class="form-control" name="price" id="Price"
                                        placeholder="Enter Event Price" value="{{ old('price') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <div class="row mx-2 mb-3">
                                <div class="col-md-6 mt-3">
                                    <label for="total_tickets" class="form-label"><b>Tickets</b></label>
                                    <input type="number" class="form-control" name="total_tickets" id="total_tickets"
                                        placeholder="Enter Event Tickets" value="{{ old('total_tickets') }}">
                                    <div class="invalid-feedback ajax-error"></div>
                                </div>
                            </div>

                            <input type="hidden" class="event_id" name="event_id" id="event_id" value="">

                            <div class="row mx-3">
                                <label for="Image" class="form-label"><b>Image</b></label>
                                <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                    <span>Drag & drop or click to upload</span>
                                    <div class="dropzone-previews"></div>
                                </div>
                                <p class="error-image text-danger"></p>
                            </div>

                            <div class="row">
                                <div class="col-12 m-3">
                                    <button class="btn btn-primary" id="submitBtn" type="submit">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function initTimePicker(selector) {
                flatpickr(selector, {
                    enableTime: true,
                    noCalendar: true,
                    altInput: true,
                    altFormat: "h:i K", // Display 12-hour format with AM/PM
                    dateFormat: "H:i", // Submit value in 24-hour format
                    time_24hr: false, // Show AM/PM selector
                    defaultHour: 12, // Default to 12:00
                    defaultMinute: 0
                });
            }

            initTimePicker("#start_time");
            initTimePicker("#end_time");
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(function() {
            let dz = new Dropzone("#dropzoneDragArea", {
                url: "{{ route('store_file') }}",
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 5,
                maxFiles: 5,
                maxFilesize: 5,
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                addRemoveLinks: true,
                dictRemoveFile: "Remove",
                acceptedFiles: ".jpeg,.jpg,.png,.gif"
            });

            dz.on("sending", function(file, xhr, formData) {
                formData.append("event_id", $("#event_id").val());
            });

            dz.on("queuecomplete", function() {
                Swal.fire("Success", "Event & images saved successfully!", "success")
                    .then(() => window.location.href = "{{ route('admin.manageEvent') }}");
            });

            $("#demoform").submit(function(e) {
                // e.preventDefault();
                let form = this;

                $(form).find(".is-invalid").removeClass("is-invalid");
                $(form).find(".invalid-feedback.ajax-error").text('');
                $('.error-image').text('');
                $('#dropzoneDragArea').removeClass('is-invalid');

                let formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.status === "success") {
                            if (dz.getQueuedFiles().length === 0) {
                                $('.error-image').text('The image field is required.');
                                $('#dropzoneDragArea').addClass('is-invalid');
                                return;
                            }

                            $("#event_id").val(res.event_id);
                            dz.processQueue();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(key => {
                                let field = $("[name='" + key + "']");
                                if (field.length) {
                                    field.addClass("is-invalid")
                                        .next(".invalid-feedback.ajax-error")
                                        .text(errors[key][0]);
                                }
                            });

                            if (dz.getQueuedFiles().length === 0) {
                                $('.error-image').text('The image field is required.');
                                $('#dropzoneDragArea').addClass('is-invalid');
                            }
                        } else {
                            Swal.fire("Error", "Something went wrong", "error");
                        }
                    }
                });
            });

        });
    </script>
@endpush
