{{-- Contact Info --}}
<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Postal Code</label>
    <input type="text" name="postal_code" class="form-control form-control-solid form-control-sm"
           value="{{ old('postal_code', $company->postal_code) }}" placeholder="E.g: 1265">
</div>

<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Contact Name</label>
    <input type="text" name="contact_name" class="form-control form-control-solid form-control-sm"
           value="{{ old('contact_name', $company->contact_name) }}" placeholder="E.g: John Doe">
</div>

<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Contact Email</label>
    <input type="email" name="contact_email" class="form-control form-control-solid form-control-sm"
           value="{{ old('contact_email', $company->contact_email) }}" placeholder="E.g: mail@example.com">
</div>

<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Contact Phone</label>
    <input type="text" name="contact_phone" class="form-control form-control-solid form-control-sm"
           value="{{ old('contact_phone', $company->contact_phone) }}" placeholder="E.g: 015xxxxxxx">
</div>

{{-- Headquarter Country --}}
<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Headquarter Country</label>
    <select name="headquarter_country_id" class="form-select form-select-sm form-select-solid" data-control="select2">
        <option></option>
        @foreach (getAllCountry() as $country)
            <option value="{{ $country->id }}" @selected($company->headquarter_country_id == $country->id)>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Founder / CEO --}}
<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Founder</label>
    <input type="text" name="founder" class="form-control form-control-solid form-control-sm"
           value="{{ old('founder', $company->founder) }}" placeholder="E.g: Founder Name">
</div>

<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">CEO</label>
    <input type="text" name="ceo" class="form-control form-control-solid form-control-sm"
           value="{{ old('ceo', $company->ceo) }}" placeholder="E.g: CEO Name">
</div>

<div class="col-lg-3 mb-2">
    <label class="form-label mb-0">Year Founded</label>
    <input type="number" name="year_founded" class="form-control form-control-solid form-control-sm"
           value="{{ old('year_founded', $company->year_founded) }}" min="1000" max="9999" placeholder="E.g: 1920">
</div>

{{-- Headquarter --}}
<div class="col-lg-12 mb-2">
    <label class="form-label mb-0">Headquarter</label>
    <textarea name="headquarter" class="form-control form-control-solid form-control-sm" rows="1">{{ old('headquarter', $company->headquarter) }}</textarea>
</div>

{{-- Mission, Vision, History, About --}}
<div class="col-lg-12 mb-2">
    <label class="form-label mb-0">Mission</label>
    <textarea name="mission" class="tox-target kt_docs_tinymce_plugins">{{ old('mission', $company->mission) }}</textarea>
</div>

<div class="col-lg-12 mb-2">
    <label class="form-label mb-0">Vision</label>
    <textarea name="vision" class="tox-target kt_docs_tinymce_plugins">{{ old('vision', $company->vision) }}</textarea>
</div>

<div class="col-lg-12 mb-2">
    <label class="form-label mb-0">History</label>
    <textarea name="history" class="tox-target kt_docs_tinymce_plugins">{{ old('history', $company->history) }}</textarea>
</div>

<div class="col-lg-12 mb-2">
    <label class="form-label mb-0">About</label>
    <textarea name="about" class="tox-target kt_docs_tinymce_plugins">{{ old('about', $company->about) }}</textarea>
</div>
