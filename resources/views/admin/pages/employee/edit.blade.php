@extends('admin.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control" required>
        </div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" value="{{ old('username', $employee->username) }}" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control">
        </div>

        <!-- Department -->
        <div class="mb-3">
            <label for="employee_department_id" class="form-label">Department</label>
            <select name="employee_department_id" class="form-select">
                @foreach($employeeDepartments as $dept)
                    <option value="{{ $dept->id }}" {{ $employee->employee_department_id == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="employee_category_id" class="form-label">Category</label>
            <select name="employee_category_id" class="form-select">
                @foreach($employeeCategories as $cat)
                    <option value="{{ $cat->id }}" {{ $employee->employee_category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Photo Upload -->
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            @if($employee->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/employee/photo/'.$employee->photo) }}" width="100" alt="Photo">
                </div>
            @endif
            <input type="file" name="photo" class="form-control">
        </div>

        <!-- Signature Upload -->
        <div class="mb-3">
            <label for="sign" class="form-label">Signature</label>
            @if($employee->sign)
                <div class="mb-2">
                    <img src="{{ asset('storage/employee/sign/'.$employee->sign) }}" width="100" alt="Sign">
                </div>
            @endif
            <input type="file" name="sign" class="form-control">
        </div>

        <!-- CEO Sign -->
        <div class="mb-3">
            <label for="ceo_sign" class="form-label">CEO Sign</label>
            @if($employee->ceo_sign)
                <div class="mb-2">
                    <img src="{{ asset('storage/employee/ceoSign/'.$employee->ceo_sign) }}" width="100" alt="CEO Sign">
                </div>
            @endif
            <input type="file" name="ceo_sign" class="form-control">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" name="role" value="{{ old('role', implode(',', json_decode($employee->role))) }}" class="form-control">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>
@endsection
