<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:عرض المقاسات,admin')->only('index');
        $this->middleware('permission:تعديل المقاسات,admin')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء المقاسات,admin')->only(['create', 'store']);
        $this->middleware('permission:حذف المقاسات,admin')->only('destroy');
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Size::query();
            return \datatables()::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    return '
                            <button ' . $edit . '   class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $row->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </span>
                            </button>
                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>
                       ';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('Admin.CRUDS.sizes.index');
    }

    public function create()
    {
        $branches = Branch::get();
        return view('Admin.CRUDS.sizes.parts.create', \compact('branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $data['publisher'] = auth('admin')->user()->id;

        Size::create($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function edit($id)
    {

        $row = Size::find($id);
        $branches = Branch::get();

        return view('Admin.CRUDS.sizes.parts.edit', compact('row', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $row = Size::find($id);
        $row->update($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function destroy($id)
    {

        $row = Size::find($id);

        $row->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    } //end fun

    public function getSizes(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $term = trim($request->term);
        $posts = DB::table('sizes')->applyBranchCondition()
            ->select('id', 'title as text')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->orderBy('title', 'asc')
            ->simplePaginate(3);

        $morePages = !empty($posts->nextPageUrl());

        return response()->json([
            "results" => $posts->items(),
            "pagination" => ["more" => $morePages],
        ]);
    }

}
