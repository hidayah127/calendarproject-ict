<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Staff;
use App\Models\Programstaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommitteeAppointmentMail;

class CommitteeController extends Controller
{
    /**
     * Show committee management page for a program.
     */
    public function index(Program $program)
    {
        $this->authorise($program);

        $program->load(['committee', 'department', 'staffInCharge']);

        // Staff in the same department, excluding those already in committee
        $committeeIds = $program->committee->pluck('id');

        // $availableStaff = Staff::where('department_id', $program->department_id)
        //     ->whereNotIn('id', $committeeIds)
        //     ->orderBy('name')
        //     ->get();

        $availableStaff = Staff::with('department')
        ->whereNotIn('id', $committeeIds)
        ->orderBy('name')
        ->get();

        $roles = [   
            'committee_head'   => 'Committee Head',
            'coordinator'      => 'Coordinator',
            'secretary'        => 'Secretary',
            'treasurer'        => 'Treasurer',
            'facilitator'      => 'Facilitator',
            'committee_member' => 'Committee Member',
        ];

        return view('Head.Committee', compact('program', 'availableStaff', 'roles'));
    }
  
    /**
     * Add a staff member to the committee.
     */

    // public function store(Request $request, Program $program)
    // {
    //     $this->authorise($program);

    //     $request->validate([
    //         'staff_id'       => 'required|exists:staff,id',
    //         'role'           => 'required|in:committee_member,committee_head,coordinator,facilitator,secretary,treasurer',
    //         'responsibility' => 'nullable|string|max:255',
    //         'is_lead'        => 'boolean',
    //     ]);

    //     // ✅ Query pivot table directly — no JOIN, no ambiguity
    //     $alreadyExists = DB::table('program_staff')
    //         ->where('program_id', $program->id)
    //         ->where('staff_id', $request->staff_id)
    //         ->exists();

    //     if ($alreadyExists) {
    //         return redirect()->back()->with('error', 'This staff member is already in the committee.');
    //     }

    //     // Strip existing lead if new one is being set
    //     if ($request->boolean('is_lead')) {
    //         DB::table('program_staff')
    //             ->where('program_id', $program->id)
    //             ->where('is_lead', true)
    //             ->update(['is_lead' => false]);
    //     }

    //     $program->committee()->attach($request->staff_id, [
    //         'role'           => $request->role,
    //         'responsibility' => $request->responsibility,
    //         'is_lead'        => $request->boolean('is_lead'),
    //     ]);

    //     return redirect()->back()->with('success', 'Committee member added successfully.');
    // }

    public function store(Request $request, Program $program)
    {
        $this->authorise($program);

        $request->validate([
            'staff_id'       => 'required|array',
            'staff_id.*'     => 'exists:staff,id',

            'role'           => 'required|array',
            'role.*'         => 'required|in:committee_member,committee_head,coordinator,facilitator,secretary,treasurer',

            'responsibility' => 'array',
            'responsibility.*' => 'nullable|string|max:255',

            'is_lead'        => 'array',
        ]);

        foreach ($request->staff_id as $index => $staffId) {

            /* ✅ Check duplicate */
            $alreadyExists = DB::table('program_staff')
                ->where('program_id', $program->id)
                ->where('staff_id', $staffId)
                ->exists();

            if ($alreadyExists) {
                continue; // skip duplicate
            }

            /* ✅ Handle lead */
            $isLead = isset($request->is_lead[$index]);

            if ($isLead) {

                DB::table('program_staff')
                    ->where('program_id', $program->id)
                    ->where('is_lead', true)
                    ->update(['is_lead' => false]);

            }

            /* ✅ Attach member */
            $program->committee()->attach($staffId, [

                'role' =>
                    $request->role[$index],

                'responsibility' =>
                    $request->responsibility[$index] ?? null,

                'is_lead' =>
                    $isLead,

            ]);

        }

        return redirect()->back()
            ->with('success',
                'Committee members added successfully.');
    }

    /**
     * Update a committee member's role/responsibility.
     */
    public function update(Request $request, Program $program, Staff $staff)
    {
        $this->authorise($program);

        $request->validate([
            'role'           => 'required|in:committee_member,committee_head,coordinator,facilitator,secretary,treasurer',
            'responsibility' => 'nullable|string|max:255',
            'is_lead'        => 'boolean',
        ]);

        // Strip existing lead if a new one is being set
        if ($request->boolean('is_lead')) {
            $program->committee()->newPivotStatement()
                ->where('program_id', $program->id)
                ->where('staff_id', '!=', $staff->id)
                ->update(['is_lead' => false]);
        }

        $program->committee()->updateExistingPivot($staff->id, [
            'role'           => $request->role,
            'responsibility' => $request->responsibility,
            'is_lead'        => $request->boolean('is_lead'),
        ]);

        return redirect()->back()->with('success', 'Committee member updated.');
    }

    /**
     * Remove a staff member from the committee.
     */
    public function destroy(Program $program, Staff $staff)
    {
        $this->authorise($program);

        $program->committee()->detach($staff->id);

        return redirect()->back()->with('success', 'Member removed from committee.');
    }

     // importCSV method is not needed here, it belongs to StaffController
    public function importCSV(Request $request, Program $program)
    {
        $this->authorise($program);

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        // Skip header row
        fgetcsv($file);

        $count = 0;
        $skipped = 0;

        while (($row = fgetcsv($file)) !== false) {

            // CSV columns:
            // 0 = staff_id
            // 1 = role
            // 2 = responsibility
            // 3 = is_lead

            $staffId = trim($row[0]);

            // Find staff by staff_id
            $staff = Staff::where('staff_id', $staffId)->first();

            if (!$staff) {
                $skipped++;
                continue;
            }

            // Check duplicate
            $exists = DB::table('program_staff')
                ->where('program_id', $program->id)
                ->where('staff_id', $staff->id)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            $isLead = isset($row[3]) && $row[3] == 1;

            // Remove old lead if new lead exists
            if ($isLead) {
                DB::table('program_staff')
                    ->where('program_id', $program->id)
                    ->where('is_lead', true)
                    ->update(['is_lead' => false]);
            }

            $program->committee()->attach($staff->id, [
                'role'           => $row[1] ?? 'committee_member',
                'responsibility' => $row[2] ?? null,
                'is_lead'        => $isLead,
            ]);

            $count++;
        }

        fclose($file);

        return redirect()->back()->with(
            'success',
            "$count members imported. $skipped skipped."
        );
    }
 
    /**
     * Only the program creator (HD) can manage committee.
     */
    private function authorise(Program $program): void
    {
        if ($program->created_by !== Auth::id()) {
            abort(403, 'You are not authorised to manage this committee.');
        }
    }

    public function notifyAll(Program $program)
    {
        $this->authorise($program);

        $program->load(['committee', 'department']);

        if ($program->committee->isEmpty()) {
            return redirect()->back()->with('error', 'No committee members to notify.');
        }

        $roleLabels = [
            'committee_head'   => 'Ketua Jawatankuasa',
            'coordinator'      => 'Penyelaras',
            'secretary'        => 'Setiausaha',
            'treasurer'        => 'Bendahari',
            'facilitator'      => 'Fasilitator',
            'committee_member' => 'Ahli Jawatankuasa',
        ];

        $sent = 0;

        foreach ($program->committee as $member) {
            $role = $roleLabels[$member->pivot->role] ?? ucfirst($member->pivot->role);

            Mail::to($member->email)->send(
                new CommitteeAppointmentMail(
                    staff:          $member,
                    program:        $program,
                    role:           $role,
                    responsibility: $member->pivot->responsibility,
                    isLead:         (bool) $member->pivot->is_lead,
                )
            );

            $sent++;
        }

        return redirect()->back()->with('success', "Surat lantikan berjaya dihantar kepada {$sent} ahli jawatankuasa.");
    }

   
}
