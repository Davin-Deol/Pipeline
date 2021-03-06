<?php

namespace App\Http\Controllers;

use Mail;
use Guid;
use Validator;
use Symfony\Component\HttpFoundation\Cookie as Cookie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as View;

use App\Connections as Connections;
use App\Currency as Currency;
use App\Interest as Interest;
use App\InvestmentType as InvestmentType;
use App\Jurisdiction as Jurisdiction;
use App\Listings as Listings;
use App\ListingToImages as ListingToImages;
use App\Users as Users;
use App\UsersSavedListings as UsersSavedListings;

use App\MyLibrary\StringFormatter as StringFormatter;
use App\MyLibrary\DirectoryManager as DirectoryManager;

class UserController extends Controller
{
    private $user;
    public function __construct(Request $request, Currency $currency, Interest $interest, InvestmentType $investmentType, Jurisdiction $jurisdiction, Listings $listings, ListingToImages $listingToImages, Users $users)
    {
        parent::__construct($request);
        
        $this->currency = $currency->all();
        $this->interest = $interest->all();
        $this->investmentType = $investmentType->all();
        $this->jurisdiction = $jurisdiction->all();
        $this->listings = $listings->all();
        $this->listingToImages = $listingToImages->all();
        $this->users = $users->all();
        
        //Auth::user() = Users::find($request->session()->get('userId'));  
        $this->user = Auth::user();      
        View::share('user', Auth::user());
    }
    
    public function browseListings(Request $request)
    {
        $data = array();
        $data["title"] = "Browse Listings";
        $data["searchKeyUsed"] = false;
        $searchKey = "";
        
        if ($request->isMethod('post'))
        {
            $searchKey = $request->input("searchKey");
            $data["searchKeyUsed"] = $searchKey;
        }
        
        $currencies = $this->currency->all();
        $interests = $this->interest->all();
        $investmentTypes = $this->investmentType->all();
        $jurisdictions = $this->jurisdiction->all();
        
        $listings = Listings::with('listingImages')
            ->where('status', "posted")
            ->where(function ($query) use ($searchKey) {
                    $query->where('name', 'LIKE', "%" . $searchKey . "%")
                        ->orWhere('introduction', 'LIKE', "%" . $searchKey . "%")
                        ->orWhere('additionalDetails', 'LIKE', "%" . $searchKey . "%");
                })
            ->orderBy('lastUpdated', 'DESC')
            ->get();
        
        return view('user/browseListings', compact('data', 'listings', 'currencies', 'interests', 'investmentTypes', 'jurisdictions'));
    }
    
    public function browseListings_listingLayout(Request $request)
    {
        $data = [];
        if ($request->isMethod('post'))
        {
            $searchKey = $request->cookie('searchKey');
            /*
            $data["category"] = $request->input('category');
            $data["subCategory"] = $request->input('subCategory');
            */
            $minPrice = ($request->input('minPrice') !== null) ? $request->input('minPrice') : 0;
            $maxPrice = ($request->input('maxPrice') !== null) ? $request->input('maxPrice') : 99999999999;
            $interests = ($request->input('interests') !== null) ? $request->input('interests') : array();
            $investmentTypes = ($request->input('investmentTypes') !== null) ? $request->input('investmentTypes') : array();
            $jurisdictions = ($request->input('jurisdictions') !== null) ? $request->input('jurisdictions'): array();
            $offset = ($request->input('offset') !== null) ? $request->input('offset') : 0;
            
            $listings = Listings::with('listingImages')
                ->where('status', "posted")
                ->where(function ($query) use ($searchKey) {
                        $query->where('name', 'LIKE', "%" . $searchKey . "%")
                            ->orWhere('introduction', 'LIKE', "%" . $searchKey . "%")
                            ->orWhere('additionalDetails', 'LIKE', "%" . $searchKey . "%");
                    })
                ->where('priceBracketMin', '>=', $minPrice)
                ->where('priceBracketMax', '<=', $maxPrice)
                ->whereIn('subCategory', $interests)
                ->whereIn('investmentType', $investmentTypes)
                ->whereIn('jurisdiction', $jurisdictions)
                ->orderBy('lastUpdated', 'DESC')
                ->offset($offset)
                ->limit(10)
                ->get();
        }
        
        return response()
            ->json([
                'count' => count($listings),
                'data' => view('user/browseListings_listingLayout', compact('data', 'listings'))->render()
            ]);
        return view('user/browseListings_listingLayout', compact('data', 'listings'));
    }
    
    public function saveUsersListing(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $savedListingId = $request->input("savedListingId");
            
            $listing = Listings::find($savedListingId);
            
            if (($listing->status == "posted") && ($listing->userId != Auth::user()->userId))
            {
                $savedListing = new UsersSavedListings();
                $savedListing->userId = Auth::user()->userId;
                $savedListing->savedListingId = $savedListingId;
                $savedListing->save();
                return "Saved \"" . $listing->name . "\".";
            }
        }
    }
    
    public function savedListings()
    {
        $data = array();
        $data["title"] = "Saved Listings";
        
        $savedListings = UsersSavedListings::with('listing', 'listing.listingImages')
            ->where('UsersSavedListings.userId', Auth::user()->userId)
            ->get();
        
        return view('user/savedListings', compact('data', 'savedListings'));
    }
    
    public function removeSavedListing(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $savedListingId = $request->input("savedListingId");
            
            $listing = Listings::find($savedListingId);
            
            UsersSavedListings::where('userId', Auth::user()->userId)
                ->where('savedListingId', $request->input("savedListingId"))
                ->delete();

                return "Removed \"" . $listing->name . "\" from your saved listings.";
        }
    }
    
    public function myListings()
    {
        $data = array();
        $data["title"] = "My Listings";
        $data["prevStatus"] = "";
        $data["firstStatus"] = true;
        $listings = Listings::with('listingImages')
            ->where('userId', Auth::user()->userId)
            ->orderBy('status')
            ->get();
                
        return view('user/myListings', compact('data', 'listings'));
    }
    
    public function profile($userId = null)
    {
        $data = array();
        $data['title'] = "Profile";
        $this->user = Auth::user();
        $user = Auth::user();
        
        $viewable = false;

        if ($userId)
        {
            $profileUser = Users::find($userId);

            if (!($profileUser))
            {
                abort(404);
            }

            if ((Auth::user()->type == "admin") || (Auth::user()->type == "demo-admin"))
            {
                $viewable = true;
            }
            else
            {
                $connections = Connections::where(
                    function ($query) {
                        $query->where('interestedPartyId', Auth::user()->userId)
                            ->orWhere('creatorId', Auth::user()->userId);
                    })->where('status', 'approved')
                    ->get();
                if ($connections->count())
                {
                    $viewable = true;
                }
            }

            if ($viewable == false)
            {
                abort(404);
            }

            $statistics = array(
                'Listings' => Listings::getUsersListingsStatistics($userId),
                'Connections' => Connections::getUsersConnectionsStatistics($userId),
            );

        }
        else
        {

            $profileUser = Auth::user();
            $statistics = array(
                'Listings' => Listings::getUsersListingsStatistics(Auth::user()->userId),
                'Connections' => Connections::getUsersConnectionsStatistics(Auth::user()->userId),
            );
        }
        // Flag
        return view('user/profile', compact('user', 'data', 'statistics', 'profileUser'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('guest-home');
    }
    
    public function settings(Request $request)
    {
        $data = array();
        if ($request->isMethod('post'))
        {
            switch ($request->input('category'))
            {
                case ("changePassword"):
                    return view('user/settings_Categories/changePassword', compact('data', 'birthday'));
                    break;
                case ("nda"):
                    $seconds = filemtime("public/img/NDAs/" . Auth::user()->NDA);
                    $data["NDALastModified"] = StringFormatter::getDifferenceBetweenDateTimeAndNow($seconds);
                    return view('user/settings_Categories/nda', compact('data', 'birthday'));
                    break;
                case ("profile"):
                    $birthday = new \DateTime(Auth::user()->birthday);
                    $birthday = $birthday->format('Y-m-d');
                    return view('user/settings_Categories/profile', compact('data', 'birthday'));
                    break;
                default:
                    break;
            }
        }
        else
        {        
            $data["title"] = "Settings";

            return view('user/settings', compact('data'));
        }
    }
    
    public function submitNDA(Request $request)
    {
        $result = "";
        $responseData = "";
        
        if (($request->isMethod('post')) && (Auth::user()->NDAStatus != "approved"))
        {
            $validator = Validator::make($request->all(),
                [
                    'NDA' => 'bail|required|file|image|max:5000|mimes:jpg,png,jpeg,gif',
                ]
            );
            if (!$validator->fails())
            {
                if (($request->hasFile('NDA')) && ($request->NDA->isValid()))
                {
                    $user = Auth::user();
                    $imageFileType = $request->NDA->extension();
                    $firstSubmission = is_null($user->NDA);

                    $user->NDA = $user->userId . "." . $imageFileType;
                    $user->NDAStatus = "submitted";
                    $user->save();
                    $NDAPath = "public/img/NDAs/" . $user->NDA;

                    $currentNDAsFromUser = glob ("public/img/NDAs/" . $user->userId . ".*");
                    if (count($currentNDAsFromUser))
                    {
                        foreach ($currentNDAsFromUser as $file)
                        {
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }
                    move_uploaded_file($request->NDA, $NDAPath);

                    if ($firstSubmission)
                    {
                        if (config('app.debug'))
                        {
                            Mail::send('emails.sendNDAPendingApproval', ['user' => $user], function ($m) use ($user)
                            {
                                $m->to('davindeol@gmail.com', 'Davin Deol')->subject($user["fullName"] . ' Has Submitted A NDA');
                            });
                        }
                        else
                        {
                            $adminEmails = Users::getEmailsByType('admin'); 
                            Mail::send('emails.sendNDAPendingApproval', ['user' => $user], function ($m) use ($user, $adminEmails)
                            {
                                $m->to($adminEmails)->subject($user["fullName"] . ' Has Submitted A NDA');
                            });
                        }
                    }

                    $result = "success";
                    $seconds = filemtime("public/img/NDAs/" . Auth::user()->NDA);
                    $responseData = StringFormatter::getDifferenceBetweenDateTimeAndNow($seconds);
                }
                else
                {
                    $result = "fail";
                    $responseData = "Failed to upload file";
                }
            }
            else
            {
                $result = "fail";
                $responseData = $validator->errors()->messages();
            }
        }
        
        return response()
            ->json([
                'result' => $result,
                'data' => $responseData
            ]);
    }
    
    public function submitChangePassword(Request $request)
    {
        $result = "";
        $responseData = "";
        if ($request->isMethod('post')) 
        {
            $data = array();
        
            $data["cur_pass"] = $request->input('current_password');
            $data["new_pass"] = $request->input('new_password');
            $data["confirm_pass"] = $request->input('confirm_password');
            $validator = Validator::make($request->all(),
                [
                    'current_password' => 'required',
                    'new_password' => 'required|min:8|same:confirm_password',
                    'confirm_password' => 'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'min' => 'Your :attribute must be at least :min characters long.',
                    'same' => 'The :attribute field and :other field must match'
                ]
            );
            if (!$validator->fails())
            {
                if (password_verify($data["cur_pass"], Auth::user()->password))
                {
                    $hashedPassword = password_hash($data["new_pass"], PASSWORD_DEFAULT, ['cost' => 9]);
                    Auth::user()->password = $hashedPassword;
                    Auth::user()->save();
                    $result = "success";
                }
                else
                {
                    $result = "fail";
                    $responseData = ['current_password' => ["Incorrect password was provided"]];
                }
            }
            else
            {
                $result = "fail";
                $responseData = $validator->errors()->messages();
            }
        }
        return response()
            ->json([
                'result' => $result,
                'data' => $responseData
            ]);
    }
    
    public function submitUpdateAccount(Request $request)
    {
        $result = "";
        $responseData = "";
        if ($request->isMethod('post')) 
        {
            $data = array();
        
            $data["profile_image"] = $request->input('profile_image');
            $data["phone"] = $request->input('phone');
            $data["birthday"] = $request->input('birthday');
            $data["location"] = $request->input('location');
            $data["bio"] = $request->input('bio');
            $data["linkedInURL"] = $request->input('linkedInURL');
            
            print($request->input('profile_image'));
            
            if($request->input('profile_image'))
            {
                $validator = Validator::make($request->all(),
                    [
                        'profile_image' => 'sometimes|bail|file|image|max:5000|mimes:jpg,png,jpeg,gif',
                        'phone' => 'max:15',
                        'birthday' => 'date|max:15',
                        'location' => 'max:127',
                        'bio' => 'max:2047',
                        'linkedInURL' => 'url|active_url|max:127',
                    ]
                );
            }
            else
            {
                $validator = Validator::make($request->all(),
                    [
                        'phone' => 'max:15',
                        'birthday' => 'date|max:15',
                        'location' => 'max:127',
                        'bio' => 'max:2047',
                        'linkedInURL' => 'url|active_url|max:127',
                    ]
                );
            }
            if (!$validator->fails())
            {
                $user = Auth::user();
                if (($request->hasFile('profile_image')) && ($request->profile_image->isValid()))
                {
                    $imageFileType = $request->profile_image->extension();
                    $user->profileImage = $user->userId . "." . $imageFileType;
                    $profileImagePath = "public/img/Profile-Images/" . $user->profileImage;
                    $currentProfileImagesForUser = glob("public/img/Profile-Images/" . $user->userId . ".*");
                    
                    if (count($currentProfileImagesForUser))
                    {
                        foreach ($currentProfileImagesForUser as $profileImage)
                        {
                            if (file_exists($profileImage)) {
                                unlink($profileImage);
                            }
                        }
                    }
                    move_uploaded_file($request->profile_image, $profileImagePath);
                }
                
                $user->phoneNumber = $data["phone"];
                $user->birthday = $data["birthday"];
                $user->location = $data["location"];
                $user->bio = $data["bio"];
                $user->linkedInURL = $data["linkedInURL"];
                $user->save();
                $result = "success";
            }
            else
            {
                $result = "fail";
                $responseData = $validator->errors()->messages();
            }
        }
        return response()
            ->json([
                'result' => $result,
                'data' => $responseData
            ]);
    }
    
    public function listingForm($listingID = null, Request $request)
    {
        $data = array();
        $data["title"] = "Listing Form";
        $currencies = $this->currency->all();
        $interests = $this->interest->all();
        $investmentTypes = $this->investmentType->all();
        $jurisdictions = $this->jurisdiction->all();
        
        if ($listingID)
        {
            $listing = Listings::find($listingID);
            if (is_null($listing))
            {
                abort(404);
            }
            else if ((Auth::user()->type != "admin") && (Auth::user()->userId != $listing->userId))
            {
                return back();
            }
            
            if ((Auth::user()->type != "admin") || ((Auth::user()->type == "admin") && (Auth::user()->userId == $listing->userId)))
            {
                $listing->status = "draft";
                $listing->save();
            }
            
            $listingImages = ListingToImages::findByListingID($listingID);
        }
        else
        {
            $listing = new Listings();
            $listing->listingID = "";
            $listing->category = "";
            $listing->subCategory = "";
            $listing->name = "";
            $listing->introduction = "";
            $listing->jurisdiction = "";
            $listing->investmentType = "";
            $listing->typeOfCurrency = "";
            $listing->priceBracketMin = "";
            $listing->priceBracketMax = "";
            $listing->additionalDetails = "";
            $listingImages = array();
        }
        
        $lastInputsUsed = $request->cookie('listingForm_LastInputsUsed');
        if ($lastInputsUsed !== null)
        {
            $lastInputsUsed = json_decode($lastInputsUsed);
        }
        
        return view('user/listingForm', compact('data', 'listing', 'listingImages', 'currencies', 'interests', 'investmentTypes', 'jurisdictions', 'lastInputsUsed'));
    }
    
    public function saveListing($forReview = false, Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $result = "";
            $responseData = "";
        
            $data["name"] = $request->input('name');
            $data["intro"] = ($request->input('intro') !== null) ? $request->input('intro') : '';
            $data["category"] = $request->input('category');
            $data["subCategory"] = $request->input('subCategory');
            $data["jurisdiction"] = $request->input('jurisdiction');
            $data["investmentType"] = $request->input('investmentType');
            $data["typeOfCurrency"] = $request->input('typeOfCurrency');
            $data["minPrice"] = ($request->input('minPrice') !== null) ? $request->input('minPrice') : 0;
            $data["maxPrice"] = ($request->input('maxPrice') !== null) ? $request->input('maxPrice') : 0;
            $data["details"] = ($request->input('details') !== null) ? $request->input('details') : '';
            
            $validator = Validator::make($request->all(),
                [
                    'name' => 'required|max:127',
                    'intro' => 'required|max:511',
                    'category' => 'required|max:63',
                    'subCategory' => 'required|max:31',
                    'jurisdiction' => 'required|max:85',
                    'investmentType' => 'required|max:31',
                    'typeOfCurrency' => 'required|max:10',
                    'minPrice' => 'required|numeric|min:0|max:99999999999',
                    'maxPrice' => 'required|numeric|gte:minPrice|min:0|max:99999999999',
                    'details' => 'max:4095',
                ]
            );
            
            if (!$validator->fails())
            {
                if ($request->input('listingID'))
                {
                    $data["listingID"] = $request->input('listingID');
                    $listing = Listings::find($data["listingID"]);
                    if (Auth::user()->type != "admin")
                    {
                        $listing->status = "draft";
                    }
                }
                else
                {
                    $listing = new Listings();
                    $listing->listingID = Guid::create();
                    $listing->userId = Auth::user()->userId;
                    $listing->status = "draft";
                    mkdir("public/img/Listing-Images/" . $listing->userId . "/" . $listing->listingID);
                }

                $listing->name = $data["name"];
                $listing->category = $data["category"];
                $listing->subCategory = $data["subCategory"];
                $listing->introduction = $data["intro"];
                $listing->jurisdiction = $data["jurisdiction"];
                $listing->investmentType = $data["investmentType"];
                $listing->typeOfCurrency = htmlentities($data["typeOfCurrency"]);
                $listing->priceBracketMin = $data["minPrice"];
                $listing->priceBracketMax = $data["maxPrice"];
                $listing->additionalDetails = $data["details"];
                $listing->save();

                $numberOfImagesForListing = ListingToImages::getNumberOfImagesForListing($listing->listingID);
                $remainingNumberOfImagesAllowed = 9 - ((int) $numberOfImagesForListing->get('numberOfImages'));
                $numberOfImagesAdded = 0;

                $files = $request->files->all();
                if (count($files))
                {
                    foreach ($files["files"] as $file)
                    {
                        if ($numberOfImagesAdded < $remainingNumberOfImagesAllowed)
                        {
                            if ($file->isValid())
                            {
                                $listingToImages = new ListingToImages();
                                $listingToImages->listingID = $listing->listingID;
                                $listingToImages->image = Guid::create() . "." . $file->guessExtension();

                                $listingImagePath = "public/img/Listing-Images/" . $listing->userId . "/" . $listing->listingID . "/" . $listingToImages->image;

                                if (!is_dir("public/img/Listing-Images/" . $listing->userId . "/" . $listing->listingID . "/")) {
                                    mkdir("public/img/Listing-Images/" . $listing->userId . "/" . $listing->listingID . "/", 0777, true);
                                }

                                move_uploaded_file($file, $listingImagePath);
                                $numberOfImagesAdded++;
                                $listingToImages->save();
                            }
                        }
                    }
                }
                $result = "success";
                $responseData = $listing->listingID;
            }
            else
            {
                $result = "fail";
                $responseData = $validator->errors()->messages();
            }
            
            return response()
                ->json([
                    'result' => $result,
                    'data' => $responseData
                ])->withCookie(cookie()->forever('listingForm_LastInputsUsed', json_encode([
                    'category' => $data["category"],
                    'subCategory' => $data["subCategory"],
                    'jurisdiction' => $data["jurisdiction"],
                    'investmentType' => $data["investmentType"],
                    'typeOfCurrency' => $data["typeOfCurrency"]
                ])));
        }
        
        return response()
                ->json([
                    'result' => 'fail',
                    'data' => "Failed to save listing. Please try again later."
                ]);
    }
    
    public function deleteListing(Request $request)
    {
        $sessionData = "";
        if ($request->isMethod('post')) 
        {
            $data = array();

            $listingID = $request->input('listingID');

            $listing = Listings::find($listingID);
            
            if (is_null($listing))
            {
                return redirect()->route('user-myListings');
            }
            
            if (($listing->userId == Auth::user()->userId) || (Auth::user()->type == "admin"))
            {
                DirectoryManager::deleteDir("public/img/Listing-Images/" . $listing->userId . "/" . $listing->listingID);
                ListingToImages::where('listingID', $listingID)->delete();
                Listings::find($listingID)->delete();
                
                if ($listing->userId == Auth::user()->userId)
                {
                    if ($request->input('dontSetSessionVariable') === null)
                    {
                        $sessionData = 'Successfuly deleted listing.';
                    }
                }
                else
                {
                    $creator = Users::find($listing->userId);
                    $adminEmails = Users::getEmailsByType('admin');
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.listingDeleted', ['creator' => $creator, 'listing' => $listing], function ($m) use ($adminEmails, $listing)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("The Listing \"" . $listing->name . "\" Was Deleted");
                        });
                    }
                    else
                    {
                        Mail::send('emails.listingDeleted', ['creator' => $creator, 'listing' => $listing], function ($m) use ($adminEmails, $listing)
                        {
                            $m->to($adminEmails)->subject("The Listing \"" . $listing->name . "\" Was Deleted");
                        });
                    }
                    
                    $sessionData = 'Successfuly deleted listing and the creator was notified.';
                }
                $request->session()->put('success', $sessionData);
                return redirect()->route('user-myListings');
            }
        }
    }
    
    public function deleteListingImage(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
        
            $data["image"] = $request->input('image');
            $data["listingID"] = $request->input('listingID');
            
            $listing = Listings::find($data["listingID"]);
            $listingUserId = $listing->userId;
            
            if ((Auth::user()->userId == $listingUserId) || (Auth::user()->type == "admin"))
            {
                $imagePath = "public/img/Listing-Images/" . $listingUserId . "/" . $data['listingID'] . "/" . $data['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    ListingToImages::where('listingID', $data["listingID"])->where('image', $data["image"])->delete();
                }
            }
        }
    }
    
    public function reviewListing($listingID)
    {
        $listing = Listings::find($listingID);
        
        if (is_null($listing))
        {
            abort(404);
        }
        
        if (($listing->status != "posted") && ((Auth::user()->type != "admin") && (Auth::user()->type != "demo-admin")) && (Auth::user()->userId != $listing->userId))
        {
            return back();
        }
        
        $listingImages = ListingToImages::findByListingID($listingID);
        
        $data = array();
        $data["title"] = "Review Listing";
        $data["userHasSavedThisListing"] = UsersSavedListings::where('userId', Auth::user()->userId)
            ->where('savedListingId', $listing->listingID)
            ->count();
        
        $data["userHasSentAConnectionRequest"] = Connections::where('interestedPartyId', Auth::user()->userId)
            ->where('creatorId', $listing->userId)
            ->where('listingId', $listing->listingID)
            ->count();
        
        return view('user/reviewListing', compact('data', 'listing', 'listingImages'));
    }
    
    public function postListing(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["listingID"] = $request->input('listingID');
            $validator = Validator::make($request->all(),
                [
                    'listingID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $listing = Listings::find($data["listingID"]);
                $listing->status = "posted";
                $listing->save();
                
                if ($listing->userId != Auth::user()->userId)
                {
                    $user = Users::find($listing->userId);
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.listingApproved', ['listing' => $listing], function ($m) use ($user, $listing)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Your Listing \"" . $listing->name . "\" Was Approved");
                        });
                    }
                    else
                    {
                        Mail::send('emails.listingApproved', ['listing' => $listing], function ($m) use ($user, $listing)
                        {
                            $m->to($user->email, $user->fullName)->subject("Your Listing \"" . $listing->name . "\" Was Approved");
                        });
                    }
                    
                    $request->session()->put('success', 'Successfuly posted listing and the creator was notified.');
                    return route('admin-listingsPendingReview');
                }
                else
                {
                    $request->session()->put('success', 'Successfuly posted listing.');
                    return route('user-myListings');
                }
            }
        }
    }
    
    public function submitListingForApproval(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["listingID"] = $request->input('listingID');
            $validator = Validator::make($request->all(),
                [
                    'listingID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $listing = Listings::find($data["listingID"]);
                $listing->status = "submitted";
                $listing->save();
                
                $user = Auth::user();
                
                if (config('app.debug'))
                {
                    Mail::send('emails.listingPendingApproval', ['user' => $user], function ($m) use ($user)
                    {
                        $m->to('davindeol@gmail.com', 'Davin Deol')->subject($user["fullName"] . ' Has Submitted A Listing');
                    });
                }
                else
                {
                    $adminEmails = Users::getEmailsByType('admin');
                    Mail::send('emails.listingPendingApproval', ['user' => $user], function ($m) use ($user, $adminEmails)
                    {
                        $m->to($adminEmails)->subject($user["fullName"] . ' Has Submitted A Listing');
                    });
                }
                
                $request->session()->put('success', 'Successfuly submitted listing. You will be notified of the result via email.');
            }
        }
        return redirect()->route('user-myListings');
    }
    
    public function requestConnection(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["listingID"] = $request->input('listingID');
            
            $listing = Listings::find($data["listingID"]);
            
            if ($listing->userId != Auth::user()->userId)
            {
                $connection  = Connections::with('listing')
                    ->where('interestedPartyId', Auth::user()->userId)
                    ->where('creatorId', $listing->userId)
                    ->where('listingId', $listing->listingID)
                    ->first();
                
                if ((is_null($connection)) && ($listing->status == "posted"))
                {
                    $connection = new Connections();
                    $connection->interestedPartyId = Auth::user()->userId;
                    $connection->creatorId = $listing->userId;
                    $connection->listingId = $listing->listingID;
                    $connection->status = "pending creator approval";
                    $connection->save();
                    
                    return "Sent connection request to the creator of \"" . $listing->name . "\". You will be notified of the result via email.";
                }
            }
        }
    }
    
    public function cancelConnectionRequest(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["listingID"] = $request->input('listingID');
            
            $listing = Listings::find($data["listingID"]);
            
            if ($listing->userId != Auth::user()->userId)
            {
                $connection  = Connections::where('interestedPartyId', Auth::user()->userId)
                    ->where('creatorId', $listing->userId)
                    ->where('listingId', $listing->listingID)
                    ->first();
                                
                if (!is_null($connection))
                {
                    if ($connection->status = "pending creator approval")
                    {
                        $connection  = Connections::where('interestedPartyId', Auth::user()->userId)
                            ->where('creatorId', $listing->userId)
                            ->where('listingId', $listing->listingID)
                            ->delete();
                        
                        return "Cancelled connection request";
                    }
                }
            }
        }
    }
    
    public function connections()
    {
        $data = array();
        $data["title"] = "Connections";
        $data["prevStatus"] = "";
        $data["firstStatus"] = true;
        
        $connections = Connections::with('listing', 'listing.listingImages')
            ->where('interestedPartyId', Auth::user()->userId)
            ->orWhere('creatorId', Auth::user()->userId)
            ->orderByRaw("FIELD(status, 'pending creator approval', 'NDA(s) needs to be signed', 'pending admin approval', 'established connection') ASC")
            ->get();
        
        return view('user/connections', compact('data', 'connections'));
    }
    
    public function deleteConnection(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["creatorId"] = $request->input('creatorId');
            $data["interestedPartyId"] = $request->input('interestedParty');
            $data["listingId"] = $request->input('listingId');
            $validator = Validator::make($request->all(),
                [
                    'creatorId' => 'required',
                    'interestedParty' => 'required',
                    'listingId' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                Connections::where('creatorId', $data["creatorId"])
                    ->where('interestedPartyId', $data["interestedPartyId"])
                    ->where('listingId', $data["listingId"])
                    ->delete();
                
                $listing = Listings::find($data["listingId"]);
                $creator = Users::find($data["creatorId"]);
                $interestedParty = Users::find($data["interestedPartyId"]);
                
                if (Auth::user()->userId == $creator->userId)
                {
                    $otherParty = $interestedParty;
                }
                else
                {
                    $otherParty = $creator;
                }
                
                $user = Auth::user();
                if (config('app.debug'))
                {
                    Mail::send('emails.connectionDeleted', ['listing' => $listing, 'user' => $user], function ($m) use ($listing)
                    {
                        $m->to('davindeol@gmail.com', 'Davin Deol')->subject('Your Connection With ' . $listing->name . ' Was Closed');
                    });
                }
                else
                {
                    Mail::send('emails.connectionDeleted', ['listing' => $listing, 'user' => $user], function ($m) use ($listing)
                    {
                        $m->to($otherParty->email, $otherParty->fullName)->subject('Your Connection With ' . $listing->name . ' Was Closed');
                    });
                }
                            
                return "Connection was closed and the other party was notified.";
            }
        }
    }
    
    public function denyConnection(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["creatorId"] = $request->input('creatorId');
            $data["interestedParty"] = $request->input('interestedParty');
            $data["listingId"] = $request->input('listingId');
            $validator = Validator::make($request->all(),
                [
                    'creatorId' => 'required',
                    'interestedParty' => 'required',
                    'listingId' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                Connections::where('creatorId', $data["creatorId"])
                    ->where('interestedParty', $data["interestedParty"])
                    ->where('listingId', $data["listingId"])
                    ->delete();
                
                $interestedPartyUser = Users::find($data["interestedParty"]);
                $listing = Listings::find($data["listingId"]);  
                
                if (config('app.debug'))
                {
                    Mail::send('emails.connectionRequestDenied', ['listing' => $listing], function ($m) use ($listing)
                    {
                        $m->to('davindeol@gmail.com', 'Davin Deol')->subject('Your Connection Request Was Denied');
                    });
                }
                else
                {
                    Mail::send('emails.connectionRequestDenied', ['listing' => $listing], function ($m) use ($listing, $interestedPartyUser)
                    {
                        $m->to($interestedPartyUser->email, $listing->creator->fullName)->subject('Your Connection Request Was Denied');
                    });
                }
                
                return "Connection was closed and the other party was notified.";
            }
        }
    }
    
    public function approveConnection(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["creatorId"] = $request->input('creatorId');
            $data["interestedParty"] = $request->input('interestedParty');
            $data["listingId"] = $request->input('listingId');
            $validator = Validator::make($request->all(),
                [
                    'creatorId' => 'required',
                    'interestedParty' => 'required',
                    'listingId' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $creator = Users::find($data["creatorId"]);
                $interestedParty = Users::find($data["interestedParty"]);
                $listing = Listings::find($data["listingId"]);
                $connection = Connections::where('creatorId', $data["creatorId"])
                    ->where('interestedPartyId', $data["interestedParty"])
                    ->where('listingId', $data["listingId"])
                    ->first();
                
                if ((($creator->NDAStatus == "approved") && ($interestedParty->NDAStatus == "approved")) && (($creator->type == "admin") || ($interestedParty->type == "admin")))
                {
                    $connection = Connections::where('creatorId', $data["creatorId"])
                        ->where('interestedPartyId', $data["interestedParty"])
                        ->where('listingId', $data["listingId"])
                        ->update(['status' => "established connection"]);
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.connectionEstablished', ['otherParty' => $creator], function ($m) use ($creator)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Established Connection With " . $creator->fullName);
                        });
                        Mail::send('emails.connectionEstablished', ['otherParty' => $interestedParty], function ($m) use ($interestedParty)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Established Connection With " . $interestedParty->fullName);
                        });
                    }
                    else
                    {
                        Mail::send('emails.connectionEstablished', ['otherParty' => $creator], function ($m) use ($creator)
                        {
                            $m->to($creator->email, $creator->fullName)->subject("Established Connection With " . $creator->fullName . "!");
                        });
                        Mail::send('emails.connectionEstablished', ['otherParty' => $interestedParty], function ($m) use ($interestedParty)
                        {
                            $m->to($interestedParty->email, $interestedParty->fullName)->subject("Established Connection With " . $interestedParty->fullName . "!");
                        });
                    }
                    
                    return "Congratulations! You have established a connection! You can now go see how to contact with the other party on your <a href=\"{{ route('user-profile') }}\">profile page</a>.";
                }
                else if (($creator->NDAStatus == "approved") && ($interestedParty->NDAStatus == "approved"))
                {
                    $connection = Connections::where('creatorId', $data["creatorId"])
                        ->where('interestedPartyId', $data["interestedParty"])
                        ->where('listingId', $data["listingId"])
                        ->update(['status' => "pending admin approval"]);

                    
                    $adminEmails = Users::getEmailsByType('admin');
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.connectionPendingApproval', ['creator' => $creator, 'interestedParty' => $interestedParty], function ($m) use ($creator, $interestedParty)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject($creator->fullName . ' and ' . $interestedParty->fullName . " wish to establish a connection");
                        });
                    }
                    else
                    {
                        Mail::send('emails.connectionPendingApproval', ['creator' => $creator, 'interestedParty' => $interestedParty], function ($m) use ($creator, $interestedParty, $adminEmails)
                        {
                            $m->to($adminEmails)->subject($creator->fullName . ' and ' . $interestedParty->fullName . " wish to establish a connection");
                        });
                    }
                    
                    return "Now that both parties have shown interest in this connection, all that's left is for the admin to approve it. You will be notified of the result via email.";
                }
                else
                {
                    /*
                    $connection = Connections::where('creatorId', $data["creatorId"])
                        ->where('interestedPartyId', $data["interestedParty"])
                        ->where('listingId', $data["listingId"])
                        ->update(['status' => "NDA(s) needs to be signed"]);*/
                    
                    if (($creator->NDAStatus != "approved") && ($interestedParty->NDAStatus != "approved"))
                    {
                        $request->session()->put('success', 'Before this connection can be sent to admin for approval, both parties have to upload their signed NDA. Once the NDAs have been approved, this connection will automatically be sent to admin.');
                        
                        $whoNeedsToSign = "both parties need to upload their signed NDA";
                    }
                    else if ($interestedParty->NDAStatus != "approved")
                    {
                        $request->session()->put('success', 'Before this connection can be sent to admin for approval, the party that sent the request will have to upload their signed NDA. Once the NDA has been approved, this connection will automatically be sent to admin.');
                        
                        $whoNeedsToSign = "you need to upload your signed NDA";
                    }
                    else
                    {
                        $request->session()->put('success', 'Before this connection can be sent to admin for approval, you the creator have to upload your signed NDA. Once your NDA has been approved, this connection will automatically be sent to admin.');
                        
                        $whoNeedsToSign = "the creator of the listing needs to upload their signed NDA";
                    }
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.connectionNDARequired', ['whoNeedsToSign' => $whoNeedsToSign, 'listing' => $listing], function ($m) use ($interestedParty, $listing)
                        {
                            $m->to("davindeol@gmail.com", "Davin Deol")->subject("The creator of \"" . $listing->name . "\" Approved Your Connection Request");
                        });
                    }
                    else
                    {
                        Mail::send('emails.connectionNDARequired', ['whoNeedsToSign' => $whoNeedsToSign, 'listing' => $listing], function ($m) use ($interestedParty, $listing)
                        {
                            $m->to($interestedParty->email, $interestedParty->fullName)->subject("The creator of \"" . $listing->name . "\" Approved Your Connection Request");
                        });
                    }
                    
                    return "Before this connection can be sent to admin for approval, one or both parties have to upload their signed NDA. Once the NDAs have been approved, this connection will automatically be sent to admin.";
                }
            }
        }
    }
}
