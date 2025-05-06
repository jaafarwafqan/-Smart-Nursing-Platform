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
        $this->middleware('auth');
        $this->middleware('permission:manage_users')->except(['profile', 'updateProfile', 'changePassword']);
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->with(['roles', 'branch'])
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
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        $rolesForSelect = $roles->pluck('name', 'id');
        return view('users.create', [
            'types'    => config('types.user_types', []),
            'branches' => \App\Models\Branch::pluck('name', 'id'),
            'roles'    => $rolesForSelect,
            'rolesData' => $roles,
        ]);
    }

    public function edit(User $user): View
    {
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        $rolesForSelect = $roles->pluck('name', 'id');
        return view('users.edit', [
            'user'     => $user,
            'types'    => config('types.user_types', []),
            'branches' => \App\Models\Branch::pluck('name', 'id'),
            'roles'    => $rolesForSelect,
            'rolesData' => $roles,
        ]);
    }
    public function export(Request $request)
    {
        return (new \App\Exports\UsersExport($request->all()))->download('users.xlsx');
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->service->create($request->validated());
        return to_route('users.index')->withSuccess('تمّ إنشاء المستخدم');
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

    // ====== دوال الملف الشخصي ======
    public function profile(Request $request)
    {
        return view('users.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // أضف الحقول الأخرى حسب الحاجة
        ]);
        $user->update($data);
        return back()->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user->update(['password' => bcrypt($data['password'])]);
        return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
