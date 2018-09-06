<?php

namespace App\Http\Controllers;

use Mail;
use Guid;
use Symfony\Component\HttpFoundation\Cookie as Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interest as Interest;
use App\Users as Users;
use App\ResetPasswordLinks as ResetPasswordLinks;
use App\Requests as Requests;
use App\RequestToInterests as RequestToInterests;
use App\SignUpLinks as SignUpLinks;

class GuestController extends Controller
{
    public function __construct(Interest $interests, Users $users, ResetPasswordLinks $resetPasswordLinks, Requests $requests, RequestToInterests $requestToInterests, SignUpLinks $signUpLinks)
    {
        $this->interests = $interests->all();
        $this->users = $users->all();
        $this->resetPasswordLinks = $resetPasswordLinks->all();
        $this->requests = $requests->all();
        $this->requestToInterests = $requestToInterests->all();
        $this->signUpLinks = $signUpLinks->all();
    }
    
    /**
     * @returns the front page every guest will see first
     */
    public function home()
    {
        $stringsXML = simplexml_load_file('./resources/values/strings.xml');
        
        $data = array();
        $listOfInterests = array();
        
        $data["title"] = "Home";
        $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
        $data["index_rowOne_body"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->index->rowOne->body));
        $data["index_rowOne_image"] = glob("public/img/Index/Row-One_Image.*")[0];
        $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
        $data["index_rowTwo_body"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->index->rowTwo->body));
        $data["index_rowTwo_image"] = glob("public/img/Index/Row-Two_Image.*")[0];
        
        $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
        
        return view('guest/home', compact('data', 'listOfInterests'));
    }
    
    /**
     * @returns the credits page that displays the team behind the website
     */
    public function credits()
    {
        $coloursXML = simplexml_load_file('./resources/values/colours.xml');
        $stringsXML = simplexml_load_file('./resources/values/strings.xml');
        
        $data = array();
        $listOfInterests = array();
        
        $data["title"] = "Credits";
        $data["backgroundColour"] = $coloursXML->loggedOut->credits->backgroundColour;
        
        $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
        $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
        $data["credits"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->credits->body));
        
        $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
        
        return view('guest/credits', compact('data', 'listOfInterests'));
    }
    
    public function termsAndConditions()
    {
        $coloursXML = simplexml_load_file('./resources/values/colours.xml');
        $stringsXML = simplexml_load_file('./resources/values/strings.xml');
        
        $data = array();
        $listOfInterests = array();
        
        $data["title"] = "Credits";
        $data["backgroundColour"] = $coloursXML->loggedOut->credits->backgroundColour;
        
        $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
        $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
        $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
        
        $data["termsAndConditions"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->termsAndConditions));
        
        return view('guest/termsAndConditions', compact('data', 'listOfInterests'));
    }
    
    /**
     * This method takes the user's entered email and passwords and tests to see if they're valid. If they are then 
     * it returns the name of the user, otherwise it'll return false.
     * 
     * @param request -Stores the form data
     * @returns whether or not the user was valid
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
        
            $data["email"] = $request->input('email');
            $data["password"] = $request->input('password');
            $data["keepMeSignedIn"] = $request->input('keepMeSignedIn');
            $validator = \Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'password' => 'required'
                ]
            );
            
            if (!$validator->fails())
            {
                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials))
                {
                    $userLoggingIn = Users::findByEmail($data["email"]);
                    Auth::login($userLoggingIn, $data["keepMeSignedIn"]);
                    
                    return response(explode(' ',trim($userLoggingIn->fullName))[0]);
                }
            }
        }
    }
    
    /**
     * This method takes the user's entered email and tests to see if they're valid. If they are then it returns
     * the name of the user, otherwise it'll return nothing.
     * 
     * @param request -Stores the form data
     * @returns the credits page that displays the team behind the website
     */
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
        
            $data["email"] = $request->input('email');
            
            $validator = \Validator::make(
                $request->all(),
                [
                    'email' => 'required'
                ]
            );
            
            if (!$validator->fails())
            {
                $listOfUsers = new Users();
                $user = $listOfUsers->findByEmail($data["email"]);

                if (count($user))
                {
                    $listOfLinks = new ResetPasswordLinks();
                    do
                    {
                        $guid = Guid::create();
                    }
                    while ($listOfLinks->linkExists($guid));

                    $linkURL = route('guest-resetPassword') . "/" . $guid;
                    $expirationDate = date("Y-m-d H:i:s", strtotime("+1 day"));

                    $listOfLinks->link = $guid;
                    $listOfLinks->expirationDate = $expirationDate;
                    $listOfLinks->save();

                    if (config('app.debug'))
                    {
                        Mail::send('emails.resetPassword', ['guid' => $guid, 'user' => $user], function ($m) use ($user) {
                            $m->to("davindeol@gmail.com", "Davin Deol")->subject('Reset Pipeline Password');
                        });
                    }
                    else
                    {
                        Mail::send('emails.resetPassword', ['guid' => $guid, 'user' => $user], function ($m) use ($user) {
                            $m->to($user->email, $user->fullName)->subject('Reset Pipeline Password');
                        });
                    }
                }
            }
        }
    }
    
    /**
     * This method takes the user's entered fields, checks to see if they're already registered. If they are, it'll return
     * false. Then it checks to see if the user has already submitted a request and if there is, it updates it. Once the
     * request has been inserted/updated, it emails the admins, letting them know that a request has been submitted.
     * 
     * @returns whether or not the request was successfully submitted/updated.
     */
    public function requestInvitation(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            $data["email"] = $request->input('email');
            $data["fullName"] = $request->input('fullName');
            $data["linkedInURL"] = ($request->input('linkedInURL') !== null) ? $request->input('linkedInURL') : '';
            $data["individualOrOrganization"] = $request->input('individualOrOrganization');
            $data["interests"] = ($request->input('interests') !== null) ? $request->input('interests') : array();
            
            $validator = \Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'fullName' => 'required',
                    'individualOrOrganization' => 'required'
                ]
            );
            
            if (!$validator->fails())
            {
                $user = Users::findByEmail($data["email"]);
                if (is_null($user))
                {
                    $request = Requests::findByEmail($data["email"]);
                    if (is_null($request))
                    {
                        do
                        {
                            $requestId = Guid::create();
                        }
                        while (Requests::find($requestId));

                        $newRequest = new Requests();
                        $newRequest->requestID = $requestId;
                        $newRequest->email = $data["email"];
                        $newRequest->fullName = $data["fullName"];
                        $newRequest->linkedInURL = $data["linkedInURL"];
                        $newRequest->individualOrOrganization = $data["individualOrOrganization"];
                        $newRequest->type = "user";
                        $newRequest->whenSent = date("Y-m-d H:i:s");
                        $newRequest->readStatus = null;
                        $newRequest->inviteSent = null;
                        $newRequest->save();

                        foreach ($data["interests"] as $interest)
                        {
                            $newRequestToInterests = new RequestToInterests();
                            $newRequestToInterests->requestID = $requestId;
                            $newRequestToInterests->interest = $interest;
                            $newRequestToInterests->save();
                        }
                    }
                    else
                    {

                        Requests::where('email', $data["email"])
                            ->update([
                                'fullName' => $data["fullName"],
                                'linkedInURL' => $data["linkedInURL"],
                                'individualOrOrganization' => $data["individualOrOrganization"],
                                'whenSent' => date("Y-m-d H:i:s"),
                            ]);
                        RequestToInterests::where('requestID', $requestId)->delete();
                        foreach ($data["interests"] as $interest)
                        {
                            $newRequestToInterests = new RequestToInterests();
                            $newRequestToInterests->requestID = $requestId;
                            $newRequestToInterests->interest = $interest;
                            $newRequestToInterests->save();
                        }
                    }

                    if (config('app.debug'))
                    {
                        Mail::send('emails.requestSent', ['data' => $data], function ($m) use ($data)
                        {
                            $m->to('davindeol@gmail.com', 'Davin Deol')->subject($data["fullName"] . ' Has Submitted A Request');
                        });
                    }
                    else
                    {
                        $adminEmails = Users::getEmailsByType('admin');
                        Mail::send('emails.requestSent', ['data' => $data], function ($m) use ($data, $adminEmails)
                        {
                            $m->to($adminEmails)->subject($data["fullName"] . ' Has Submitted A Request');
                        });
                    }

                    return "true";
                }
            }
        }
    }
    
    /**
     * This method takes the user's link, checks to see if it's valid, and if it is, returns a form for the
     * user to fill in so that we know which account to update.
     * 
     * @returns the view that holds the form
     */
    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $stringsXML = simplexml_load_file('./resources/values/strings.xml');
            
            $data = array();
            $data["title"] = "Reset Password";
            $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
            $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
            
            $listOfInterests = array();
            $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
            
            
            $data["link"] = $request->input('link');
            $data["email"] = $request->input('email');
            $listOfLinks = new ResetPasswordLinks();
                            
            if ($listOfLinks->linkExists($data["link"]))
            {
                return view('guest/resetPassword', compact('data', 'listOfInterests'));
            }
            else
            {
                return redirect()->route('guest-home');
            }
        }
    }
    
    /**
     * This method takes the user's link, checks to see if it's valid, and if it is, returns a form for the
     * user to fill in so that we know which account to update.
     * 
     * @returns the view that holds the form
     */
    public function resetPasswordSubmission(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            
            $data["userEmail"] = $request->input('email');
            $data["password1"] = $request->input('password1');
            $data["password2"] = $request->input('password2');
            
            $validator = \Validator::make(
                $request->all(),
                [
                    'password1' => 'required|min:8|same:password2',
                    'password2' => 'required',
                ],
                [
                    'required' => 'One field is empty.',
                    'min' => 'Your password must be at least :min characters long.',
                    'same' => 'The both passwords must match'
                ]
            );
            
            if (!$validator->fails())
            {
                $hash = password_hash($data["password1"], PASSWORD_DEFAULT, ['cost' => 9]);
                Users::where('email', $data["userEmail"])->update(['password' => $hash]);

                return "true";
            }
        }
    }
    
    public function cookiePolicy()
    {
        $stringsXML = simplexml_load_file('./resources/values/strings.xml');
        $data = array();
        $data["title"] = "Cookies";
        $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
        $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
        $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
        
        $data["cookiePolicy"] = stripslashes(htmlspecialchars_decode($stringsXML->loggedOut->cookies));
        return view('guest/cookiePolicy', compact('data', 'listOfInterests'));
    }
    
    public function signUp(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $stringsXML = simplexml_load_file('./resources/values/strings.xml');
            
            $data = array();
            $data["title"] = "Reset Password";
            $data["index_rowOne_header"] = $stringsXML->loggedOut->index->rowOne->title;
            $data["index_rowTwo_header"] = $stringsXML->loggedOut->index->rowTwo->title;
            
            $listOfInterests = array();
            $listOfInterests = $this->interests->where('interest', '!=' , 'None of the Above');
            
            
            $data["signUpLink"] = $request->input('signUpLink');
            $data["email"] = $request->input('email');
                            
            if (SignUpLinks::find($data["link"]))
            {
                return view('guest/signUp', compact('data', 'listOfInterests'));
            }
            else
            {
                return redirect()->route('guest-home');
            }
        }
    }
    
    public function signUpSubmission(Request $request)
    {
        if ($request->isMethod('post')) 
        {
            $data = array();
            
            $data["signUpLink"] = $request->input('signUpLink');
            $data["password1"] = $request->input('password1');
            $data["password2"] = $request->input('password2');
            
            $validator = \Validator::make(
                $request->all(),
                [
                    'signUpLink' => 'required',
                    'password1' => 'required|min:8|same:password2',
                    'password2' => 'required'
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'min' => 'Your password must be at least :min characters long.',
                    'same' => 'The confirmation password does not match the first password'
                ]
            );
            
            if (!$validator->fails())
            {
                $hash = password_hash($data["password1"], PASSWORD_DEFAULT, ['cost' => 9]);
                $signUpLink = SignUpLinks::with('request')
                    ->find($data["signUpLink"]);

                if (!is_null($signUpLink))
                {
                    $newUser = Users::create([
                        'userId' => Guid::create(),
                        'email' => $signUpLink->request->email,
                        'password' => $hash,
                        'fullName' => $signUpLink->request->fullName,
                        'linkedInURL' => $signUpLink->request->linkedInURL,
                        'individualOrOrganization' => $signUpLink->request->individualOrOrganization
                    ]);
                    $request = Requests::find($signUpLink->requestID);
                    $signUpLink->delete();
                    $request->delete();

                    Auth::login($newUser);
                    
                    return response(explode(' ',trim($newUser->fullName))[0]);
                }
            }
        }
    }
}
