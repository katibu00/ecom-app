<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\LearningDomain;
use App\Models\LearningOutcome;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;


class EarlyYearsCrudController extends Controller
{

public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'domain' => 'required',
        'outcomes.*' => 'required',
    ]);

    $learningDomain = LearningDomain::create([
        'name' => $request->input('domain'),
        'school_id' => auth()->user()->school_id,
    ]);

    $outcomes = $request->input('outcomes');
    $learningOutcomes = [];

    foreach ($outcomes as $outcome) {
        $learningOutcomes[] = new LearningOutcome(['name' => $outcome, 'school_id' => auth()->user()->school_id]);
    }

    $learningDomain->learningOutcomes()->saveMany($learningOutcomes);

    // Redirect or return a response as desired
    Toastr::success('Save Successfully');
    return redirect()->route('learning_domains.index');
}

public function index()
{
    $data['learningDomains'] = LearningDomain::where('school_id', auth()->user()->school_id)->get();
    return view('settings.early_years.index', $data);
}


public function edit(LearningDomain $learning_domain)
{
    $learning_domain->load('learningOutcomes'); 
    return view('settings.early_years.edit', compact('learning_domain'));
}


public function update(Request $request, LearningDomain $learning_domain)
{
    $request->validate([
        'domain' => 'required',
        'outcomes.*' => 'required',
    ]);

    $learning_domain->update([
        'name' => $request->input('domain'),
    ]);

    $outcomes = $request->input('outcomes');
    $existingOutcomes = $learning_domain->learningOutcomes()->pluck('id')->toArray();
    $outcomesToKeep = [];

    foreach ($outcomes as $key => $outcome) {
        if (isset($existingOutcomes[$key])) {
            $learning_domain->learningOutcomes()->where('id', $existingOutcomes[$key])->update(['name' => $outcome]);
            $outcomesToKeep[] = $existingOutcomes[$key];
        } else {
            $createdOutcome = $learning_domain->learningOutcomes()->create(['name' => $outcome, 'school_id'=>auth()->user()->school_id]);
            $outcomesToKeep[] = $createdOutcome->id;
        }
    }

    $learning_domain->learningOutcomes()->whereNotIn('id', $outcomesToKeep)->delete();

    return redirect()->route('learning_domains.index')->with('success', 'Learning domain updated successfully.');
}



public function destroy(LearningDomain $learning_domain)
{
    $learning_domain->learningOutcomes()->delete(); // Delete associated outcomes
    $learning_domain->delete(); // Delete the learning domain itself

    return redirect()->route('learning_domains.index')->with('success', 'Learning domain and associated outcomes deleted successfully.');
}


}
