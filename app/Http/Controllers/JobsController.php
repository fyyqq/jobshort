<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Employer;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{

    public function show(string $slug) {
        return view('apply-jobs', [
            'dataJobs' => Job::where('slug', $slug)->first()
        ]);
    }

    public function store(string $slug, $id) {
        $jobs = Job::where('slug', $slug)->first();

        $application = new Application();
        $application->slug = Str::slug(uniqid() . Auth::id());
        $application->user_id = Auth::id();
        $application->job_id = $jobs->id;
        $application->employer_id = $id;
        $application->save();
    }
}
