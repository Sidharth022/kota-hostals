<x-layouts.dashboard>
    <div class="d-flex flex-column gap-4">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('owner.hostels') }}" class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-outfit fs-3 fw-bold text-dark mb-1">Edit Hostel details</h2>
                    <p class="text-secondary small mb-0">Update information for: <strong>{{ $hostel->title }}</strong></p>
                </div>
            </div>
            <div>
                <!-- Delete Hostel Form/Trigger -->
                <button type="button" class="btn btn-outline-danger rounded-pill px-4 d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#deleteHostelModal">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Delete Listing</span>
                </button>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card border border-light-subtle rounded-2xl p-4 p-md-5 bg-white">
            <form action="{{ route('owner.hostels.update', $hostel) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-4">
                @csrf
                @method('PUT')

                <!-- Section 1: Basic Information -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-circle-info text-primary me-2"></i>Basic Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="title" class="form-label small fw-semibold text-secondary">Hostel Name / Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-xl @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $hostel->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="area_id" class="form-label small fw-semibold text-secondary">Area Location <span class="text-danger">*</span></label>
                            <select class="form-select rounded-xl @error('area_id') is-invalid @enderror" id="area_id" name="area_id" required>
                                <option value="" disabled>Select Area</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id', $hostel->area_id) == $area->id ? 'selected' : '' }}>{{ $area->title }}</option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label small fw-semibold text-secondary">Detailed Description <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-xl @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $hostel->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label small fw-semibold text-secondary">Full Address <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-xl @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address', $hostel->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pricing & Configurations -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-indian-rupee-sign text-primary me-2"></i>Pricing & Rooms
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="monthly_rent" class="form-label small fw-semibold text-secondary">Monthly Rent (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-start-xl border-end-0">₹</span>
                                <input type="number" class="form-control rounded-end-xl @error('monthly_rent') is-invalid @enderror" id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent', $hostel->monthly_rent) }}" min="0" required>
                                @error('monthly_rent')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="security_deposit" class="form-label small fw-semibold text-secondary">Security Deposit (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-start-xl border-end-0">₹</span>
                                <input type="number" class="form-control rounded-end-xl @error('security_deposit') is-invalid @enderror" id="security_deposit" name="security_deposit" value="{{ old('security_deposit', $hostel->security_deposit) }}" min="0">
                                @error('security_deposit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="total_rooms" class="form-label small fw-semibold text-secondary">Total Rooms</label>
                            <input type="number" class="form-control rounded-xl @error('total_rooms') is-invalid @enderror" id="total_rooms" name="total_rooms" value="{{ old('total_rooms', $hostel->total_rooms) }}" min="0">
                            @error('total_rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="available_rooms" class="form-label small fw-semibold text-secondary">Available Rooms</label>
                            <input type="number" class="form-control rounded-xl @error('available_rooms') is-invalid @enderror" id="available_rooms" name="available_rooms" value="{{ old('available_rooms', $hostel->available_rooms) }}" min="0">
                            @error('available_rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-secondary d-block">Room Configurations <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-4 mt-2">
                                @php
                                    $selectedRooms = old('room_types', $hostel->room_types ?? []);
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input @error('room_types') is-invalid @enderror" type="checkbox" name="room_types[]" value="single" id="room_type_single" {{ is_array($selectedRooms) && in_array('single', $selectedRooms) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark small fw-medium" for="room_type_single">Single Room</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('room_types') is-invalid @enderror" type="checkbox" name="room_types[]" value="double" id="room_type_double" {{ is_array($selectedRooms) && in_array('double', $selectedRooms) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark small fw-medium" for="room_type_double">Double Room</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('room_types') is-invalid @enderror" type="checkbox" name="room_types[]" value="triple" id="room_type_triple" {{ is_array($selectedRooms) && in_array('triple', $selectedRooms) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark small fw-medium" for="room_type_triple">Triple Room</label>
                                </div>
                            </div>
                            @error('room_types')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="gender_type" class="form-label small fw-semibold text-secondary">Target Gender <span class="text-danger">*</span></label>
                            <select class="form-select rounded-xl @error('gender_type') is-invalid @enderror" id="gender_type" name="gender_type" required>
                                <option value="boys" {{ old('gender_type', $hostel->gender_type) === 'boys' ? 'selected' : '' }}>Boys</option>
                                <option value="girls" {{ old('gender_type', $hostel->gender_type) === 'girls' ? 'selected' : '' }}>Girls</option>
                                <option value="coed" {{ old('gender_type', $hostel->gender_type) === 'coed' ? 'selected' : '' }}>Co-ed</option>
                            </select>
                            @error('gender_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="status" class="form-label small fw-semibold text-secondary">Status <span class="text-danger">*</span></label>
                            <select class="form-select rounded-xl @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $hostel->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status', $hostel->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $hostel->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Facilities / Amenities -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-wifi text-primary me-2"></i>Facilities & Amenities
                    </h5>
                    <div class="row g-3 mt-1">
                        @php
                            $associatedFacilities = old('facilities', $hostel->facilities->pluck('id')->toArray());
                        @endphp
                        @foreach($facilities as $facility)
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="form-check p-2 rounded-xl border border-light-subtle d-flex align-items-center gap-2" style="background-color: #fafbfd; padding-left: 2.25rem !important;">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="facility_{{ $facility->id }}" {{ in_array($facility->id, $associatedFacilities) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark small fw-medium" for="facility_{{ $facility->id }}">
                                        <span class="me-1">{{ $facility->icon }}</span> {{ $facility->title }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 4: Location details -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-location-crosshairs text-primary me-2"></i>Map Coordinates & URL
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="latitude" class="form-label small fw-semibold text-secondary">Latitude</label>
                            <input type="number" step="0.00000001" class="form-control rounded-xl @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $hostel->latitude) }}">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="longitude" class="form-label small fw-semibold text-secondary">Longitude</label>
                            <input type="number" step="0.00000001" class="form-control rounded-xl @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $hostel->longitude) }}">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="google_map_url" class="form-label small fw-semibold text-secondary">Google Maps Link (URL)</label>
                            <input type="url" class="form-control rounded-xl @error('google_map_url') is-invalid @enderror" id="google_map_url" name="google_map_url" value="{{ old('google_map_url', $hostel->google_map_url) }}">
                            @error('google_map_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 5: Gallery -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-images text-primary me-2"></i>Gallery Images
                    </h5>

                    <!-- Existing Media Items -->
                    @if($hostel->getMedia('gallery')->count() > 0)
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary d-block">Current Images (Select to delete)</label>
                            <div class="row g-3">
                                @foreach($hostel->getMedia('gallery') as $media)
                                    <div class="col-4 col-sm-3 col-md-2">
                                        <div class="card border border-light-subtle rounded-xl overflow-hidden p-1 bg-light text-center h-100">
                                            <div class="ratio ratio-1x1 rounded-xl overflow-hidden mb-2">
                                                <img src="{{ $media->getUrl() }}" alt="" class="object-cover">
                                            </div>
                                            <div class="form-check justify-content-center d-flex gap-1.5 mb-1">
                                                <input class="form-check-input border-danger" type="checkbox" name="delete_images[]" value="{{ $media->id }}" id="del_img_{{ $media->id }}">
                                                <label class="form-check-label text-danger small fw-semibold cursor-pointer" for="del_img_{{ $media->id }}">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <label for="gallery_images" class="form-label small fw-semibold text-secondary">Upload New Images</label>
                        <input type="file" class="form-control rounded-xl @error('gallery_images') is-invalid @enderror" id="gallery_images" name="gallery_images[]" multiple accept="image/*">
                        <div class="form-text small text-secondary">Supported formats: JPEG, PNG, JPG, WEBP. Max size: 5MB per file.</div>
                        @error('gallery_images')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('gallery_images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Section 6: SEO -->
                <div>
                    <h5 class="font-outfit fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-search text-primary me-2"></i>SEO Meta details (Optional)
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="meta_title" class="form-label small fw-semibold text-secondary">Meta Title</label>
                            <input type="text" class="form-control rounded-xl @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $hostel->meta_title) }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="meta_description" class="form-label small fw-semibold text-secondary">Meta Description</label>
                            <textarea class="form-control rounded-xl @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $hostel->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('owner.hostels') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Hostel Confirmation Modal -->
    <div class="modal fade" id="deleteHostelModal" tabindex="-1" aria-labelledby="deleteHostelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3xl border-0 shadow-soft-lg p-3">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-outfit fw-bold text-dark" id="deleteHostelModalLabel">Delete Hostel Listing?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-secondary small mb-0">Are you sure you want to permanently delete <strong>{{ $hostel->title }}</strong>? This action cannot be undone and will delete all application and inquiry histories associated with it.</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('owner.hostels.destroy', $hostel) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Yes, Delete Property</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rounded-xl {
            border-radius: 0.75rem !important;
        }
        .rounded-start-xl {
            border-top-left-radius: 0.75rem !important;
            border-bottom-left-radius: 0.75rem !important;
        }
        .rounded-end-xl {
            border-top-right-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
        }
        .object-cover {
            object-fit: cover !important;
            width: 100% !important;
            height: 100% !important;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</x-layouts.dashboard>
