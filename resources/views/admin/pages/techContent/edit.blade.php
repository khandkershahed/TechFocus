@extends('admin.master')
@section('content')
<div class="container h-100">
    <div class="row">
        <div class="col-lg-12 card rounded-0 shadow-sm px-0">
            <div class="card card-flush">
                <div class="card-header align-items-center gap-2 gap-md-5 shadow-lg bg-light-primary px-0" style="min-height: 45px;">
                    <div class="container px-0">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12 text-lg-start text-sm-center">
                                <div class="card-title ps-3">
                                    <h2 class="text-start ps-5">Tech Content Edit Form</h2>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 text-lg-end text-sm-center">
                                <a href="{{ route('admin.tech-content.index') }}" class="btn btn-icon btn-primary w-auto px-3 rounded-0">
                                    <i class="las la-arrow-left fs-2 me-2"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news-trend.update', $content->id) }}" class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        @php
                            // Ensure all JSON fields are arrays
                            $brandIds     = is_array($content->brand_id) ? $content->brand_id : (json_decode($content->brand_id, true) ?? []);
                            $categoryIds  = is_array($content->category_id) ? $content->category_id : (json_decode($content->category_id, true) ?? []);
                            $industryIds  = is_array($content->industry_id) ? $content->industry_id : (json_decode($content->industry_id, true) ?? []);
                            $solutionIds  = is_array($content->solution_id) ? $content->solution_id : (json_decode($content->solution_id, true) ?? []);
                        @endphp
                        <div class="row">
                            <div class="col-lg-3">
                                <!-- Brand Select -->
                                <div class="fv-row mb-3">
                                    <label class="form-label">Brand Name</label>
                                    <select class="form-select form-select-solid form-select-sm" name="brand_id[]" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="2">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ in_array($brand->id, $brandIds) ? 'selected' : '' }}>
                                                {{ $brand->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select at least one brand.</div>
                                </div>

                                <!-- Category Select -->
                                <div class="fv-row mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select class="form-select form-select-solid form-select-sm" name="category_id[]" multiple multiselect-search="true" multiselect-select-all="true">
                                        @if (count($categories) > 0)
                                            @foreach ($categories->whereNull('parent_id') as $category)
                                                @include('admin.pages.product.partials.edit_category', [
                                                    'category' => $category,
                                                    'level' => 0,
                                                    'selectedCategories' => $categoryIds,
                                                ])
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Please select at least one category.</div>
                                </div>

                                <!-- Industry Select -->
                                <div class="fv-row mb-3 mt-1">
                                    <label class="form-label">Industry Name</label>
                                    <select class="form-select form-select-solid form-select-sm" name="industry_id[]" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="2">
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}" {{ in_array($industry->id, $industryIds) ? 'selected' : '' }}>
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select at least one industry.</div>
                                </div>

                                <!-- Solution Select -->
                                <div class="fv-row mb-3 mt-1">
                                    <label class="form-label">Solution Name</label>
                                    <select class="form-select form-select-solid form-select-sm" name="solution_id[]" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="2">
                                        @foreach ($solutions as $solution)
                                            <option value="{{ $solution->id }}" {{ in_array($solution->id, $solutionIds) ? 'selected' : '' }}>
                                                {{ $solution->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select at least one solution.</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Badge & Featured -->
                                <div class="row">
                                    <div class="col-lg-8 mb-3">
                                        <label class="form-label required">Badge</label>
                                        <input type="text" class="form-control form-control-solid form-control-sm" name="badge" value="{{ $content->badge }}" required>
                                        <div class="invalid-feedback">Please enter badge.</div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label required">Featured</label>
                                        <select class="form-select form-select-solid" name="featured" required>
                                            <option @selected($content->featured == '0') value="0">No</option>
                                            <option @selected($content->featured == '1') value="1">Yes</option>
                                        </select>
                                        <div class="invalid-feedback">Please select featured.</div>
                                    </div>
                                </div>

                                <!-- Title & Author -->
                                <div class="fv-row mb-3">
                                    <label class="form-label required">Title</label>
                                    <input type="text" class="form-control form-control-solid form-control-sm" name="title" value="{{ $content->title }}" required>
                                    <div class="invalid-feedback">Please enter title.</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label required">Author Name</label>
                                        <input type="text" class="form-control form-control-solid form-control-sm" name="author" value="{{ $content->author }}" required>
                                        <div class="invalid-feedback">Please enter author name.</div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Source URL</label>
                                        <input type="url" class="form-control form-control-solid form-control-sm" name="source_link" value="{{ $content->source_link }}">
                                        <div class="invalid-feedback">Please enter source URL.</div>
                                    </div>
                                </div>

                                <!-- Additional Button -->
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Additional Button Name</label>
                                        <input type="text" class="form-control form-control-solid form-control-sm" name="additional_button_name" value="{{ $content->additional_button_name }}">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Additional Button URL</label>
                                        <input type="url" class="form-control form-control-solid form-control-sm" name="additional_url" value="{{ $content->additional_url }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <!-- Type -->
                                <div class="fv-row mb-3">
                                    <label class="form-label required">Type</label>
                                    <select class="form-select form-select-sm" name="type" required>
                                        <option @selected($content->type == 'news') value="news">News</option>
                                        <option @selected($content->type == 'trends') value="trends">Trends</option>
                                        <option @selected($content->type == 'blogs') value="blogs">Blogs</option>
                                        <option @selected($content->type == 'client_stories') value="client_stories">Client Stories</option>
                                        <option @selected($content->type == 'tech_contents') value="tech_contents">Tech Contents</option>
                                    </select>
                                    <div class="invalid-feedback">Please select type.</div>
                                </div>

                                <!-- Images -->
                                @foreach (['thumbnail_image', 'banner_image', 'source_image'] as $img)
                                    <div class="row gx-1 mb-3">
                                        <label class="form-label required">{{ ucwords(str_replace('_', ' ', $img)) }}</label>
                                        <div class="col-10">
                                            <input type="file" class="form-control form-control-solid form-control-sm" name="{{ $img }}">
                                        </div>
                                        <div class="col-2">
                                            <img src="{{ asset('storage/content/' . $content->{$img}) }}" width="45px" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Description & Tags -->
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label required">Tags</label>
                                        <input type="text" name="tags" value="{{ $content->tags }}" class="form-control form-control-sm visually-hidden" data-role="tagsinput" placeholder="Enter Tags">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label required">Address</label>
                                        <textarea rows="1" name="address" class="form-control form-control-sm form-control-solid" required>{{ $content->address }}</textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label required">Header</label>
                                        <textarea rows="1" name="header" class="form-control form-control-sm form-control-solid" required>{{ $content->header }}</textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label required">Footer</label>
                                        <textarea rows="1" name="footer" class="form-control form-control-sm form-control-solid" required>{{ $content->footer }}</textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label required">Short Description</label>
                                        <textarea name="short_des" class="tox-target kt_docs_tinymce_plugins">{{ $content->short_des }}</textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label required">Long Description</label>
                                        <textarea name="long_des" class="tox-target kt_docs_tinymce_plugins">{{ $content->long_des }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row p-2">
                            <button type="submit" class="btn btn-sm btn-primary rounded-0">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        var options = {
            selector: "#kt_docs_tinymce_basic"
        };

        if (KTApp.isDarkMode()) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);
    </script>
    <script>
        var options = {
            selector: "#kt_docs_tinymce_basic2"
        };

        if (KTApp.isDarkMode()) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);
    </script>
@endsection
