<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('accounts.index', compact('users'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8'],
            'role' => ['nullable','string','max:100'],
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('accounts.index')->with('status','Account aangemaakt');
    }

    public function edit(User $account)
    {
        return view('accounts.edit', ['user' => $account]);
    }

    public function update(Request $request, User $account)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$account->id],
            'password' => ['nullable','string','min:8'],
            'role' => ['nullable','string','max:100'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $account->update($data);

        return redirect()->route('accounts.index')->with('status','Account bijgewerkt');
    }

    public function destroy(User $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('status','Account verwijderd');
    }
}