<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Major;
use App\Models\Member;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with(['schoolClass', 'major']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn_nip', 'like', '%' . $request->search . '%')
                  ->orWhere('member_code', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->member_type) {
            $query->where('member_type', $request->member_type);
        }

        if ($request->class_id) {
            $query->where('school_class_id', $request->class_id);
        }

        $members = $query->latest()->paginate(15);

        $classes = SchoolClass::all();
        $majors = Major::all();

        return Inertia::render('members/index', [
            'members' => $members,
            'classes' => $classes,
            'majors' => $majors,
            'filters' => $request->only(['search', 'status', 'member_type', 'class_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('members/create', [
            'classes' => SchoolClass::all(),
            'majors' => Major::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $member = Member::create($request->validated());

        return redirect()->route('members.show', $member)
            ->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['schoolClass', 'major', 'transactions.book']);

        return Inertia::render('members/show', [
            'member' => $member,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return Inertia::render('members/edit', [
            'member' => $member,
            'classes' => SchoolClass::all(),
            'majors' => Major::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return redirect()->route('members.show', $member)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}