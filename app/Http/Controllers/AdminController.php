<?php

namespace App\Http\Controllers;

use Mail;
use Guid;
use Validator;

use Illuminate\Http\Request;
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
use App\Requests as Requests;
use App\RequestToInterests as RequestToInterests;
use App\SignUpLinks as SignUpLinks;

use App\MyLibrary\StringFormatter as StringFormatter;
use App\MyLibrary\DirectoryManager as DirectoryManager;

class AdminController extends UserController
{
    public function __construct(Currency $currency, Interest $interest, InvestmentType $investmentType, Jurisdiction $jurisdiction, Listings $listings, ListingToImages $listingToImages, Users $users, Request $request, Requests $requests, SignUpLinks $signUpLinks)
    {
        parent::__construct($currency, $interest, $investmentType, $jurisdiction, $listings, $listingToImages, $users, $request, $signUpLinks);
    }
    
    public function listingsPendingReview()
    {
        $data = array();
        $data["title"] = "Listings Pending Review";
        
        $listings = Listings::with('listingImages')
            ->where('status', "submitted")
            ->get();
        
        return view('admin/listingsPendingReview', compact('data', 'listings'));
    }
    
    public function denyListing(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["listingID"] = $request->input("listingID");
            $data["message"] = $request->input("message");
            
            $listing = Listings::with('creator')
                ->find($data["listingID"]);
            
            if (!is_null($listing))
            {
                if ($listing->status == "submitted")
                {
                    $listing->status = "posted";
                    $listing->save();
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.listingDenied', ['listing' => $listing, 'data' => $data], function ($m) use ($listing)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Your Listing \"" . $listing->name . "\" Was Approved");
                        });
                    }
                    else
                    {
                        Mail::send('emails.listingDenied', ['listing' => $listing, 'data' => $data], function ($m) use ($listing)
                        {
                            $m->to($listing->creator->email, $listing->creator->fullName)->subject("Your Listing \"" . $listing->name . "\" Was Approved");
                        });
                    }
                    
                    $request->session()->put('success', 'Successfuly posted listing and the creator was notified.');
                    return route('admin-listingsPendingReview');
                }
            }
        }
    }
    
    public function requests()
    {
        $data = array();
        $data["title"] = "Requests Pending Review";
        
        $requests = Requests::with('interests')
            ->whereNull('inviteSent')
            ->orderBy('readStatus', 'asc')
            ->orderBy('whenSent', 'desc')
            ->get();
        
        foreach ($requests as $request)
        {
            $request->whenSent = StringFormatter::getDifferenceBetweenDateTimeAndNow(strtotime($request->whenSent));
        }
        
        return view('admin/requests', compact('data', 'requests'));
    }
    
    public function approveRequest(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["requestID"] = $request->input('requestID');
            $validator = Validator::make($request->all(),
                [
                    'requestID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $request = Requests::find($data["requestID"]);
                
                if (!is_null($request))
                {
                    $signUpLink = new SignUpLinks();
                    $signUpLink->link = Guid::create();
                    $signUpLink->expirationDate = date("Y-m-d H:i:s", strtotime("+7 day"));
                    $signUpLink->requestID = $request->requestID;
                    $signUpLink->save();

                    if (config('app.debug'))
                    {
                        Mail::send('emails.requestApproved', ['request' => $request, 'signUpLink' => $signUpLink], function ($m) use ($request)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Your Request To Join Pipeline Was Approved!");
                        });
                    }
                    else
                    {
                        Mail::send('emails.requestApproved', ['request' => $request], function ($m) use ($request)
                        {
                            $m->to($request->email, $request->fullName)->subject("Your Request To Join Pipeline Was Approved!");
                        });
                    }

                    $request->inviteSent = "";
                    $request->save();

                    return "Approved the request and the sender was notified.";
                }
            }
        }
    }
    
    public function denyRequest(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["requestID"] = $request->input('requestID');
            $data["message"] = $request->input('message');
            $validator = Validator::make($request->all(),
                [
                    'requestID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $request = Requests::find($data["requestID"]);
                
                $request->whenSent = StringFormatter::getDifferenceBetweenDateTimeAndNow(strtotime($request->whenSent));
                                
                if (!is_null($request))
                {
                    RequestToInterests::where('requestID', $data["requestID"])->delete();
                    Requests::find($data["requestID"])->delete();
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.requestDenied', ['request' => $request, 'data' => $data], function ($m) use ($request)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Your Request To Join Pipeline Was Denied");
                        });
                    }
                    else
                    {
                        Mail::send('emails.requestDenied', ['request' => $request], function ($m) use ($request)
                        {
                            $m->to($request->email, $request->fullName)->subject("Your Request To Join Pipeline Was Approved!");
                        });
                    }

                    return "Deleted request and the sender was notified.";
                }
            }
        }
    }
    
    public function messageRequestSender(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["requestID"] = $request->input('requestID');
            $data["message"] = $request->input('message');
            $validator = Validator::make($request->all(),
                [
                    'requestID' => 'required',
                    'message' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $request = Requests::find($data["requestID"]);
                                
                if (!is_null($request))
                {
                    $data["message"] = nl2br($data["message"]);
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.defaultEmail', ['request' => $request, 'data' => $data], function ($m) use ($request)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("Message From Pipeline Regarding Your Request To Join");
                        });
                    }
                    else
                    {
                        Mail::send('emails.defaultEmail', ['request' => $request], function ($m) use ($request)
                        {
                            $m->to($request->email, $request->fullName)->subject("Message From Pipeline Regarding Your Request To Join");
                        });
                    }

                    $request->readStatus = "";
                    $request->save();
                    
                    return route('admin-requests');
                }
            }
        }
    }
    
    public function ndasPendingReview()
    {
        $data = array();
        $data["title"] = "NDAs Pending Review";
        
        $ndas = Users::select('NDA', 'fullName', 'userId')
            ->where('NDAStatus', "submitted")
            ->get();
        
        return view('admin/ndasPendingReview', compact('data', 'ndas'));
    }
    
    public function denyNDA(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["userID"] = $request->input('userID');
            $data["message"] = $request->input('message');
            $data["message"] = nl2br($data["message"]);
            $validator = Validator::make($request->all(),
                [
                    'userID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $user = Users::find($data["userID"]);
                if (!is_null($user))
                {
                    $currentNDAFile = glob("public/img/NDAs/" . $user->userId . ".*");
                    if (count($currentNDAFile))
                    {
                        foreach ($currentNDAFile as $file)
                        {
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }
                    
                    $user->NDAStatus = "unsigned";
                    $user->NDA = null;
                    $user->save();
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.ndaDenied', ['data' => $data], function ($m) use ($user)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("The NDA You Submitted Was Denied");
                        });
                    }
                    else
                    {
                        Mail::send('emails.ndaDenied', ['data' => $data], function ($m) use ($user)
                        {
                            $m->to($user->email, $user->fullName)->subject("The NDA You Submitted Was Denied");
                        });
                    }

                    return "Denied the NDA and the sender was notified.";
                }
            }
        }
    }
    
    public function approveNDA(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["userID"] = $request->input('userID');
            $data["numberOfConnectionsUpdated"] = 0;
            $validator = Validator::make($request->all(),
                [
                    'userID' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $user = Users::find($data["userID"]);
                if (!is_null($user))
                {
                    $user->NDAStatus = "approved";
                    $user->save();
                    
                    $connectionsInvolvingUser = Connections::where('creatorId', $data["userID"])
                        ->orWhere('interestedPartyId', $data["userID"])
                        ->get();
                    
                    foreach ($connectionsInvolvingUser as $connectionInvolvingUser)
                    {
                        if ($connectionInvolvingUser->interestedPartyId == $user->userId)
                        {
                            $otherParty = Users::find($connectionInvolvingUser->creatorId);
                        }
                        else if ($connectionInvolvingUser->creatorId == $user->userId)
                        {
                            $otherParty = Users::find($connectionInvolvingUser->interestedPartyId);
                        }
                        
                        if ($otherParty->NDAStatus == "approved")
                        {
                            $connectionInvolvingUser->status = "pending admin approval";
                            $connectionInvolvingUser->save();
                            $data["numberOfConnectionsUpdated"]++;
                        }
                    }
                    
                    if (config('app.debug'))
                    {
                        Mail::send('emails.ndaApproved', ['data' => $data], function ($m) use ($user)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject("The NDA You Submitted Was Approved");
                        });
                    }
                    else
                    {
                        Mail::send('emails.ndaApproved', ['data' => $data], function ($m) use ($user)
                        {
                            $m->to($user->email, $user->fullName)->subject("The NDA You Submitted Was Approved");
                        });
                    }

                    return "Approved the NDA and the sender was notified.";
                }
            }
        }
    }
    
    public function manageWebsite()
    {
        $data = array();
        $data["title"] = "Manage Website";
        
        $stringsXML = simplexml_load_file('./resources/values/strings.xml');
        $coloursXML = simplexml_load_file('./resources/values/colours.xml');
        
        $data["primaryColour"] = $coloursXML->all->colourPrimary;
        $data["textColourOnPrimary"] = $coloursXML->all->textColourOnPrimary;
        $data["backgroundColourTransparency"] = $coloursXML->all->backgroundColourTransparency;
        $data["creditsBackgroundColour"] = $coloursXML->loggedOut->credits->backgroundColour;
        
        $data["indexImages"] = array();
        $i = 0;
        foreach (glob("./public/img/Index/Row-*.*") as $filename) {
            $data["indexImages"][$i++] = $filename;
        }
        
        $data["rowOneHeader"] = $stringsXML->loggedOut->index->rowOne->title;
        $data["rowOneBody"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->index->rowOne->body));
        $data["rowTwoHeader"] = $stringsXML->loggedOut->index->rowTwo->title;
        $data["rowTwoBody"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->index->rowTwo->body));
        $data["credits"] =  $stringsXML->loggedOut->credits->body;
        $data["cookies"] =  $stringsXML->loggedOut->cookies;
        $data["termsAndConditions"] =  $stringsXML->loggedOut->termsAndConditions;
        
        return view('admin/manageWebsite', compact('data'));
    }
    
    public function updateTheme(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["primaryColour"] = $request->input('primaryColour');
            $data["textColourOnPrimary"] = $request->input('textColourOnPrimary');
            $data["backgroundColourTransparency"] = $request->input('backgroundColourTransparency');
            $validator = Validator::make($request->all(),
                [
                    'primaryColour' => 'required',
                    'textColourOnPrimary' => 'required',
                    'backgroundColourTransparency' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $coloursXML = simplexml_load_file('./resources/values/colours.xml');
                $coloursXML->all->colourPrimary = $data["primaryColour"];
                $coloursXML->all->backgroundColourTransparency = $data["backgroundColourTransparency"];
                $coloursXML->all->textColourOnPrimary = $data["textColourOnPrimary"];
                $coloursXML->asXml('./resources/values/colours.xml');
                return "Updated theme.";
            }
        }
    }
    
    public function updateHomepage(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["rowOneHeader"] = $request->input('rowOneHeader');
            $data["rowOneBody"] = $request->input('rowOneBody');
            $data["rowTwoHeader"] = $request->input('rowTwoHeader');
            $data["rowTwoBody"] = $request->input('rowTwoBody');
            $validator = Validator::make($request->all(),
                [
                    'rowOneHeader' => 'required',
                    'rowOneBody' => 'required',
                    'rowTwoHeader' => 'required',
                    'rowTwoBody' => 'required',
                    'rowOneImage' => 'bail|file|image|max:5000|mimes:jpg,png,jpeg,gif',
                    'rowTwoImage' => 'bail|file|image|max:5000|mimes:jpg,png,jpeg,gif',
                ]
            );
            if (!$validator->fails())
            {   
                $stringsXML = simplexml_load_file('./resources/values/strings.xml');
                $stringsXML->loggedOut->index->rowOne->title = $data["rowOneHeader"];
                $stringsXML->loggedOut->index->rowOne->body = htmlspecialchars($data["rowOneBody"]);
                $stringsXML->loggedOut->index->rowTwo->title = $data["rowTwoHeader"];
                $stringsXML->loggedOut->index->rowTwo->body = htmlspecialchars($data["rowTwoBody"]);
                $stringsXML->asXml('./resources/values/strings.xml');
                
                if (!is_null($request->rowOneImage))
                {
                    $currentRowOneImage = glob ("public/img/Index/Row-One_Image.*");
                    if (count($currentRowOneImage))
                    {
                        foreach ($currentRowOneImage as $file)
                        {
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }
                    move_uploaded_file($request->rowOneImage, "public/img/Index/" . "Row-One_Image." . $request->rowOneImage->extension());
                }
                
                if (!is_null($request->rowTwoImage))
                {
                    $currentRowTwoImage = glob ("public/img/Index/Row-Two_Image.*");
                    if (count($currentRowTwoImage))
                    {
                        foreach ($currentRowTwoImage as $file)
                        {
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }
                    move_uploaded_file($request->rowTwoImage, "public/img/Index/" . "Row-Two_Image." . $request->rowTwoImage->extension());
                }
                
                return "Updated homepage. If the images don't change after reloading the page, you may need to clear your cache.";
            }
        }
    }
    
    public function updateCredits(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["creditsBody"] = $request->input('creditsBody');
            $data["backgroundColour"] = $request->input('backgroundColour');
            $validator = Validator::make($request->all(),
                [
                    'creditsBody' => 'required',
                    'backgroundColour' => 'required',
                ]
            );
            if (!$validator->fails())
            {
                $data["creditsBody"] = str_replace('\r\n', "\n", $data["creditsBody"]);
                $stringsXML = simplexml_load_file('./resources/values/strings.xml');
                $coloursXML = simplexml_load_file('./resources/values/colours.xml');
                
                $stringsXML->loggedOut->credits->body = htmlspecialchars($data["creditsBody"], ENT_NOQUOTES);
                $stringsXML->asXml('./resources/values/strings.xml');

                $coloursXML->loggedOut->credits->backgroundColour = $data["backgroundColour"];
                $coloursXML->asXml('./resources/values/colours.xml');

                return "Updated the Credits page.";
            }
        }
    }
    
    public function updateCookie(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["cookie"] = $request->input('cookie');
            $validator = Validator::make($request->all(),
                [
                    'cookie' => 'required',
                ]
            );
            if (!$validator->fails())
            {   
                $data["cookie"] = str_replace('\r\n', "\n", $data["cookie"]);
                $stringsXML = simplexml_load_file('./resources/values/strings.xml');
                $stringsXML->loggedOut->cookies = htmlspecialchars($data["cookie"], ENT_NOQUOTES);
                $stringsXML->asXml('./resources/values/strings.xml');

                return "Updated the Cookies policy.";
            }
        }
    }
    
    public function updateTermsAndConditions(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["termsAndConditions"] = $request->input('termsAndConditions');
            $validator = Validator::make($request->all(),
                [
                    'termsAndConditions' => 'required',
                ]
            );
            if (!$validator->fails())
            {   
                $data["termsAndConditions"] = str_replace('\r\n', "\n", $data["termsAndConditions"]);
                $stringsXML = simplexml_load_file('./resources/values/strings.xml');
                $stringsXML->loggedOut->termsAndConditions = htmlspecialchars($data["termsAndConditions"], ENT_NOQUOTES);
                $stringsXML->asXml('./resources/values/strings.xml');

                return "Updated the terms and conditions.";
            }
        }
    }
    
    public function updateNDA(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = array();
            $data["NDA"] = $request->input('NDA');
            $validator = Validator::make($request->all(),
                [
                    'NDA' => 'required|file',
                ]
            );
            if (!$validator->fails())
            {   
                $NDAPath = "public/img/NDAs/nda.pdf";
                if (file_exists($NDAPath)) {
                    unlink($NDAPath);
                }
                move_uploaded_file($request->NDA, $NDAPath);
                return "Updated NDA file. If the file doesn't change after reloading the page, you may need to clear your cache.";
            }
        }
    }
}
