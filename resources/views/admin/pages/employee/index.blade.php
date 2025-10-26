@extends('admin.master')
@section('content')
    {{-- Table --}}
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-lg-12">
                <div class="bg-white border-0 shadow-none card rounded-0">
                    <!-- Header -->
                    <div class="flex-wrap px-4 py-3 card-header d-flex justify-content-between align-items-center">

                        <!-- Title -->
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0 fw-bold">Employee Management</h3>
                            <span>Manage your employees</span>
                        </div>

                        <!-- Add Employee Button -->
                        <div class="mb-3 text-end">
                            <button type="button" class="shadow-sm btn btn-success btn-sm rounded-1" data-bs-toggle="modal"
                                data-bs-target="#adminAddModal">
                                <i class="fa-solid fa-plus me-1"></i> Add Employee
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="pt-0 card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 text-center align-middle border dataTable table-hover fs-7">
                                <thead class="text-gray-700 bg-light text-uppercase fw-semibold">
                                    <tr>
                                        <th width="7%" class="py-5">Sl</th>
                                        <th width="8%" class="py-5">Image</th>
                                        <th width="20%" class="py-5">Name</th>
                                        <th width="15%" class="py-5">Designation</th>
                                        <th width="20%" class="py-5">Department</th>
                                        <th width="10%" class="py-5">Role</th>
                                        <th width="10%" class="py-5">Form</th>
                                        <th width="10%" class="py-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-semibold">
                                    @forelse ($admins as $admin)
                                        <tr class="border">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ !empty($admin->logo) && file_exists(public_path('storage/brand/logo/requestImg/' . $admin->logo))
                                                    ? asset('storage/brand/logo/requestImg/' . $admin->logo)
                                                    : asset('backend/images/no-image-available.png') }}"
                                                    alt="{{ $admin->name }}" class="border img-fluid rounded-circle"
                                                    width="45" height="45">
                                            </td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->designation ?? '-' }}</td>
                                            <td>
                                                @if (is_array(json_decode($admin->department)))
                                                    @foreach (json_decode($admin->department) as $department)
                                                        <span
                                                            class="badge bg-light-success text-success fw-semibold">{{ ucfirst($department) }}</span>
                                                    @endforeach
                                                @else
                                                    <span
                                                        class="badge bg-light-success text-success fw-semibold">{{ ucfirst($admin->department) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (is_array(json_decode($admin->role)))
                                                    @foreach (json_decode($admin->role) as $role)
                                                        <span
                                                            class="badge bg-light-primary text-black fw-semibold">{{ ucfirst($role) }}</span>
                                                    @endforeach
                                                @else
                                                    <span
                                                        class="badge bg-light-primary text-black fw-semibold">{{ ucfirst($admin->role) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.employee.create') }}"
                                                    class="btn btn-sm btn-light-primary">
                                                    <i class="fa-solid fa-file-lines"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="gap-2 d-flex justify-content-center">
                                                    <!-- View -->
                                                    {{--
                        <a href="#" class="btn btn-icon btn-light-info btn-sm" data-bs-toggle="modal" data-bs-target="#adminViewModal_{{ $admin->id }}">
                                            <i class="fa-solid fa-eye"></i>
                                            </a>
                                            --}}
<<<<<<< HEAD
                                            <!-- Edit -->
                                            <a href="#" class="btn btn-icon btn-light-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#adminEditModal-{{ $admin->id }}">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                               @if (Auth::guard('admin')->user()->role == 'admin') 
                                            <!-- Delete -->
                                            <a href="#"
                                                class="btn btn-icon btn-light-danger btn-sm"
                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this employee?')) document.getElementById('delete-form-{{ $admin->id }}').submit();">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                            
                                            <form id="delete-form-{{ $admin->id }}"
                                                action="{{ route('admin.employee.destroy', $admin->id) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-muted">No employees found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
=======
                                                    <!-- Edit -->
                                                    <a href="#" class="btn btn-icon btn-light-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#adminEditModal-{{ $admin->id }}">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>

                                                    <!-- Delete -->
                                                    <a href="#" class="btn btn-icon btn-light-danger btn-sm"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this employee?')) document.getElementById('delete-form-{{ $admin->id }}').submit();">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>

                                                    <form id="delete-form-{{ $admin->id }}"
                                                        action="{{ route('admin.employee.destroy', $admin->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-4 text-muted">No employees found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
>>>>>>> efbff55f600d59d232f164ca1aab201ef91eeff4
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="adminAddModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="border-0 shadow-sm modal-content rounded-3">
                <div class="px-4 py-3 border-0 modal-header bg-light">
                    <h5 class="modal-title fw-semibold">Add Employee</h5>
                    <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg fs-5"></i>
                    </button>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('admin.employee.store') }}" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="p-15 modal-body">
                        <div class="row g-3">

                            <!-- Full Name -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-solid" placeholder="Enter Full Name">
                                </div>
                            </div>

                            <!-- Designation -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Designation</label>
                                    <input type="text" name="designation" value="{{ old('designation') }}"
                                        class="form-control form-control-solid" placeholder="Enter Designation">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-solid" placeholder="Enter Email">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-solid" placeholder="Enter Phone Number">
                                </div>
                            </div>

                            <!-- Job Category -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Job Category</label>
                                    <select name="employee_category_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select Job Category">
                                        <option></option>
                                        @foreach ($employeeCategories as $employeeCategory)
                                            <option value="{{ $employeeCategory->id }}">{{ $employeeCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Employee Code -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Employee Code</label>
                                    <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                                        class="form-control form-control-solid" placeholder="Employee Code">
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-lg-6 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Department</label>
                                    <select name="department[]" class="form-select form-select-solid"
                                        data-control="select2" data-close-on-select="false"
                                        data-placeholder="Select departments" data-allow-clear="true" multiple required>
                                        <option value="admin" @selected(in_array('admin', old('department', [])))>SuperAdmin</option>
                                        <option value="sales" @selected(in_array('sales', old('department', [])))>Sales</option>
                                        <option value="marketing" @selected(in_array('marketing', old('department', [])))>Marketing</option>
                                        <option value="accounts" @selected(in_array('accounts', old('department', [])))>Accounts</option>
                                        <option value="finance" @selected(in_array('finance', old('department', [])))>Finance</option>
                                        <option value="hr" @selected(in_array('hr', old('department', [])))>HR</option>
                                        <option value="operation" @selected(in_array('operation', old('department', [])))>Operation</option>
                                        <option value="site" @selected(in_array('site', old('department', [])))>Site & Contents</option>
                                        <option value="logistics" @selected(in_array('logistics', old('department', [])))>Logistics</option>
                                        <option value="software_development" @selected(in_array('software_development', old('department', [])))>Software
                                            Development</option>
                                        <option value="crm" @selected(in_array('crm', old('department', [])))>CRM</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-lg-6 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Role</label>
                                    <select name="role" class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Select a role" data-allow-clear="true" required>
                                        <option></option>
                                        <option value="admin" @selected(old('role') == 'admin')>Admin</option>
                                        <option value="manager" @selected(old('role') == 'manager')>Manager</option>
                                        <option value="others" @selected(old('role') == 'others')>Others</option>
                                        <option value="developer" @selected(old('role') == 'developer')>Support Developer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Supervisor -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Supervisor</label>
                                    <select name="supervisor_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select a Supervisor"
                                        data-allow-clear="true" required>
                                        <option></option>
                                        @foreach ($admins as $supervisor)
                                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">City</label>
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="form-control form-control-solid" placeholder="Enter City">
                                </div>
                            </div>
                            <!-- Profile Picture -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Profile Picture</label>
                                    <input type="file" name="photo" class="form-control form-control-solid">
                                </div>
                            </div>

                            <!-- Signature -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Signature</label>
                                    <input type="file" name="sign" class="form-control form-control-solid">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-group input-group-sm bg-light">
                                        <input type="password" name="password" class="form-control form-control-solid"
                                            placeholder="Enter Password">
                                        <button type="button" class="btn btn-outline-secondary toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-lg-4 col-md-6">
                                <div class="">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <div class="input-group input-group-sm bg-light">
                                        <input type="password" name="confirm_password"
                                            class="form-control form-control-solid" placeholder="Confirm Password">
                                        <button type="button" class="btn btn-outline-secondary toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="py-3 modal-footer bg-light">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="px-4 btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
    @foreach ($admins as $admin)
        <div class="modal fade" id="adminEditModal-{{ $admin->id }}" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="border-0 shadow-sm modal-content rounded-3">
                    <div class="px-4 py-3 border-0 modal-header bg-light">
                        <h5 class="modal-title fw-semibold">Edit Employee</h5>
                        <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="bi bi-x-lg fs-5"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.employee.update', $admin->id) }}"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="p-15 modal-body">
                            <div class="row g-3">

                                <!-- Basic Information -->
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" class="form-control form-control-solid" name="name"
                                        value="{{ $admin->name }}" placeholder="Enter employee name" maxlength="80" />
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Designation</label>
                                    <input type="text" class="form-control form-control-solid" name="designation"
                                        value="{{ $admin->designation }}" placeholder="Enter designation"
                                        maxlength="50" />
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control form-control-solid" name="email"
                                        value="{{ $admin->email }}" placeholder="Enter email address" />
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <input type="text" class="form-control form-control-solid" name="phone"
                                        value="{{ $admin->phone }}" placeholder="Enter phone number" maxlength="15" />
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Job Category</label>
                                    <select name="employee_category_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select job category"
                                        data-allow-clear="true">
                                        <option></option>
                                        @foreach ($employeeCategories as $employeeCategory)
                                            <option value="{{ $employeeCategory->id }}" @selected($admin->employee_category_id == $employeeCategory->id)>
                                                {{ $employeeCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Employee Code (Biometric ID)</label>
                                    <input type="text" class="form-control form-control-solid" name="employee_id"
                                        value="{{ $admin->employee_id }}" maxlength="15"
                                        placeholder="Enter employee code" />
                                </div>

                                <!-- Department & Role -->
                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Department</label>
                                    @php
                                        $adminDepartment = isset($admin->department)
                                            ? json_decode($admin->department, true)
                                            : [];
                                        $departments = [
                                            'admin' => 'Super Admin',
                                            'sales' => 'Sales',
                                            'marketing' => 'Marketing',
                                            'accounts' => 'Accounts',
                                            'finance' => 'Finance',
                                            'hr' => 'HR',
                                            'operation' => 'Operation',
                                            'site' => 'Site & Contents',
                                            'logistics' => 'Logistics',
                                            'software_development' => 'Software Development',
                                            'crm' => 'CRM',
                                        ];
                                    @endphp
                                    <select name="department[]" class="form-select form-select-solid"
                                        data-control="select2" data-close-on-select="false"
                                        data-placeholder="Select departments" data-allow-clear="true" multiple required>
                                        <option></option>
                                        @foreach ($departments as $key => $label)
                                            <option value="{{ $key }}" @selected(is_array($adminDepartment) && in_array($key, $adminDepartment))>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold required">Role</label>
                                    @php
                                        // Always convert role into a consistent array
                                        $adminRole = $admin->role ?? [];

                                        if (is_string($adminRole)) {
                                            $decoded = json_decode($adminRole, true);
                                            $adminRole = is_array($decoded) ? $decoded : [$adminRole];
                                        } elseif (!is_array($adminRole)) {
                                            $adminRole = [];
                                        }
                                    @endphp

                                    <select name="role" class="form-select form-select-solid" data-control="select2"
                                        data-placeholder="Select a role" data-allow-clear="true" required>
                                        <option></option>
                                        <option value="admin" @selected(in_array('admin', $adminRole))>Admin</option>
                                        <option value="manager" @selected(in_array('manager', $adminRole))>Manager</option>
                                        <option value="others" @selected(in_array('others', $adminRole))>Others</option>
                                        <option value="developer" @selected(in_array('developer', $adminRole))>Support Developer</option>
                                    </select>
                                </div>


                                <!-- Supervisor -->
                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold required">Supervisor</label>
                                    <select name="supervisor_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select supervisor"
                                        data-allow-clear="true" required>
                                        <option></option>
                                        @foreach ($admins as $supervisor)
                                            <option value="{{ $supervisor->id }}" @selected($admin->supervisor_id == $supervisor->id)>
                                                {{ $supervisor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">City</label>
                                    <input type="text" class="form-control form-control-solid" name="city"
                                        value="{{ $admin->city }}" placeholder="Enter city" maxlength="50" />
                                </div>

                                <!-- File Uploads -->
                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Profile Picture</label>
                                    <input type="file" class="form-control form-control-solid" name="photo" />
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Sign</label>
                                    <input type="file" class="form-control form-control-solid" name="sign" />
                                </div>

                                <!-- Password Fields -->
                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control form-control-solid"
                                            id="edit_password_{{ $admin->id }}" name="password"
                                            placeholder="Enter new password" />
                                        <button type="button" class="btn btn-outline-secondary toggle_edit_password"
                                            data-target="edit_password_{{ $admin->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <div class="input-group input-group-sm">
                                        <input type="password" class="form-control form-control-solid"
                                            id="edit_confirm_password_{{ $admin->id }}" name="confirm_password"
                                            placeholder="Confirm password" />
                                        <button type="button" class="btn btn-outline-secondary toggle_edit_password"
                                            data-target="edit_confirm_password_{{ $admin->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div id="edit_password_message_{{ $admin->id }}"></div>
                                </div>

                            </div>
                        </div>

                        <div class="py-3 modal-footer bg-light">
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="px-4 btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Edit Modal End --}}
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // -----------------------------
            // ADD MODAL PASSWORD TOGGLE & VALIDATION
            // -----------------------------
            const addModal = document.getElementById("adminAddModal");
            if (addModal) {
                const addPassword = addModal.querySelector('input[name="password"]');
                const addConfirmPassword = addModal.querySelector('input[name="confirm_password"]');
                const addPasswordMessage = addModal.querySelector('#add_password_message');

                // Toggle password visibility
                addModal.querySelectorAll('.toggle-password').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.closest('.input-group').querySelector('input');
                        if (input.type === 'password') input.type = 'text';
                        else input.type = 'password';
                        this.querySelector('i').classList.toggle('bi-eye');
                        this.querySelector('i').classList.toggle('bi-eye-slash');
                    });
                });

                // Password match validation
                function validateAddPasswords() {
                    if (addPassword.value !== addConfirmPassword.value) {
                        addPasswordMessage.innerHTML = "Passwords do not match!";
                        addPasswordMessage.style.color = "red";
                    } else {
                        addPasswordMessage.innerHTML = "Passwords match!";
                        addPasswordMessage.style.color = "green";
                    }
                }

                addPassword.addEventListener('keyup', validateAddPasswords);
                addConfirmPassword.addEventListener('keyup', validateAddPasswords);
            }

            // -----------------------------
            // EDIT MODALS PASSWORD TOGGLE & VALIDATION
            // -----------------------------
            @foreach ($admins as $admin)
                const editModal {
                    {
                        $admin - > id
                    }
                } = document.getElementById("adminEditModal-{{ $admin->id }}");
                if (editModal {
                        {
                            $admin - > id
                        }
                    }) {
                    const editPassword {
                        {
                            $admin - > id
                        }
                    } = editModal {
                        {
                            $admin - > id
                        }
                    }.querySelector('input[name="password"]');
                    const editConfirmPassword {
                        {
                            $admin - > id
                        }
                    } = editModal {
                        {
                            $admin - > id
                        }
                    }.querySelector('input[name="confirm_password"]');
                    const editPasswordMessage {
                        {
                            $admin - > id
                        }
                    } = editModal {
                        {
                            $admin - > id
                        }
                    }.querySelector('#edit_password_message_{{ $admin->id }}');

                    // Toggle password visibility
                    editModal {
                        {
                            $admin - > id
                        }
                    }.querySelectorAll('.toggle-edit-password').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const input = this.closest('.input-group').querySelector('input');
                            if (input.type === 'password') input.type = 'text';
                            else input.type = 'password';
                            this.querySelector('i').classList.toggle('bi-eye');
                            this.querySelector('i').classList.toggle('bi-eye-slash');
                        });
                    });

                    // Password match validation
                    function validateEditPasswords {
                        {
                            $admin - > id
                        }
                    }() {
                        if (editPassword {
                                {
                                    $admin - > id
                                }
                            }.value !== editConfirmPassword {
                                {
                                    $admin - > id
                                }
                            }.value) {
                            editPasswordMessage {
                                {
                                    $admin - > id
                                }
                            }.innerHTML = "Passwords do not match!";
                            editPasswordMessage {
                                {
                                    $admin - > id
                                }
                            }.style.color = "red";
                        } else {
                            editPasswordMessage {
                                {
                                    $admin - > id
                                }
                            }.innerHTML = "Passwords match!";
                            editPasswordMessage {
                                {
                                    $admin - > id
                                }
                            }.style.color = "green";
                        }
                    }

                    if (editPassword {
                            {
                                $admin - > id
                            }
                        } && editConfirmPassword {
                            {
                                $admin - > id
                            }
                        }) {
                        editPassword {
                            {
                                $admin - > id
                            }
                        }.addEventListener('keyup', validateEditPasswords {
                            {
                                $admin - > id
                            }
                        });
                        editConfirmPassword {
                            {
                                $admin - > id
                            }
                        }.addEventListener('keyup', validateEditPasswords {
                            {
                                $admin - > id
                            }
                        });
                    }
                }
            @endforeach
        });
    </script>
@endpush
