<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AgencyEmployee;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Choose;
use App\Models\ContactUs;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Foundation;
use App\Models\InstitutionNurse;
use App\Models\NewsLetter;
use App\Models\OurCore;
use App\Models\Plan;
use App\Models\Price;
use App\Models\Service;
use App\Models\Skill;
use App\Models\User;
use App\Models\Works;
use App\Models\Subscribe;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    use ApiResponse;

    public function home()
    {
        $banner = Banner::get();
        $serviceHeading = Service::where('section', 'heading')->select('title', 'subtitle')->first();
        $service = Service::where('section', 'services')->get();

        $works = Works::get();
        $blogs = Blog::get();
        $faqHeader = Faq::where('section', 'heading')->select('title', 'subtitle', 'image')->first();
        $faqs = Faq::where('section', 'faq')->select('question', 'answer')->get();

        $chooses = Choose::get();
        $newsLetter = NewsLetter::first();

        $data = [
            'banner' => $banner,
            'serviceHeading' => $serviceHeading,
            'service' => $service,
            'works' => $works,
            'blogs' => $blogs,
            'faqHeader' => $faqHeader,
            'faqs' => $faqs,
            'chooses' => $chooses,
            'newsLetter' => $newsLetter,
        ];

        return $this->successResponse(
            $data,
            'Home page fetched successfully',
        );
    }

    public function services()
    {
        $serviceHeading = Service::where('section', 'heading')->select('title', 'subtitle')->first();
        $service = Service::where('section', 'services')->get();

        $data = [
            'serviceHeading' => $serviceHeading,
            'service' => $service,
        ];

        return $this->successResponse(
            $data,
            'Service page fetched successfully',
        );
    }

    public function abouts()
    {
        $about = About::with('items')->first();
        $ourCore = OurCore::get();
        $foundation = Foundation::first();
        $chooses = Choose::get();

        $data = [
            'about' => $about,
            'ourCore' => $ourCore,
            'foundation' => $foundation,
            'chooses' => $chooses,
        ];

        return $this->successResponse(
            $data,
            'About page fetched successfully',
        );
    }

    public function events()
    {
        $events = Event::with('items')->get();

        return $this->successResponse(
            $events,
            'Events page fetched successfully',
        );
    }

    public function contacts()
    {
        $contact = ContactUs::where('section', 'contact')->select('heading', 'sub_heading', 'map')->first();
        $card = ContactUs::where('section', 'card')->select('title', 'subtitle', 'icon')->get();

        $data = [
            'contact' => $contact,
            'card' => $card,
        ];

        return $this->successResponse(
            $data,
            'Contact page fetched successfully',
        );
    }

    public function blogs()
    {
        $blogs = Blog::get();

        return $this->successResponse(
            $blogs,
            'Blogs page fetched successfully',
        );
    }

    public function skillNurse()
    {
        $skills = Skill::select('id', 'name', 'type')->where('status', true)->get();

        return $this->successResponse(
            $skills,
            'Skills data fetched successfully',
        );
    }

    public function prices()
    {
        $prices = Price::where('status', 'active')->select('id', 'name', 'price')->get();

        return $this->successResponse(
            $prices,
            'Prices data fetched successfully',
        );
    }

    public function specialist(Request $request)
    {
        $specialist = User::with(['houseManager', 'nurse','physiotherapist','nurseAssistant','specialNeed','schedule'])->where('role', 'specialist')
            ->where('is_profile_verified', 1)
            ->inRandomOrder()
            ->get();

        $employeAgencies = AgencyEmployee::inRandomOrder()
            ->get()
            ->map(function ($item) {
                $item->setAttribute('subRole', 'house-manager');
                $item->setAttribute('role', 'specialist');
                return $item;
            });

        $institutionalNurses = InstitutionNurse::inRandomOrder()
            ->get()
            ->map(function ($item) {
                $item->setAttribute('subRole', 'nurse');
                $item->setAttribute('role', 'specialist');
                return $item;
            });

        $combined = $specialist
            ->concat($employeAgencies)
            ->concat($institutionalNurses)
            ->shuffle()
            ->values();

        return $this->successResponse($combined, 'Filtered results');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscribe = Subscribe::firstOrNew([
            'email' => $request->email,
        ]);

        $subscribe->fill([
            'status' => true,
        ]);

        $subscribe->save();

        return response()->json([
            'status' => true,
            'message' => 'Subscribed successfully',
        ], 200);
    }

    public function plans()
    {
        $plans = Plan::where('status', true)->select('id', 'name', 'price')->get();

        return $this->successResponse(
            $plans,
            'Plans data fetched successfully',
        );
    }
}
