<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private UserServiceInterface $service)
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search,     fn ($q, $s) => $q->whereFullText(['name', 'email'], $s))
            ->when($request->type,       fn ($q, $t) => $q->where('type', $t))
            ->when($request->branch_id,  fn ($q, $b) => $q->where('branch_id', $b))
            ->orderBy($request->get('sort', 'created_at'), $request->get('direction', 'desc'))
            ->paginate(15);

        $stats = [
            'total'      => User::count(),
            'admins'     => User::where('type', 'admin')->count(),
            'professors' => User::where('type', 'professor')->count(),
            'students'   => User::where('type', 'student')->count(),
        ];

        $types    = config('types.user_types', []);          // 👈 قيمة افتراضية []
        $branches = Branch::pluck('name', 'id')->toArray();  // 👈 مصفوفة لا Collection

        return view('users.index', compact('users', 'types', 'branches', 'stats'));
    }
    public function create(): View
    {
        return view('users.create', [
            'types'    => config('types.user_types', []),
            'branches' => Branch::pluck('name', 'id'),
            'roles'    => Role::pluck('name'),
        ]);
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user'     => $user,
            'types'    => config('types.user_types', []),
            'branches' => Branch::pluck('name', 'id'),
            'roles'    => Role::pluck('name'),
        ]);
    }
    public function export(Request $request)
    {
        return (new \App\Exports\UsersExport($request->all()))->download('users.xlsx');
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->service->create($request->validated());
        return to_route('users.show', $user)->withSuccess('تمّ إنشاء المستخدم');
    }




    public function update(StoreUserRequest $request, User $user): RedirectResponse
    {
        $this->service->update($user, $request->validated());
        return back()->withSuccess('تمّ التعديل');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->service->delete($user);
        return to_route('users.index')->withSuccess('تمّ الحذف');
    }
}
