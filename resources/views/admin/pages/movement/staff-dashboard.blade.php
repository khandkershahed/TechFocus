@extends('admin.master')

@section('content')
<div class="container-fluid py-4"> <!-- Changed to container-fluid for full width -->

    <!-- Header -->
    <div class="bg-primary text-white rounded shadow p-3 text-center mb-4">
        <h2 class="h5 fw-bold text-uppercase">SALES - MOVEMENT STATISTICS</h2>
    </div>

    <div class="row g-4 mb-4">
        <!-- Card 1: #Days / Companies / Visits / Areas -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Days</h6>
                        <h3 class="fw-bold mb-0">{{ $totalDays }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Companies</h6>
                        <h3 class="fw-bold mb-0">{{ $totalCompanies }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Visits</h6>
                        <h3 class="fw-bold mb-0">{{ $totalVisits }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0"># of Areas</h6>
                        <h3 class="fw-bold mb-0">{{ $totalAreas }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Highest / Lowest / Companies / Frequent -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Highest Value & Company</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($highestValue ?? 0) }} Tk</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Lowest Value & Company</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($lowestValue ?? 0) }} Tk</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Frequent Visits</h6>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0">Name Of those Companies</h6>
                        <h3 class="fw-bold mb-0">{{ $companies->implode(', ') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Working / Closed / Lost / Transport -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Working Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Closed Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Lost Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0">Transport Cost</h6>
                        <h3 class="fw-bold mb-0">Tk. {{ number_format($transportCost) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Sales Target / Achieved / Cost Ratio -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center" style="background: linear-gradient(135deg, #0d6efd, #6610f2); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-light mb-0">Sales Target</h6>
                        <h3 class="fw-bold mb-0">Tk. {{ number_format($salesTarget) }}</h3>
                    </div>

                    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">

                    @php
                        $achievedPercent = $salesTarget > 0 ? ($records->sum('value') / $salesTarget) * 100 : 0;
                        $costRatio = $records->sum('cost') > 0 && $records->sum('value') > 0 ? ($records->sum('cost') / $records->sum('value') * 100) : 0;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-light mb-0">Achieved %</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($achievedPercent, 2) }}%</h3>
                    </div>

                    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-light mb-0">Cost Ratio</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($costRatio, 2) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow rounded p-3 bg-light">
        <table class="table table-bordered table-hover mb-0 align-middle" style="border-color: #dee2e6; min-width: 1200px;">
            <thead style="background: linear-gradient(135deg, #0d6efd, #6610f2); color:white;">
                <tr>
                    @foreach(['Status','Date','Start','Finish','Duration','Area','Transport','Cost','Movementyy Type','Company','Contact','Number','Value','Status','Purpose'] as $header)
                        <th class="text-center small fw-bold">{{ $header }}</th>
                    @endforeach
                    <th class="text-center small fw-bold">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                <tr class="clickable-row" data-href="{{ route('admin.movement.show', $record->id) }}" 
                    style="background-color: {{ $index % 2 === 0 ? '#f8f9fa' : '#ffffff' }};">
                    <td class="text-center">{{ ucfirst($record->status) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($record->date)->format('d-M-Y') }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->start_time)) }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->end_time)) }}</td>
                    <td class="text-center">{{ $record->duration }}</td>
                    <td class="text-center">{{ $record->area }}</td>
                    <td class="text-center">{{ $record->transport }}</td>
                    <td class="text-end">Tk. {{ number_format($record->cost) }}</td>
                    <td class="text-center">{{ $record->meeting_type }}</td>
                    <td class="text-start">{{ $record->company }}</td>
                    <td class="text-start">{{ $record->contact_person }}</td>
                    <td class="text-center">{{ $record->contact_number }}</td>
                    <td class="text-end">Tk. {{ number_format($record->value) }}</td>
                    <td class="text-center">{{ $record->status }}</td>
                    <td class="text-start">{{ $record->purpose }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.movement.show', $record->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $records->links() }}
    </div>

    <!-- JS for clickable rows -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll(".clickable-row");
            rows.forEach(row => {
                row.style.cursor = "pointer";
                row.addEventListener("mouseover", () => row.style.backgroundColor = '#e9ecef'); // highlight on hover
                row.addEventListener("mouseout", () => {
                    const index = Array.from(row.parentNode.children).indexOf(row);
                    row.style.backgroundColor = index % 2 === 0 ? '#f8f9fa' : '#ffffff';
                });
                row.addEventListener("click", function(e) {
                    if(e.target.tagName.toLowerCase() !== 'a' && !e.target.closest('a')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });
        });
    </script>

</div>
@endsection
