<?php

namespace Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Models\Auth\User;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\AccountRegistered;

class Users extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);

        return view("panel::users.index", ["users" => $users]);
    }

    /**
     * Display a form to create new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view("panel::users.create");
    }

    public function import(Request $request)
    {
        $users = Excel::toCollection(new UsersImport, $request->file('import_file'));

        foreach ($users[0] as $user) {
            if ($user['id'] != null) {
                if(!User::where('id', $user['id'])->update([
                    'first_name' => $user['ad'],
                    'last_name' => $user['soyad'],
                    'email' => $user['e_posta'],
                    'phone' => $user['telefon'],
                    'role' => $user['yetki']
                ])) {
                    if (!count(User::where('email', $user['e_posta'])->get())) {
                        User::create([
                            'first_name' => $user['ad'],
                            'last_name' => $user['soyad'],
                            'email' => $user['e_posta'],
                            'phone' => $user['telefon'],
                            'role' => $user['yetki'],
                            'password' => '',
                            'activation_code' => ''
                        ]);
                    }
                }
            } else {
                if (!count(User::where('email', $user['e_posta'])->get())) {
                    User::create([
                        'first_name' => $user['ad'],
                        'last_name' => $user['soyad'],
                        'email' => $user['e_posta'],
                        'phone' => $user['telefon'],
                        'role' => $user['yetki'],
                        'password' => '',
                        'activation_code' => ''
                    ]);
                }
            }
        }

        return redirect()
            ->route('panel.users.index');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'kullanicilar.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // hash password
        $password =
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        $request->merge([
            "password" => $password,
            "remember_token" => Str::random(10),
        ]);

        $validated = $request->validate([
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required|unique:users',
            'role' => '',
            'branch' => '',
        ]);

        $user = new User;

        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');
        $user->email = $request->input('email');
        $user->password = $password;
        $user->role = $request->input('role');
        $user->activation_code = md5($user->email . date('d.m.Y-h:i:s'));

        $meta = [
            'branch' => $request->input('branch'),
        ];

        $user->meta = $meta; 

        $user->save();

        $user->notify(new AccountRegistered($user));

        return redirect()
            ->route("panel.users.index")
            ->with(
                "message_success",
                trans("general.successfully_created", [
                    "type" => trans_choice("general.users", 1),
                ])
            );
    }

    /**
     * Display a form to edit resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = User::where("id", "=", $id)->first();

        if (!$user) {
            return redirect()
                ->route("panel.users.index")
                ->with(
                    "message_error",
                    trans("general.not_found", [
                        "type" => trans_choice("general.users", 1),
                    ])
                );
        }

        return view("panel::users.edit", ["user" => $user]);
    }

    /**
     * Update resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        try {
            $user = User::where("id", "=", $request->input("id"))->first();

            if (!$user) {
                return redirect()
                    ->route("panel.users.index")
                    ->with(
                        "message_error",
                        trans("general.not_found", [
                            "type" => trans_choice("general.users", 1),
                        ])
                    );
            }

            if ($user->meta == null) {
                $user->meta = [];
            }

            if ($request->input('verified') !== null) {
                if ($user->email_verified_at !== null) {
                    $request->merge([
                        "email_verified_at" => $user->email_verified_at,
                    ]);
                } else {
                    $request->merge([
                        "email_verified_at" => date("Y-m-d H:i:s"),
                    ]);
                }
            } else {
                $request->merge([
                    "email_verified_at" => null,
                ]);
            }

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->role = $request->input('role');

            if ($request->input('branch') != null) {
                $user->meta = array_merge($user->meta, [
                    'branch' => $request->input('branch')
                ]);
            }

            $user->email_verified_at = $request->input('email_verified_at');

            $user->save();
        } catch (QueryException $e) {
            return redirect()
                ->route("panel.users.edit", ["id" => $user->id])
                ->with(
                    "form_error",
                    trans("general.error")
                );
        }

        return redirect()
            ->route("panel.users.edit", ["id" => $user->id])
            ->with(
                "form_success",
                trans("general.successfully_updated", [
                    "type" => trans_choice("general.users", 1),
                ])
            );
    }

    /**
     * Delete resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');

        $user = User::where("id", "=", $id)->first();

        if (!$user) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 400);
        }

        $user->delete();

        return response()
            ->json([
                'success' => true,
                'message' => 'User successfully deleted'
            ], 200);
    }
}
