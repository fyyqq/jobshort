@extends('employer.layouts.app')

@section('content')
<div class="container-employer pt-4 px-4">
    <div class="content">
        <div class="p-4 border shadow-sm" style="background-color: #fff;">
            <h1 class="h4 text-dark mb-1">My Dashboard</h1>
        </div>
        <div class="mt-3 border py-4 px-2 shadow-sm" style="background-color: #fff; height: 550px;">
            <div class="row mx-0">
                <div class="" style="display:grid; grid-template-columns: repeat(4, 1fr); column-gap: 10px;">
                    <a href="{{ route('employer.jobs') }}" class="text-decoration-none border rounded py-3 px-0 d-flex align-items-center justify-content-center">
                        <div class="col-4 d-flex justify-content-center">
                            <i style="font-size: 20px;" class="fa-solid fa-briefcase text-dark"></i>
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <div class="">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">All service</p>
                                <small class="text-muted">{{ count($dataJobs) < 1 ? 'No Jobs' : count($dataJobs) . ' Jobs' }}</small>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employer.live-jobs') }}" class="text-decoration-none border rounded py-3 px-0 d-flex align-items-center justify-content-center">
                        <div class="col-4 d-flex justify-content-center">
                            <i style="font-size: 20px;" class="fa-solid fa-briefcase text-dark"></i>
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <div class="">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">Active Service</p>
                                <small class="text-muted">{{ count($dataJobs->where('status', 'live')) < 1 ? 'No Jobs' : count($dataJobs->where('status', 'live')) . ' Jobs' }}</small>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employer.applicant') }}" class="text-decoration-none border rounded py-3 px-2 d-flex align-items-center justify-content-center">
                        <div class="col-4 d-flex justify-content-center">
                            <i style="font-size: 20px;" class="fa-solid fa-user-plus text-dark"></i>
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <div class="">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">New Customer</p>
                                {{-- <small class="text-muted">{{ count($dataApplicant->where('status', 'pending')) < 1 ? 'No applicant' : count($dataApplicant->where('status', 'pending')) . ' Applicant Pending' }}</small> --}}
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('employer.applicant-completed') }}" class="text-decoration-none border rounded py-3 px-2 d-flex align-items-center justify-content-center">
                        <div class="col-4 d-flex justify-content-center">
                            <i style="font-size: 20px;" class="fa-solid fa-user-check text-dark"></i>
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <div class="">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">Customer Completed</p>
                                {{-- <small class="text-muted">{{ count($dataApplicant->where('status', 'completed')) < 1 ? 'No recruit yet' : count($dataApplicant->where('status', 'completed')) . ' Recruit' }}</small> --}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection