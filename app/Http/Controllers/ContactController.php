<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function myContacts(Request $request)
    {
        $contacts_query = Contact::where('user_id', Auth::id());

        if($request->has('search')){
            $contacts_query = $contacts_query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
        if($request->has('sort_name')){
            $contacts_query = $contacts_query->orderBy('name', $request->sort_name);
        }
        elseif($request->has('sort_date')){
            $contacts_query = $contacts_query->orderBy('created_at', $request->sort_date);
        }

        $contacts = $contacts_query->paginate(10);

        return response()->json([
            'message' => 'success',
            'data' => $contacts
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
        ]);

        $model = Contact::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        if ($model) {
            return response()->json([
                'message' => 'success',
                'data' => $model
            ]);
        }

        return response()->json([
            'message' => 'error',
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
        ]);

        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Контакт не найден',
            ], 404);
        }

        $contact->fill($request->all());
        $contact->save();

        return response()->json([
            'message' => 'success',
            'data' => $contact,
        ]);
    }

    public function delete($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Контакт не найден',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }
}
