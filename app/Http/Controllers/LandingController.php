<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class LandingController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Static data for featured medicines (you can replace with database data later)
        $featuredMedicines = [
            [
                'name'  => 'પેરાસિટામોલ 500 મિગ્રા',
                'price' => '₹ 50',
                'desc'  => 'તાવ અને દુખાવા માટે સૌથી સામાન્ય દવા.',
                'image' => 'https://via.placeholder.com/150'
            ],
            [
                'name'  => 'એમોક્સિસિલિન 250 મિગ્રા',
                'price' => '₹ 120',
                'desc'  => 'બેક્ટેરિયલ ઇન્ફેક્શન માટે એન્ટીબાયોટિક.',
                'image' => 'https://via.placeholder.com/150'
            ],
            [
                'name'  => 'ઓમેપ્રાઝોલ 20 મિગ્રા',
                'price' => '₹ 80',
                'desc'  => 'એસિડિટી અને અલ્સર માટે અસરકારક.',
                'image' => 'https://via.placeholder.com/150'
            ],
            [
                'name'  => 'એઝિથ્રોમાસીન 500 મિગ્રા',
                'price' => '₹ 200',
                'desc'  => 'શ્વસન ચેપ માટે એન્ટીબાયોટિક.',
                'image' => 'https://via.placeholder.com/150'
            ]
        ];

        return view('home', compact('featuredMedicines'));
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|min:2',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('contact')
                         ->with('success', 'તમારો સંદેશ મોકલાઈ ગયો. અમે ટૂંક સમયમાં સંપર્ક કરીશું.');
    }
}