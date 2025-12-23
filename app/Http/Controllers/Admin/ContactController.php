<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Mail\ReplyMessage;
use Illuminate\Http\Request;
use App\Models\Admin\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;
use App\Mail\NewContactNotificationMail;
use App\Http\Requests\ReplyContactRequest;
use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        return view('admin.pages.contact.index', [
            'contacts' => $this->contactRepository->allContact(),
        ]);
    }

// public function store(ContactRequest $request)
// {
//     try {
//         $contact = Contact::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'phone' => $request->phone,
//             'message' => $request->message,
//             'code' => 'CONTACT-' . strtoupper(uniqid()),
//             'ip_address' => $request->ip(),
//             'status' => 'pending'
//         ]);

//         // No email to admin - just store the contact
//         \Log::info('New contact received', [
//             'contact_id' => $contact->id,
//             'name' => $contact->name,
//             'email' => $contact->email
//         ]);

//         return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');

//     } catch (\Exception $e) {
//         \Log::error('Failed to create contact: ' . $e->getMessage());
//         return redirect()->back()->with('error', 'Failed to send message. Please try again.')->withInput();
//     }
// }
public function store(ContactRequest $request)
{
    try {
        $contact = Contact::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'message'    => $request->message,
            'code'       => 'CONTACT-' . strtoupper(uniqid()),
            'ip_address' => $request->ip(),
            'status'     => 'pending',
        ]);

        \Log::info('New contact received', [
            'contact_id' => $contact->id,
            'name'       => $contact->name,
            'email'      => $contact->email,
        ]);

        return redirect()->back()->with([
            'swal' => [
                'icon'  => 'success',
                'title' => 'Message Sent!',
                'text'  => 'Thank you for your message! We will get back to you soon.'
            ]
        ]);

    } catch (\Exception $e) {

        \Log::error('Failed to create contact: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with([
                'swal' => [
                    'icon'  => 'error',
                    'title' => 'Failed!',
                    'text'  => 'Failed to send message. Please try again.'
                ]
            ]);
    }
}

    public function show($id)
    {
        $contact = $this->contactRepository->findContact($id);
        return view('admin.pages.contact.show', compact('contact'));
    }




public function update(ReplyContactRequest $request, $id)
{
    $replyMessage = $request->input('reply_message');
    $contact = $this->contactRepository->findContact($id);

    $data = [
        'reply_message' => $replyMessage,
        'status' => 'replied',
        'replied_at' => now(),
    ];

    // Update the contact
    $this->contactRepository->updateContact($data, $id);
    
    // Send reply email to the user who contacted
    try {
        Mail::to($contact->email)->send(new ReplyMessage($contact, $replyMessage));
        
        \Log::info('Reply email sent to user', [
            'contact_id' => $id, 
            'user_email' => $contact->email,
            'user_name' => $contact->name
        ]);
        
        return redirect()->route('admin.pages.contact.show', $id)->with('success', 'Reply has been sent successfully to ' . $contact->email . '!');
        
    } catch (\Exception $e) {
        \Log::error('Failed to send reply email: ' . $e->getMessage(), [
            'contact_id' => $id,
            'user_email' => $contact->email
        ]);
        
        return redirect()->route('admin.pages.contact.show', $id)->with('warning', 'Reply saved but email failed to send: ' . $e->getMessage());
    }
}

    public function destroy($id)
    {
        try {
            $this->contactRepository->destroyContact($id);
            // \Log::info('Contact deleted successfully', ['contact_id' => $id]);
            
            return redirect()->route('admin.pages.contact.index')->with('success', 'Contact deleted successfully!');
            
        } catch (\Exception $e) {
            // Log::error('Failed to delete contact: ' . $e->getMessage(), ['contact_id' => $id]);
            return redirect()->route('admin.pages.contact.index')->with('error', 'Failed to delete contact. Please try again.');
        }
    }



    public function bulkDelete(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        Contact::whereIn('id', $ids)->delete();
        return back()->with('success', 'Selected contacts deleted successfully.');
    }

    return back()->with('error', 'No contacts selected.');
}

public function deleteAll()
{
    Contact::truncate(); // deletes all records
    return back()->with('success', 'All contacts deleted successfully.');
}

}