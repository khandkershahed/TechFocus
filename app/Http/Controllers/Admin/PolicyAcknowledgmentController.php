<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolicyAcknowledgmentRequest;
use App\Models\Admin;
use App\Repositories\Interfaces\HrPolicyRepositoryInterface;
use App\Repositories\Interfaces\PolicyAcknowledgmentRepositoryInterface;

class PolicyAcknowledgmentController extends Controller
{
    private $policyAcknowledgmentRepository, $hrPolicyRepository;

    public function __construct(PolicyAcknowledgmentRepositoryInterface $policyAcknowledgmentRepository, HrPolicyRepositoryInterface $hrPolicyRepository)
    {
        $this->policyAcknowledgmentRepository = $policyAcknowledgmentRepository;
        $this->hrPolicyRepository             = $hrPolicyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.policyAcknowledgment.index', [
            'policyAcknowledgments' => $this->policyAcknowledgmentRepository->allPolicyAcknowledgment(),
            'hrPolicies'            => $this->hrPolicyRepository->allHrPolicy(),
            'admins'                => Admin::get(['id', 'name']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyAcknowledgmentRequest $request)
    {
        $data = [
            'country_id'  => $request->country_id,
            'employee_id' => $request->employee_id,
            'policy_id'   => $request->policy_id,
            'sign'        => $request->sign,
            'status'      => $request->status,
        ];
        $this->policyAcknowledgmentRepository->storePolicyAcknowledgment($data);

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
    public function update(PolicyAcknowledgmentRequest $request, $id)
    {
        $data = [
            'country_id'  => $request->country_id,
            'employee_id' => $request->employee_id,
            'policy_id'   => $request->policy_id,
            'sign'        => $request->sign,
            'status'      => $request->status,
        ];

        $this->policyAcknowledgmentRepository->updatePolicyAcknowledgment($data, $id);

        session()->flash('success', 'Data has been saved successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->policyAcknowledgmentRepository->destroyPolicyAcknowledgment($id);
    }
}
