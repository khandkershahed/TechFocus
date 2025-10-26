<?php

namespace App\Http\Controllers\HR;

use Carbon\Carbon;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Admin\EmployeeCategory;
use App\Models\Admin\LeaveApplication;
use App\Http\Requests\LeaveApplicationRequest;
use App\Repositories\Interfaces\LeaveApplicationRepositoryInterface;

class LeaveApplicationController extends Controller
{
    private $leaveApplicationRepository;

    public function __construct(LeaveApplicationRepositoryInterface $leaveApplicationRepository)
    {
        $this->leaveApplicationRepository = $leaveApplicationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $data['leaveApplications'] = LeaveApplication::whereDate('created_at', '>=', $yesterday)
            ->whereDate('created_at', '<=', $today)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.pages.leaveApplication.index', $data);
    }

    public function history()
    {
        return view('admin.pages.leaveApplication.history', [
            'leaveApplications' =>  $this->leaveApplicationRepository->allLeaveApplication(),
        ]);
    }

public function dashboard()
{
    $user = Auth::guard('admin')->user();
    $employeeCategory = EmployeeCategory::whereId($user->category_id)->first();

    // Default values if employee category is not found
    $defaultYearlyCasualLeave = 10;
    $defaultYearlyEarnedLeave = 15;
    $defaultYearlyMedicalLeave = 14;

    // Get application statistics
    $totalApplications = LeaveApplication::where('employee_id', $user->id)->count();
    $approvedApplications = LeaveApplication::where('employee_id', $user->id)->where('application_status', 'approved')->count();
    $pendingApplications = LeaveApplication::where('employee_id', $user->id)->where('application_status', 'pending')->count();
    $rejectedApplications = LeaveApplication::where('employee_id', $user->id)->where('application_status', 'rejected')->count();

    // Calculate percentages
    $approvedPercentage = $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100) : 0;
    $pendingPercentage = $totalApplications > 0 ? round(($pendingApplications / $totalApplications) * 100) : 0;
    $rejectedPercentage = $totalApplications > 0 ? round(($rejectedApplications / $totalApplications) * 100) : 0;

    // Get recent applications
    $recentApplications = LeaveApplication::where('employee_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Calculate leave balances with null checks
    $casualLeaveAvailed = LeaveApplication::where('employee_id', $user->id)
        ->where('type_of_leave', 'Casual Leave')
        ->where('application_status', 'approved')
        ->sum('total_days') ?? 0;

    $earnedLeaveAvailed = LeaveApplication::where('employee_id', $user->id)
        ->where('type_of_leave', 'Earned Leave')
        ->where('application_status', 'approved')
        ->sum('total_days') ?? 0;

    $medicalLeaveAvailed = LeaveApplication::where('employee_id', $user->id)
        ->where('type_of_leave', 'Medical Leave')
        ->where('application_status', 'approved')
        ->sum('total_days') ?? 0;

    // Use employee category values or defaults
    $yearlyCasualLeave = $employeeCategory ? $employeeCategory->yearly_casual_leave : $defaultYearlyCasualLeave;
    $yearlyEarnedLeave = $employeeCategory ? $employeeCategory->yearly_earned_leave : $defaultYearlyEarnedLeave;
    $yearlyMedicalLeave = $employeeCategory ? $employeeCategory->yearly_medical_leave : $defaultYearlyMedicalLeave;

    $casualLeaveDue = $yearlyCasualLeave - $casualLeaveAvailed;
    $earnedLeaveDue = $yearlyEarnedLeave - $earnedLeaveAvailed;
    $medicalLeaveDue = $yearlyMedicalLeave - $medicalLeaveAvailed;

    // Ensure due days are not negative
    $casualLeaveDue = max(0, $casualLeaveDue);
    $earnedLeaveDue = max(0, $earnedLeaveDue);
    $medicalLeaveDue = max(0, $medicalLeaveDue);

    // Calculate percentages
    $casualLeavePercentage = $yearlyCasualLeave > 0 ? round(($casualLeaveAvailed / $yearlyCasualLeave) * 100) : 0;
    $earnedLeavePercentage = $yearlyEarnedLeave > 0 ? round(($earnedLeaveAvailed / $yearlyEarnedLeave) * 100) : 0;
    $medicalLeavePercentage = $yearlyMedicalLeave > 0 ? round(($medicalLeaveAvailed / $yearlyMedicalLeave) * 100) : 0;

    $data = [
        'user' => $user,
        'employeeCategory' => $employeeCategory,
        'totalApplications' => $totalApplications,
        'approvedApplications' => $approvedApplications,
        'pendingApplications' => $pendingApplications,
        'rejectedApplications' => $rejectedApplications,
        'approvedPercentage' => $approvedPercentage,
        'pendingPercentage' => $pendingPercentage,
        'rejectedPercentage' => $rejectedPercentage,
        'recentApplications' => $recentApplications,
        'casualLeaveAvailed' => $casualLeaveAvailed,
        'earnedLeaveAvailed' => $earnedLeaveAvailed,
        'medicalLeaveAvailed' => $medicalLeaveAvailed,
        'casualLeaveDue' => $casualLeaveDue,
        'earnedLeaveDue' => $earnedLeaveDue,
        'medicalLeaveDue' => $medicalLeaveDue,
        'casualLeavePercentage' => $casualLeavePercentage,
        'earnedLeavePercentage' => $earnedLeavePercentage,
        'medicalLeavePercentage' => $medicalLeavePercentage,
        'yearlyCasualLeave' => $yearlyCasualLeave,
        'yearlyEarnedLeave' => $yearlyEarnedLeave,
        'yearlyMedicalLeave' => $yearlyMedicalLeave,
    ];

    return view('admin.pages.leaveApplication.dashboard', $data);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function create()
{
    return view('admin.pages.leaveApplication.create');
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveApplicationRequest $request)
    {
        $substituteSignatureFile = $request->file('substitute_signature');
        $checkedByFile           = $request->file('checked_by');
        $recommendedByFile       = $request->file('recommended_by');
        $reviewedByFile          = $request->file('reviewed_by');
        $approvedByFile          = $request->file('approved_by');

        $filePath = storage_path('app/public/');

        $globalFunSubstituteSignature = empty($substituteSignatureFile) ? ['status' => 0] : customUpload($substituteSignatureFile, $filePath, 44, 44);
        $globalFunCheckedBy = empty($checkedByFile) ? ['status' => 0] : customUpload($checkedByFile, $filePath, 44, 44);
        $globalFunRecommendedBy = empty($recommendedByFile) ? ['status' => 0] : customUpload($recommendedByFile, $filePath, 44, 44);
        $globalFunReviewedBy = empty($reviewedByFile) ? ['status' => 0] : customUpload($reviewedByFile, $filePath, 44, 44);
        $globalFunApprovedBy = empty($approvedByFile) ? ['status' => 0] : customUpload($approvedByFile, $filePath, 44, 44);

        $data = [
            'country_id'              => $request->country_id,
            'employee_id'             => $request->employee_id,
            'company_id'              => $request->company_id,
            'name'                    => $request->name,
            'type_of_leave'           => $request->type_of_leave,
            'designation'             => $request->designation,
            'company'                 => $request->company,
            'leave_start_date'        => $request->leave_start_date,
            'leave_end_date'          => $request->leave_end_date,
            'total_days'              => $request->total_days,
            'job_status'              => $request->job_status,
            'reporting_on'            => $request->reporting_on,
            'leave_explanation'       => $request->leave_explanation,
            'substitute_during_leave' => $request->substitute_during_leave,
            'leave_address'           => $request->leave_address,
            'is_between_holidays'     => $request->is_between_holidays,
            'leave_contact_no'        => $request->leave_contact_no,
            'included_open_saturday'  => $request->included_open_saturday,
            'substitute_signature'    => $globalFunSubstituteSignature['status'] == 1 ? $globalFunSubstituteSignature['file_name'] : null,
            'applicant_signature'     => $request->applicant_signature, //file.It will automatically come from employee form.No need to add another image to database,just add the image name.
            'leave_position'          => $request->leave_position,
            'casual_leave_due_as_on'  => $request->casual_leave_due_as_on,
            'casual_leave_availed'    => $request->casual_leave_availed,
            'casual_balance_due'      => $request->casual_balance_due,
            'earned_leave_due_as_on'  => $request->earned_leave_due_as_on,
            'earned_leave_availed'    => $request->earned_leave_availed,
            'earned_balance_due'      => $request->earned_balance_due,
            'medical_leave_due_as_on' => $request->medical_leave_due_as_on,
            'medical_leave_availed'   => $request->medical_leave_availed,
            'medical_balance_due'     => $request->medical_balance_due,
            'checked_by'              => $globalFunCheckedBy['status']           == 1 ? $globalFunCheckedBy['file_name']          : null,
            'recommended_by'          => $globalFunRecommendedBy['status']       == 1 ? $globalFunRecommendedBy['file_name']      : null,
            'reviewed_by'             => $globalFunReviewedBy['status']          == 1 ? $globalFunReviewedBy['file_name']         : null,
            'approved_by'             => $globalFunApprovedBy['status']          == 1 ? $globalFunApprovedBy['file_name']         : null,
            'application_status'      => $request->application_status,
            'note'                    => $request->note,
        ];
        $this->leaveApplicationRepository->storeLeaveApplication($data);

        session()->flash('success', 'Data has been saved successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(LeaveApplicationRequest $request, $id)
    {
        $leaveApplication = $this->leaveApplicationRepository->findLeaveApplication($id);

        // Handle file uploads
        $applicantSignatureFile = $request->file('applicant_signature');
        $substituteSignatureFile = $request->file('substitute_signature');
        $checkedByFile = $request->file('checked_by');
        $recommendedByFile = $request->file('recommended_by');
        $reviewedByFile = $request->file('reviewed_by');
        $approvedByFile = $request->file('approved_by');

        $filePath = storage_path('app/public/');

        // Handle applicant signature upload (optional for update)
        if (!empty($applicantSignatureFile)) {
            $globalFunApplicantSignature = customUpload($applicantSignatureFile, $filePath, 44, 44);
            // Delete old file if exists
            if ($leaveApplication->applicant_signature) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->applicant_signature}"),
                    storage_path("app/public/requestImg/{$leaveApplication->applicant_signature}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunApplicantSignature = ['status' => 0];
        }

        // Handle other file uploads
        if (!empty($substituteSignatureFile)) {
            $globalFunSubstituteSignature = customUpload($substituteSignatureFile, $filePath, 44, 44);
            if ($leaveApplication->substitute_signature) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->substitute_signature}"),
                    storage_path("app/public/requestImg/{$leaveApplication->substitute_signature}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunSubstituteSignature = ['status' => 0];
        }

        // Similar handling for other files (checked_by, recommended_by, reviewed_by, approved_by)
        if (!empty($checkedByFile)) {
            $globalFunCheckedBy = customUpload($checkedByFile, $filePath, 44, 44);
            if ($leaveApplication->checked_by) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->checked_by}"),
                    storage_path("app/public/requestImg/{$leaveApplication->checked_by}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunCheckedBy = ['status' => 0];
        }

        if (!empty($recommendedByFile)) {
            $globalFunRecommendedBy = customUpload($recommendedByFile, $filePath, 44, 44);
            if ($leaveApplication->recommended_by) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->recommended_by}"),
                    storage_path("app/public/requestImg/{$leaveApplication->recommended_by}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunRecommendedBy = ['status' => 0];
        }

        if (!empty($reviewedByFile)) {
            $globalFunReviewedBy = customUpload($reviewedByFile, $filePath, 44, 44);
            if ($leaveApplication->reviewed_by) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->reviewed_by}"),
                    storage_path("app/public/requestImg/{$leaveApplication->reviewed_by}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunReviewedBy = ['status' => 0];
        }

        if (!empty($approvedByFile)) {
            $globalFunApprovedBy = customUpload($approvedByFile, $filePath, 44, 44);
            if ($leaveApplication->approved_by) {
                $paths = [
                    storage_path("app/public/{$leaveApplication->approved_by}"),
                    storage_path("app/public/requestImg/{$leaveApplication->approved_by}")
                ];
                foreach ($paths as $path) {
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
            }
        } else {
            $globalFunApprovedBy = ['status' => 0];
        }

        $data = [
            'country_id'              => $request->country_id ?? $leaveApplication->country_id,
            'employee_id'             => $request->employee_id ?? $leaveApplication->employee_id,
            'company_id'              => $request->company_id ?? $leaveApplication->company_id,
            'name'                    => $request->name,
            'type_of_leave'           => $request->type_of_leave,
            'designation'             => $request->designation,
            'company'                 => $request->company,
            'leave_start_date'        => $request->leave_start_date,
            'leave_end_date'          => $request->leave_end_date,
            'total_days'              => $request->total_days ?? $leaveApplication->total_days,
            'job_status'              => $request->job_status,
            'reporting_on'            => $request->reporting_on,
            'leave_explanation'       => $request->leave_explanation,
            'substitute_during_leave' => $request->substitute_during_leave,
            'leave_address'           => $request->leave_address,
            'is_between_holidays'     => $request->is_between_holidays,
            'leave_contact_no'        => $request->leave_contact_no,
            'included_open_saturday'  => $request->included_open_saturday,
            
            // File paths - use new file if uploaded, otherwise keep old one
            'applicant_signature'     => $globalFunApplicantSignature['status'] == 1 ? $globalFunApplicantSignature['file_name'] : $leaveApplication->applicant_signature,
            'substitute_signature'    => $globalFunSubstituteSignature['status'] == 1 ? $globalFunSubstituteSignature['file_name'] : $leaveApplication->substitute_signature,
            
            // Leave balance fields
            'casual_leave_due_as_on'  => $request->casual_leave_due_as_on ?? $leaveApplication->casual_leave_due_as_on,
            'casual_leave_availed'    => $request->casual_leave_availed ?? $leaveApplication->casual_leave_availed,
            'casual_balance_due'      => $request->casual_balance_due ?? $leaveApplication->casual_balance_due,
            'earned_leave_due_as_on'  => $request->earned_leave_due_as_on ?? $leaveApplication->earned_leave_due_as_on,
            'earned_leave_availed'    => $request->earned_leave_availed ?? $leaveApplication->earned_leave_availed,
            'earned_balance_due'      => $request->earned_balance_due ?? $leaveApplication->earned_balance_due,
            'medical_leave_due_as_on' => $request->medical_leave_due_as_on ?? $leaveApplication->medical_leave_due_as_on,
            'medical_leave_availed'   => $request->medical_leave_availed ?? $leaveApplication->medical_leave_availed,
            'medical_balance_due'     => $request->medical_balance_due ?? $leaveApplication->medical_balance_due,
            
            // Approval signatures
            'checked_by'              => $globalFunCheckedBy['status'] == 1 ? $globalFunCheckedBy['file_name'] : $leaveApplication->checked_by,
            'recommended_by'          => $globalFunRecommendedBy['status'] == 1 ? $globalFunRecommendedBy['file_name'] : $leaveApplication->recommended_by,
            'reviewed_by'             => $globalFunReviewedBy['status'] == 1 ? $globalFunReviewedBy['file_name'] : $leaveApplication->reviewed_by,
            'approved_by'             => $globalFunApprovedBy['status'] == 1 ? $globalFunApprovedBy['file_name'] : $leaveApplication->approved_by,
            
            'application_status'      => $request->application_status,
            'note'                    => $request->note,
        ];

        $this->leaveApplicationRepository->updateLeaveApplication($data, $id);

        session()->flash('success', 'Leave application has been updated successfully!');
        return redirect()->route('leave-applications.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $leaveApplication = $this->leaveApplicationRepository->findLeaveApplication($id);

        $attributes = [
            'applicant_signature',
            'substitute_signature',
            'checked_by',
            'recommended_by',
            'reviewed_by',
            'approved_by'
        ];

        $basePaths = [
            storage_path('app/public/'),
            storage_path('app/public/requestImg/')
        ];

        $paths = [];

        foreach ($attributes as $attribute) {
            foreach ($basePaths as $basePath) {
                $paths[] = $basePath . $leaveApplication->{$attribute};
            }
        }

        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $this->leaveApplicationRepository->destroyLeaveApplication($id);
        
        session()->flash('success', 'Leave application has been deleted successfully!');
        return redirect()->back();
    }


    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'type_of_leave' => 'required|string|max:255',
            'leave_start_date' => 'required|date',
            'leave_end_date' => 'required|date|after_or_equal:leave_start_date',
            'total_days' => 'required|integer|min:1',
            'job_status' => 'required|string|max:255',
            'reporting_on' => 'required|date|after:leave_end_date',
            'leave_explanation' => 'required|string',
            'substitute_during_leave' => 'required|string|max:255',
            'leave_address' => 'nullable|string|max:255',
            'leave_contact_no' => 'nullable|string|max:20',
            'is_between_holidays' => 'required|in:yes,no',
            'included_open_saturday' => 'nullable|string|max:255',
            
            // Leave balance fields - INTEGER
            'earned_leave_due_as_on' => 'required|integer|min:0',
            'earned_leave_availed' => 'required|integer|min:0',
            'earned_balance_due' => 'required|integer|min:0',
            'casual_leave_due_as_on' => 'required|integer|min:0',
            'casual_leave_availed' => 'required|integer|min:0',
            'casual_balance_due' => 'required|integer|min:0',
            'medical_leave_due_as_on' => 'required|integer|min:0',
            'medical_leave_availed' => 'required|integer|min:0',
            'medical_balance_due' => 'required|integer|min:0',
            
            // File validation rules
            'applicant_signature' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'substitute_signature' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'checked_by' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'recommended_by' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'reviewed_by' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'approved_by' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            
            'note' => 'nullable|string',
            'application_status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function messages()
    {
        return [
            'applicant_signature.required' => 'Applicant signature is required.',
            'applicant_signature.mimes' => 'Applicant signature must be a JPG, JPEG, or PNG file.',
            'applicant_signature.max' => 'Applicant signature must not exceed 2MB.',
            'total_days.required' => 'Total days is required.',
            'total_days.min' => 'Total days must be at least 1.',
            'reporting_on.after' => 'Reporting date must be after leave end date.',
            '*.required' => 'All leave balance fields are required.',
            '*.integer' => 'Leave balance fields must be whole numbers.',
            '*.min' => 'Leave balance fields cannot be negative.',
        ];
    }


}
